<?php

namespace Mobile\Controller;

use GuzzleHttp\Exception\ClientException;
use Check24\Piwik\CustomVariable as PiwikCustomVariable;

class CompareController extends MainController
{
    public function indexAction()
    {
        // Handle pkvfavorites COOKIE
        $this->handlePkvfavoritesMobile();

        $calculationParameterId = preg_replace('/[^a-zA-Z0-9]*/', '', $this->params()->fromRoute('calculationparameter_id', ''));
        $tariff1 = intval($this->params()->fromRoute('tarif1'));
        $tariff2 = intval($this->params()->fromRoute('tarif2'));

        if ($tariff1 <= 0 || $tariff2 <= 0 || empty($calculationParameterId)) {
            return $this->redirect()->toRoute('mobile/pkv/input1');
        }

        /** @var \Common\Provider\TariffFeature $featuresProvider */
        /** @var \Common\Provider\TariffDetails $detailsProvider */
        $featuresProvider = $this->getServiceLocator()->get('Common\Provider\TariffFeature');
        $detailsProvider = $this->getServiceLocator()->get('Common\Provider\TariffDetails');

        $tariffs = [];
        try {
            foreach ([1 => $tariff1, 2 => $tariff2] as $i => $tariffVersionId) {
                $details = $detailsProvider->fetchParameterAndDetails($calculationParameterId, $tariffVersionId);

                $tariffs[$i] = [
                    'parameter' => $details['parameter'],
                    'details' => $details['details'],
                    'features' => $featuresProvider->fetchFeatures($calculationParameterId, $tariffVersionId, true),
                ];
            }
        } catch (Exception $e) {
            return $this->redirect()->toRoute('mobile/pkv/input1');
        } catch (ClientException $e) {
            return $this->redirect()->toRoute('mobile/pkv/input1');
        }

        $this->assign('compare_css', $this->get_css('massets/css/compare/'));
        $this->assign('js', file_get_contents($this->getConfig('document_root') . '/massets/js/includes/compare.js'), true);
        $this->assign('js', file_get_contents($this->getConfig('document_root') . '/massets/js/includes/favorite/c24.vv.pkv.favorite.js'), true);
        $this->assign('product_id', get_def('product_id'));
        $this->assign('logged_in', !empty($this->get('C24Login')->get_user_data()['user_id']));
        $this->assign('user_data', $this->getUserData());
        $this->assign('phone_number',  get_def('register_phone_number/' . $this->getProductId()));
        $this->assign('page_title',  $this->getProduct()->form_title);
        $this->assign('headline', $this->getProduct()->short_name);

        /**
         * NOTE: This initializes the calculation client required for general tracking, please do not remove unless
         *       you've removed the dependency on this client from the general tracking trait.
         *
         * @see \Common\Controller\Traits\TrackingTrait::generateGeneralTrackingPixel()
         */
        $this->assign('client', $this->getCalculationClient());

        $profession_piwik = $this->professionname_or_child_german($this->get_calculationparameter($calculationParameterId)->get_profession(), $this->get_calculationparameter($calculationParameterId)->get_insured_person());

        $piwikCustomVariables = [
            new PiwikCustomVariable(1, 'Deviceoutput', $this->getDeviceOutput()),
            new PiwikCustomVariable(2, 'Berufstand', $profession_piwik)
        ];

        return [
            'calculationparameter_id' => $calculationParameterId,
            'tariffs' => $tariffs,
            'generaltracking_pv'  => $this->generateGeneralTrackingPixel(10, 'Detailvergleich'), // Product ID 10 is Personenversicherung
            'generaltracking_pkv' => $this->generateGeneralTrackingPixel($this->getProductId(), 'compare'),
            'piwik' => [
                'page' => 'detailscompare',
                'vars' => $piwikCustomVariables
            ]

        ];
    }
}