<?php

namespace Application\Controller;

use Common\Validator\Check;
use Zend\Http\Header\SetCookie;
use Zend\Mvc\MvcEvent;


/**
 * Class IndexController
 *
 * @package Mobile\Controller
 * @author Robert Eichholtz <robert.eichholtz@check24.de>
 */
class MainController extends BaseController
{
    const RESULT_PAGE        = 'result_page';
    const TARIFF_DETAIL_PAGE = 'tariff_detail_page';
    const FAVORITE_PAGE      = 'favorite_page';

    /**
     * {@inheritdoc}
     */
    public function onDispatch(MvcEvent $e)
    {
        $this->assign('routeName', $e->getRouteMatch()->getMatchedRouteName());
        parent::onDispatch($e);
    }

    /**
     * get calculation client for mobile
     *
     * @return \shared\classes\calculation\client\client
     */
    protected function getCalculationClient($product_id = null)
    {
        return $this->createCalculationClient(
            'classes\calculation\mclient\client',
            $this->getDeviceType(),
            $product_id
        );
    }

    /**
     * Set generic layout variables
     */
    protected function assignGenericParameter()
    {
        /** @var \Zend\Http\Request $request */
        $request = $this->getRequest();

        // Assign Coupon Code
        $this->assignCouponCode();

        $this->assignCprefParameter();
        $this->assignPkvrefParameter();

        // C24login
        $this->assign('show_hotline',       $this->showHotline());
        $this->assign('service_email',      $this->getConfig('service')->email->{$this->getProductKey()});
        $this->assign('product_id',         $this->getProductId());
        $this->assign('product_key',        $this->getProductKey());
        $this->assign('logged_in',          $this->isLoggedIn());
        $this->assign('logged_in_expired',  $this->isExpiredSession());

        if ($this->isExpiredSession()) {
            $this->assign('user_data', $this->getExpiredUserData());
        } else {
            $this->assign('user_data', $this->getUserData());
        }

        $this->assign('phone_number',  get_def('register_phone_number/' . $this->getProductId()));

        // get product_id from uri with fallback
        $product_id = $this->getParam('product_id', $this->getProductId());

        // we assume that it comes always in portrait mode, so we need the short name
        $this->assign('headline', $this->getProduct($product_id)->short_name);

        $this->assign('footer_link',   $this->getProduct()->desktop_url);
        $this->assign('holding_communication_key',   $this->getProduct()->holding_communication_key);
        $this->assign('back_link',     '//m.check24.de/');
        $this->assign('page_title',    $this->getProduct()->form_title);
        $this->assign('page_description', '');
        $this->assign('is_c24login', !empty($this->get('C24Login')->get_user_data()));

        if ($request->getCookie() && $request->getCookie()->offsetExists('c24session')) {
            $this->assign('c24login_email', $this->getServiceLocator()->get('C24Login')->get_email_address($request->getCookie()->c24session));
        } else {
            $this->assign('c24login_email', NULL);
        }

        /** @var \classes\calculation\mclient\client $client */
        $client = $this->getCalculationClient();
        $client->set_force_current_timepoint('yes');
        $client->set_stats('yes');

        $this->assign('client', $client);

        //TODO: subject of refactoring thema PVPKV-1335
        $this->assign('tariffs', $this->getServiceLocator()->get('participating_tariff')->get_all());

        // the footer has by default NO top border
        $this->assign('footer_topborder', false);
    }

    /**
     * Assign cpref parameter
     *
     * Check the COOKIEs, set the parameter value for A/B test.
     * If the parameter is not found in COOKIEs, set randomly one of the allowed values
     * and save it in COOKIEs.
     *
     * @return void
     */
    protected function assignCprefParameter() {

        $allowedValues = [];

        $request = $this->getRequest();

        // Check COOKIEs for cpref parameter

        if ($request->getCookie() && $request->getCookie()->offsetExists('cpref')) {

            $cpref = $request->getCookie()->cpref;

            $this->assign('cpref', $cpref);
            return;

        }

        // Check GET parameter
        $cpref = $this->params()->fromQuery('cpref');

        if (!$cpref || !in_array($cpref, $allowedValues)) {

            // @TODO: Add here cpref A/B parameter logic

            if (rand(0, 1)) {
                // Some $cpref value here
            } else {
                // Some $cpref value here
            }

        }

        if ($cpref) {

            $response = $this->getResponse();

            $cookieLifetime = time() + 60 * 60 * 24 * 30; // 30 days COOKIE lifetime
            $response->getHeaders()->addHeader(
                new SetCookie('cpref', $cpref, $cookieLifetime, '/', $this->getCookieDomain())
            );

        }

        $this->assign('cpref', $cpref);

    }

