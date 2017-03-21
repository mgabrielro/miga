<?php

namespace Mobile\Controller;

use classes\calculation\mclient\model\parameter\pkv;
use Common\Controller\BaseController;
use Check24\Piwik\CustomVariable as PiwikCustomVariable;
use classes\calculation\client\model\parameter;

/**
 * Class IndexController
 *
 * @package Mobile\Controller
 * @author Robert Eichholtz <robert.eichholtz@check24.de>
 */
class ResultController extends MainController
{

    /**
     * Index action
     *
     * @return \Zend\Http\Response
     */
    public function indexAction()
    {
        /** @var \Zend\Http\Request $request */
        $request = $this->getRequest();

        if ($request->getQuery()->count() === 0) {
            return $this->redirect()->toRoute('mobile/pkv/input1');
        }

        // Referrer
        $this->handleReferrer($request);

        // Handle pkvfavorites COOKIE
        $this->handlePkvfavoritesMobile();

        // set generic layout variables
        $this->assignGenericParameter();

        // assign assets
        $this->assign('js', file_get_contents($this->getConfig('document_root') . '/massets/js/includes/result.js'), true);
        $this->assign('js', file_get_contents($this->getConfig('document_root') . '/massets/js/includes/c24.vv.pkv.widget.result.result_per_email.js'), true);
        $this->assign('js', file_get_contents($this->getConfig('document_root') . '/massets/js/includes/favorite/c24.vv.pkv.favorite.js'), true);
        $this->assign('js', file_get_contents($this->getConfig('document_root') . '/massets/js/includes/piwik.js'), true);
        $this->assign('common_css', $this->get_css('massets/css/common/'));
        $this->assign('result_css', $this->get_css('massets/css/result/'));
        $this->assign('favorite_css', $this->get_css('massets/css/favorite/'));

        // Load PLZ by logged user as proposal by search
        // @TODO City autocomplete not realized. User can not search without field 'city'

        if (empty($request->getQuery('c24api_zipcode')) && $request->getCookie() && $request->getCookie()->offsetExists('c24session'))
        {
            $query = $request->getQuery();
            $query->offsetSet('c24api_zipcode', $this->get('C24Login')->get_zipcode($request->getCookie()->c24session));
            $request->setQuery($query);
        }

        /** @var \shared\classes\calculation\client\controllerstatus $status */
        $status = $this->get('classes\calculation\mclient\controller\pkv\result')->run();

        /** @var array $api_content */
        $api_content = $status->get_output();

        /** @var string $calculationparameter_id */
        $calculationparameter_id = '';

        /** @var array $match */
        $match = array();

        if (!empty($api_content['back_link']) && preg_match('/([\dabcdef]{32})/', $api_content['back_link'], $match) > 0) {
            $calculationparameter_id = $match[1];
        }

        if ($calculationparameter_id == '' && preg_match('/([\dabcdef]{32})/', $api_content['result'], $match) > 0) {
            $calculationparameter_id = $match[1];
        }

        try {
            $this->assign('price_calc_params', $this->get(\Common\Provider\PriceCalculationParameter::class)
                ->fetch($this->get_calculationparameter($calculationparameter_id)->get_insure_date()));
        } catch (\Exception $e) {
            $this->assign('price_calc_params', $this->get(\Common\Provider\PriceCalculationParameter::class)
                ->fetch(date('Y')));
        }

        $this->assign('back_link', $api_content['back_link']);
        $this->assign('ssl', $this->getProtocol());

        if (!empty($api_content['head_title'])) {
            $this->assign('head_title', $api_content['head_title']);
        }

        $this->assign('page_title', $this->getProduct()->form_title);
        $this->assign('page_description', $this->getProduct()->form_desc);
        $this->assign('profession', $this->getQuery('c24api_profession'));
        $this->assign('insured_person', $this->getQuery('c24api_insured_person'));
        $this->assign('actual_page', $this->get_page_name());

        $profession_piwik = $this->professionname_or_child_german($this->getQuery('c24api_profession'), $this->getQuery('c24api_insured_person'));

        $piwikCustomVariables = [
            new PiwikCustomVariable(1, 'Deviceoutput', $this->getDeviceOutput()),
            new PiwikCustomVariable(2, 'Berufstand', $profession_piwik)
        ];

        return $this->getViewModel('mobile/pkv/form.phtml', [
            'result_head'     => $api_content['head'],
            'result_header_filter' => $api_content['filter'],
            'result'          => $api_content['result'],
            'result_footer'   => $api_content['footer'],
            'generaltracking' => $this->getGeneralTracking(),
            'piwik' => [
                'page' => 'result',
                'vars' => $piwikCustomVariables
            ]
        ]);
    }

    /**
     * It tells us on which page we are
     *
     * @return string
     */
    protected function get_page_name() {
        return self::RESULT_PAGE;
    }
}