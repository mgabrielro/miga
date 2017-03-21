<?php

namespace Mobile\Controller;

use Check24\Piwik\CustomVariable as PiwikCustomVariable;
use Common\BPM\Client;
use Common\Controller\BaseController;
use shared\classes\calculation\client\controllerstatus;
use Zend\Http\Header\SetCookie;
use Zend\Http\Request;
use Zend\View\Model\ViewModel;

/**
 * Class IndexController
 *
 * @package Mobile\Controller
 * @author Robert Eichholtz <robert.eichholtz@check24.de>
 */
class Input1Controller extends MainController
{
    /**
     * Login user
     *
     * @return \Zend\Http\Response
     */
    public function indexAction()
    {
        /** @var \Zend\Http\Request $request */
        $request = $this->getRequest();

        // Referrer
        $this->handleReferrer($request);

        // Handle pkvfavorites COOKIE
        $this->handlePkvfavoritesMobile();

        // set generic layout variables
        $this->assignGenericParameter();

        $this->assign('js', file_get_contents($this->getConfig('document_root') . '/massets/js/includes/form.js'), true);
        $this->assign('js', file_get_contents($this->getConfig('document_root') . '/massets/js/includes/favorite/c24.vv.pkv.favorite.js'), true);
        $this->assign('common_css', $this->get_css('massets/css/common/'), true);
        $this->assign('result_css', $this->get_css('massets/css/result/'), true);

        $this->prefillFromBPM($request, $this->getResponse());

        // Load PLZ by logged user as proposal by search
        // @TODO City autocomplete not realized. User can not search without field 'city'

        if (empty($request->getQuery('c24api_zipcode')) && $request->getCookie() && $request->getCookie()->offsetExists('c24session'))
        {
            $query = $request->getQuery();
            $query->offsetSet('c24api_zipcode', $this->get('C24Login')->get_zipcode($request->getCookie()->c24session));
            $request->setQuery($query);
        }

        /** @var \shared\classes\calculation\client\controllerstatus $status */
        $status = $this->get('classes\calculation\mclient\controller\pkv\form')->run();

        /**
         * Redirect to result page on Form validated successful
         */
        if (!in_array($status->get_status(), [controllerstatus::SUCCESS, controllerstatus::FORM_ERROR]) && $this->is_not_input2())
        {

            /**
             * Here we need the calculationparameter_id as key, in order
             * to correctly receive it in the URL as c24api_calculationparameter_id,
             * or else we will receive c24api_id, which will produce the PVPKV-2989 BUG,
             * so the calculationparameter_id will not be renewed in the URL
             */
            $parameters = $status->get_response()->get_data('parameter');

            $parameters['calculationparameter_id'] = $parameters['id'];
            unset($parameters['id']);


            /**
             * We also set a flag (from_input1) in order to know from which page are we coming.
             *
             * In case we are comming from Input1 page, we send forward the calculationparameter_id
             * when we request the calculation server, but if we are not coming from Input1
             * then we have to unset the calculationparameter_id, because else we won't receive a new calculation
             */
            $parameters['from_input1'] = 'yes';

            return $this->redirect()->toRoute(
                'mobile/pkv/result',
                [],
                ['query' => ['c24_calculate' => 'x', 'deviceoutput' => $request->getQuery()->get('deviceoutput')] + array_prefix('c24api_', $parameters)]
            );

        }  

        $profession_piwik = $this->professionname_or_child_german($this->getQuery('c24api_profession'), $this->getQuery('c24api_insured_person'));

        $piwikCustomVariables = [
            new PiwikCustomVariable(1, 'Deviceoutput', $this->getDeviceOutput()),
            new PiwikCustomVariable(2, 'Berufstand', $profession_piwik)
        ];

        return $this->getViewModel('mobile/pkv/form.phtml', [
            'result'          => $status->get_output(),
            'generaltracking' => $this->getGeneralTracking(),
            'piwik' => [
                'page' => $this->is_not_input2() ? 'input1' : 'input2',
                'vars' => $piwikCustomVariables
            ]
        ]);

    }

    /**
     * Check for a BPM cookie and prefill values using BPM if we're not logged in
     *
     * @param Request $request
     * @param \Zend\Http\Response $response
     */
    private function prefillFromBPM(\Zend\Http\Request $request, \Zend\Http\Response $response)
    {
        $cookie = $request->getCookie();
        $query = $request->getQuery();

        /** @var \Common\BPM\Client $bpm */
        $bpm = $this->getServiceLocator()->get('Common\BPM\Client');

        $hash = sha1(microtime());

        // Load BPM values
        if ($cookie && $cookie->offsetExists('bpm') && !empty($cookie->bpm)) {
            $hash = $cookie->bpm;
            $data = $bpm->get($hash);

            foreach ($data as $key => $value) {
                if (! $query->offsetExists($key)) {
                    $query->set($key, $value);
                }
            }

            $request->setQuery($query);
        }

        // And save if this is a form submit
        if ($query->offsetExists('c24_calculate')) {
            $store = [];
            foreach ($bpm->getFieldMap() as $key) {
                if ($query->offsetExists($key)) {
                    $store[$key] = $query->get($key);
                }
            }

            if ($store) {
                $bpm->set($hash, $store);
                $cookie = new SetCookie('bpm', $hash, time() + Client::COOKIE_EXPIRE, '/', $bpm->getCookieDomain());
                $response->getHeaders()->addHeader($cookie);
            }
        }

    }

    /**
     * Check if it was called the input 2 page instead of the result one.
     *
     * @todo Replace this with a separate controller action and view
     * @return boolean
     */
    private function is_not_input2()
    {
        return $this->getRequest()->getQuery('c24_calculate') !== 'x';
    }

    /**
     * Oauth closing page
     *
     * @return ViewModel
     */
    public function oauthCloseAction()
    {

        $view = $this->getViewModel('mobile/oauth/close.phtml', [
            'callback' => $this->getQuery('callback')
        ]);

        $view->setTerminal(true);

        return $view;

    }
}