    /**
     * Assign pkvref parameter
     *
     * Check the COOKIEs, set the parameter value for A/B test.
     * If the parameter is not found in COOKIEs, set randomly one of the allowed values
     * and save it in COOKIEs.
     *
     * @return void
     */
    protected function assignPkvrefParameter() {

        $request = $this->getRequest();

        // Check COOKIEs for cpref parameter

        if ($request->getCookie() && $request->getCookie()->offsetExists('pkvref')) {

            $pkvref = $request->getCookie()->pkvref;

            $this->assign('pkvref', $pkvref);
            return;

        }

        // Check GET parameter
        $pkvref = $this->params()->fromQuery('pkvref');

        if (!$pkvref || !($pkvref)) {

            $pkvref = Piwik::VARIANT_A;

            if (rand(0, 1)) {

                $pkvref = Piwik::VARIANT_B;
            }

        }

        if ($pkvref) {

            $response = $this->getResponse();

            $cookieLifetime = time() + 60 * 60 * 24 * 30; // 30 days COOKIE lifetime
            $response->getHeaders()->addHeader(
                new SetCookie('pkvref', $pkvref, $cookieLifetime, '/', $this->getCookieDomain())
            );

        }

        $this->assign('pkvref', $pkvref);

    }

    /**
     * Method to check if we have a ABTest tracking ID.
     *
     * If Tracking id for AB test is setted then return "2" else for the default view return "1"
     *
     * @return integer
     */
    protected function getAbtest() {

        $variant_a_value = 1;
        $variant_b_value = 2;

        $request = $this->getRequest();
        $request->getCookie()->pkvref;

        $arr_pkvref = explode ( '|', $request->getCookie()->pkvref );

        $str_pkvref = $arr_pkvref[1];

        if ($str_pkvref == get_def('abtest/abtest_b')) {

            // Check if we have a Desktop or mobile device,
            // because we dont want Search Engine Robots to index our AB Tests

            $device = new \shared\classes\calculation\client\form(
                $this->getDeviceOutput()
            );

            if ($device !== NULL) {
                return $variant_b_value;
            }

        }

        return $variant_a_value;

    }

    /**
     * Get profession name and insured person and change this in german.
     * The Result is a name from profession or child or servant-child in german.
     *
     * @param string $profession The name of profession
     * @param string $insured_person The name of insured_person
     *
     * @return string
     */
    protected function professionname_or_child_german($profession, $insured_person) {

        if (empty($profession)){
            $profession = ' ';
        }

        if (empty($insured_person)){
            $insured_person = ' ';
        }

        check_string($profession, 'profession');
        check_string($insured_person, 'insured_person');

            if ($insured_person == parameter\pkv::INSURED_PERSON_ADULT) {

                $helper = new parameter\pkv(array('profession' =>  $profession));
                $profession_german = $helper->get_profession_german();

            } else if ($insured_person == parameter\pkv::INSURED_PERSON_CHILD && $profession == parameter\pkv::PROFESSION_SERVANT) {
                $profession_german = piwik::PIWIK_SERVANT_CHILD;
            } else if($insured_person == parameter\pkv::INSURED_PERSON_CHILD && $profession != parameter\pkv::PROFESSION_SERVANT && $profession != parameter\pkv::PROFESSION_SERVANT_CANDIDATE) {
                $profession_german = piwik::PIWIK_CHILD;
            } else {
                $profession_german= '';
            }


        return $profession_german;

    }

    /**
     * Get cookie domain
     *
     * @return string The cookie domain
     */
    protected function getCookieDomain() {
        return $config = $this->serviceLocator->get('ZendConfig')->check24->cookie->domain;
    }

    /**
     * Get css content by directory
     *
     * @param string $dir Directory
     * @return string
     */
    protected function get_css($dir)
    {
        $files = glob($this->getConfig('document_root') . '/' . $dir . '/*');
        $css = '';

        for ($i = 0, $i_max = count($files); $i < $i_max; ++$i)
        {
            if (strpos($files[$i], 'combined') !== false) {
                // skip
            } else {
                $css .= @file_get_contents($files[$i]);
            }
        }

        $css = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $css);
        $css = str_replace(': ', ':', $css);
        $css = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $css);

        return $css;
    }

    /**
     * Get google conversion pixel
     *
     * @param integer $product_id Product id
     * @param string $type Type
     * @param integer $partner_id Partner id
     * @return string
     */
    public function getGoogleConversionPixel($product_id, $type, $partner_id)
    {
        Check::is_integer($product_id, 'product_id');
        Check::is_integer($partner_id, 'partner_id');
        Check::is_string($type, 'type', false, array('online', 'offline'));

        return googleconversionpixel::generate(
            $product_id,
            $type,
            $partner_id,
            $this->getWpset()->get_tracking_id($product_id)
        );
    }

    /**
     * Form action
     *
     * @return mixed
     */
    public function formAction() {

    }

    /**
     * Get calculationparameter
     *
     * @throws \shared\classes\common\exception
     * @throws \shared\classes\common\exception\argument
     * @throws \shared\classes\common\exception\logic
     * @return \classes\calculation\client\model\parameter\pkv
     */
    protected function get_calculationparameter($calculationparameter_id = NULL) {

        check_string($calculationparameter_id, 'calculationparameter_id');

        $product_id = get_def('product_id');

        $calculation_client = $this->getCalculationClient($product_id);

        $calculationparameter = $calculation_client->get_calculationparameter($product_id, $calculationparameter_id);

        return $calculationparameter;

    }

    /**
     * It tells us on which page we are
     *
     * @return string
     */
    protected function get_page_name() {
        return '';
    }

}
