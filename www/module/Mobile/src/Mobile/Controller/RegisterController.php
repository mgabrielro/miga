<?php

namespace Mobile\Controller;

use Common\BPM\Client;
use Common\Exception\InvalidArgumentException;
use Common\Validator\Check;
use Composer\Package\Loader\ValidatingArrayLoader;
use \shared\classes\common\utils;
use classes\register\registercontroller as RegisterInterface;
use classes\register\registermanager;
use vv\Oauth;
use Zend\Http\Header\SetCookie;
use Check24\Piwik\CustomVariable as PiwikCustomVariable;


/**
 * Class RegisterController
 *
 * @package Mobile\Controller
 * @author Robert Eichholtz <robert.eichholtz@check24.de>
 */
class RegisterController extends MainController implements RegisterInterface {

    /**
     * Index action
     *
     * @return mixed
     */
    public function indexAction() {

        /** @var \Zend\Http\Request $request */
        $request = $this->getRequest();

        // set generic layout variables
        $this->assignGenericParameter();

        // Handle pkvfavorites COOKIE
        $this->handlePkvfavoritesMobile();

        // get step parameter from uri
        $step = $this->getParam('step');

        // get product_id from uri with fallback
        $product_id = $this->getParam('product_id', $this->getProductId());

        // get the subscriptiontype from uri
        $subscriptiontype = $this->getParam('subscriptiontype');

        $this->assign('subscriptiontype', $subscriptiontype);

        // get registercontainer_id parameter from uri
        $registercontainer_id = $this->getParam('registercontainer_id');

        // get calculation client
        $client = $this->getCalculationClient($product_id);

        // get optional parameter
        $login_type = $this->getParam('login_type');

        if (!product_id_exists($product_id)) {
            return $this->notFoundAction();
        }

        // assign coupon code
        $this->assignCouponCode($product_id);

        $this->assign('client', $client);
        $this->assign('register_step', $step);

        /** @var \classes\register\registermanager $registermanager */
        $registermanager  = $this->get("RegisterManager");
        $register_results = $registermanager->run($step);

        if (null !== $register_results && $register_results != 'refresh_converted') {
            return $register_results;
        }

        if ($register_results != 'refresh_converted') {
            $calc_parameter  = $registermanager->get_calculationparameter()->get_data();
        } else {
            $calc_parameter = null;
        }

        $assigned_layout = $registermanager->get_assigned_layout();

        $this->assign('calculationparameter', $registermanager->get_calculationparameter());
        $this->assign('calculation_parameter_id', $calc_parameter['id']);
        $this->assign('insured_person', $calc_parameter['insured_person']);
        $this->assign('is_child', ($calc_parameter['insured_person'] == \classes\calculation\client\model\parameter\pkv::INSURED_PERSON_CHILD) ? true : false);
        $this->assign('is_servant_child', ($calc_parameter['parent_servant_or_servant_candidate'] == 'yes') ? true : false);
        $this->assign('is_servant', ($calc_parameter['profession'] == \classes\calculation\client\model\parameter\pkv::PROFESSION_SERVANT || $calc_parameter['profession'] == \classes\calculation\client\model\parameter\pkv::PROFESSION_SERVANT_CANDIDATE) ? true : false);
        $this->assign('profession', $calc_parameter['profession']);
        $this->assign('is_employee', ($calc_parameter['profession'] == 'employee') ? true : false);
        $this->assign('children_age', (int) $calc_parameter['children_age']);

        if ($step == 'address') {

            $this->assign('tariff_feature_grade', number_format($registermanager->get_registertariff()->get_tariff_feature()['global']['content']['grade'], 1, ',', NULL));

            $tariff_grade_helper = new \classes\calculation\client\controller\helper\generate_tariffgrade_pkv($registermanager->get_registertariff());
            $this->assign('tariff_feature_description', $tariff_grade_helper->get_grade_description($registermanager->get_registertariff()->get_tariff_feature()['global']['content']['grade']));

        }

        foreach ($assigned_layout AS $key => $value) {
            $this->assign($key, $value);
        }

        // set generic layout variables
        $this->assign('headline',   $this->getProduct($product_id)->short_name);
        $this->assign('product_id', $product_id);
        $this->assign('holding_communication_key', $this->getProduct($product_id)->holding_communication_key);
        $this->assign('footer_link', $this->getProduct($product_id)->desktop_url);
        $this->assign('service_email', $this->getConfig('service')->email->{$this->getProductKey($product_id)});
        $this->assign('add_css_register', true);
        $this->assign('page_title', $this->getProduct($product_id)->form_title);
        $this->assign('page_description', $this->getProduct($product_id)->form_desc);

        /* TODO: Stay commented until Input1 is ready */

        $home_link_params = $this->get_home_link_query_string_params($calc_parameter);
        $this->assign('home_link', $this->url()->fromRoute('mobile/pkv/input1') . '?' . http_build_query($home_link_params));

        $profession_piwik = $this->professionname_or_child_german($calc_parameter['profession'], $calc_parameter['insured_person']);

        $piwikCustomVariables = [
            new PiwikCustomVariable(1, 'Deviceoutput', $this->getDeviceOutput()),
            new PiwikCustomVariable(2, 'Berufstand', $profession_piwik)
        ];

        $assigned_data['page'] = $this->getTrackingPageName();
        $assigned_data['gtm_page'] = $this->getTrackingPageName('', 'gtm');
        $assigned_data['vars'] = $piwikCustomVariables;

        if($register_results != 'refresh_converted') {
            $assigned_data['step_view'] = $registermanager->get_step_view();
            $assigned_data['step_data'] = $registermanager->get_assigned_data();
        }
        
        $assigned_data['step_data']['registercontainer_id'] = $registercontainer_id;
        $assigned_data['step_data']['product_id'] = $product_id;

        $form = $registermanager->get_form();

        // Check for login error messages
        $logincontainer = new \Zend\Session\Container(
            'login', $this->getServiceLocator()->get('Common\Session\Manager')
        );

        $this->prefillFromBPM($request, $this->getResponse(), $form);

        if ($logincontainer->offsetExists('form'))
        {
            /** @var \classes\form $loginform */
            $loginform = $logincontainer->offsetGet('form');

            /**
             * We need to check whether validation errors exist and then set them to the form.
             * Error messages are also saved in sessions. The trouble is, that these messages
             * don't disappear after a reload or after visiting another offer.
             */
            if ($logincontainer->offsetExists('validation_errors')
                && $logincontainer->offsetGet('validation_errors')
                || $logincontainer->offsetExists('login_error')
                && $logincontainer->offsetGet('login_error')
            ) {

                $form->setMessages($loginform->getMessages());
                $logincontainer->offsetSet('validation_errors', false);
                $logincontainer->offsetSet('login_error', false);

            }

            $form->setData($loginform->getData());
        }

        $form->setAttribute('data-ajax', 'false');
        $form->setAttribute('id', 'c24-form');
        $form->setAttribute('action', $this->url()->fromRoute(
            'mobile/pkv/register',
            [
                'registercontainer_id' => $registercontainer_id,
                'product_id'           => $product_id, 'step' => $step,
                'subscriptiontype'     => $subscriptiontype
            ]

        )  . '?deviceoutput=' . $this->getDeviceOutput());

        $this->handleFormError($registermanager, $step);

        $assigned_data['steps']                             = $registermanager->get_steps();
        $assigned_data['step_data']['form']                 = $form;
        $assigned_data['step_data']['login_type']           = $login_type;
        $assigned_data['step_data']['session']              = $this->getSession();
        $assigned_data['step_data']['cs_code']              = $this->getCoupon();
        $assigned_data['step_data']['information']          = $registermanager->get_step_information();
        $assigned_data['step_data']['registertariff']       = $registermanager->get_registertariff();
        $assigned_data['step_data']['calculationparameter'] = $registermanager->get_calculationparameter();
        $assigned_data['step_data']['login'] = [
            'user'     => $this->url()->fromRoute('user/login'),
            'register' => $this->url()->fromRoute('user/register'),
            'recover'  => $this->url()->fromRoute('user/recover')
        ];


        /** @var \Zend\Http\Header\Cookie $cookie */
        $cookie = $this->getRequest()->getHeaders()->get('Cookie');

        if ($cookie && $cookie->offsetExists('c24session')) {
            $assigned_data['step_data']['c24session'] = $cookie->offsetGet('c24session');
        }

        // Generaltracking
        // @ToDo: We should think about inherit the right product id
        $generaltracking = new \stdClass();
        $generaltracking->pixel = $this->generateGeneralTrackingPixel(10, $step, null, $subscriptiontype);
        $generaltracking->action = $this->generateGeneralTrackingAction($product_id, $step, $subscriptiontype);
        $assigned_data['generaltracking'] = $generaltracking;

        $request_params = $this->params()->fromQuery();

        // C24login
        $this->assign('c24login', $this->get('C24Login'));
        $this->assign('is_c24login', isset($cookie['c24session']));

        if (!in_array($step, ['c24login_type', 'converted'])) {
            $this->assign('js', file_get_contents($this->getConfig('document_root') . '/massets/js/includes/'. $step . '.js'), true);
        }

        /**
         * here we don't have the subscription type anymore, so we get it from the registermanager
         * where it was set here: www\module\classes\register\steps\converted.class.php
         */
        if ($step == 'converted') {

            $session_container = $this->getServiceLocator()->get('SessionContainer');

            if ($register_results != 'refresh_converted') {

                $subtype = $registermanager->get_assigned_data()['subscriptiontype'];
                $assigned_data = array_merge($registermanager->get_assigned_data(),$assigned_data);

                $session_container->product_id          = $assigned_data['lead']['product_id'];
                $session_container->offer_id            = $assigned_data['offer_id'];
                $session_container->provider_name       = $assigned_data['lead']['provider_name'];
                $session_container->availability        = $assigned_data['availability'];
                $session_container->phone_number        = $assigned_data['phone_number'];
                $session_container->subscriptiontype    = $registermanager->get_assigned_data()['subscriptiontype'];

                if ($registermanager->get_assigned_data()['subscriptiontype'] == 'offer') {
                    $session_container->tariff_name     = $registermanager->get_assigned_data()['lead']['tariff_name'];
                }

                $assigned_data['email_md5'] = md5($assigned_data['lead']['email']);

            } else {

                $profession_piwik = $this->professionname_or_child_german($calc_parameter['profession'], $calc_parameter['insured_person']);

                $piwikCustomVariables = [
                    new PiwikCustomVariable(1, 'Deviceoutput', $this->getDeviceOutput()),
                    new PiwikCustomVariable(2, 'Berufstand', $profession_piwik)
                ];

                $subtype =  $session_container->subscriptiontype;

                $data = array();
                $data['offer_id']       = $session_container->offer_id;
                $data['provider_name']  = $session_container->provider_name;
                $data['availability']   = $session_container->availability;
                $data['product_id']     = $session_container->product_id;
                $data['phone_number']   = $session_container->phone_number;


                $assigned_data['step_data'] = $data;
                $assigned_data['step_view'] = 'converted.phtml';

                if ($subtype == 'offer') {
                    $assigned_data['step_data']['tariff_name'] = $session_container->tariff_name;
                }

            }

            $this->assign('subscriptiontype', $subtype);
            $assigned_data['page'] = $this->getTrackingPageName($subtype);
            $assigned_data['gtm_page'] = $this->getTrackingPageName($subtype, 'gtm');
            $assigned_data['vars'] = $piwikCustomVariables;

        }

        //Flag to inform frontend if the user has the needed data in SSO to close the deal
        $address_data_complete = false;
        $sso_user_has_mobile = false;
        $switched_from_bestsso_to_form = 'no';

        if ($step == 'address') {


            $assigned_data['step_data']['customer_account_view'] = 'default';
            $oauth = new Oauth(\classes\config::get('environment'), $this->getProduct($product_id)->holding_communication_key, 'mobile');
            $assigned_data['step_data']['app_login_referrer'] = explode('://',$this->request->getUri()->toString())[1];

            $assigned_data['step_data']['social_buttons'] = $oauth->generateOauthUrlArray($this->request->getUri()->toString());

            $oauth_error = false;
            if($this->get_url_parameter_value('oauth_result') == 'error') {
                $oauth_error = true;
            }

            $assigned_data['step_data']['oauth_error']['error'] = $oauth_error;
            $assigned_data['step_data']['oauth_error']['text'] = $this->get_url_parameter_value('oauth_error');
            /**
             * $form has already been processed and data set with $loginform
             * email will be in $form, even we have an SSO login
             */
            $assigned_data['step_data']['c24_customer_login_email'] = $form->getElements()['email']->getValue();

            /**
             * @var \classes\myc24login $c24_login
             */
            $c24_login = $this->get('C24Login');

            $userData = $c24_login->get_user_data();

            $assigned_data['step_data']['user_data'] = $userData;
            $assigned_data['step_data']['subscriptiontype'] = $subscriptiontype;

            if (!empty($userData)) {

                $sso_user_has_mobile = false;

                if (!empty($userData['prefixmobile']) && !empty($userData['mobile'])
                    && $this->is_mobile_phone($userData['prefixmobile'], $userData['mobile'])) {
                    $sso_user_has_mobile = true;
                }

                // Flag to inform frontend if the user has the needed data in SSO to close the deal
                $address_data_complete = $this->address_data_complete($userData);

                // Flag to inform Frontend if the user switched from best sso to formular
                $switched_from_bestsso_to_form = $this->params()->fromPost('switched_from_bestsso_to_form') ?: 'no';

                $assigned_data['step_data']['customer_account_view'] = 'user_logged_in';
                $assigned_data['step_data']['c24login_user_id'] = $this->get('C24Login')->get_user_data()['user_id'];

                $formElements = $form->getElements();

                $c24_customer_login_title = ucwords(strtolower(trim($formElements['title']->getValue())));

                if (!empty($form->getElements()['lastname']->getValue())) {
                    $assigned_data['step_data']['c24_customer_login_lastname'] = $formElements['lastname']->getValue();
                    $assigned_data['step_data']['c24_customer_login_gender']   = $formElements['gender']->getValue();
                    $assigned_data['step_data']['c24_customer_login_title']    = $c24_customer_login_title;
                }

                // solve the naming compatibility
                $userData['phoneprefix'] = $userData['prefixphone'];

                // Update the form elements with SSO values if available

                foreach ($userData as $key => $value) {

                    if ( in_array($key, ['phone']) && !$sso_user_has_mobile) {

                        $postedVal = $this->params()->fromPost($key);
                        $newVal    = ($postedVal && is_numeric($postedVal)) ? $postedVal : '';

                        $formElements[$key]->setValue($newVal);

                    } else if($key === 'title') {

                        $formElements['title']->setValue($c24_customer_login_title);

                    } else {

                        if (isset($formElements[$key]) && (!empty($value)) ) {
                            $formElements[$key]->setValue($value);
                        }

                    }

                }

                // Use mobile phone number if available but don't override previously POSTed values
                if ($sso_user_has_mobile && !$this->params()->fromPost('phone')) {
                    $formElements['phone']->setValue($userData['prefixmobile'] . $userData['mobile']);
                }

            } elseif (!empty($assigned_data['step_data']['c24session'])) {

                try {
                    $assigned_data['step_data']['c24_customer_login_email'] = $c24_login->user_validate($assigned_data['step_data']['c24session'], true)['email'];
                } catch (\Exception $e) {
                    $assigned_data['step_data']['c24_customer_login_email'] = '' ;
                }

            }

            // set frontend flags
            $assigned_data['step_data']['address_data_complete'] = $address_data_complete;
            $assigned_data['step_data']['sso_user_has_mobile'] = $sso_user_has_mobile;
            $assigned_data['step_data']['switched_from_bestsso_to_form'] = $switched_from_bestsso_to_form;

            $this->assign('js', file_get_contents($this->getConfig('document_root') . '/massets/js/includes/customer_account.js'), true);

        }


        $this->assign('js', file_get_contents($this->getConfig('document_root') . '/massets/js/includes/thank_you_page.js'), true);
        $this->assign('js', file_get_contents($this->getConfig('document_root') . '/massets/js/includes/piwik.js'), true);

        $this->assign('js', file_get_contents($this->getConfig('document_root') . '/massets/js/includes/ajax_setup.js'), true);
        $this->assign('js', file_get_contents($this->getConfig('document_root') . '/massets/js/includes/c24_et.local_storage.js'), true);
        $this->assign('js', file_get_contents($this->getConfig('document_root') . '/massets/js/includes/c24autosave.js'), true);
        $this->assign('js', file_get_contents($this->getConfig('document_root') . '/massets/js/includes/favorite/c24.vv.pkv.favorite.js'), true);
        $this->assign('js', file_get_contents($this->getConfig('document_root') . '/massets/js/includes/c24.vv.pkv.autofill.js'), true);
        $this->assign('deviceoutput', $this->getDeviceOutput());

        $this->assign('ssl', $this->getProtocol());
        $this->assign('common_css', $this->get_css('massets/css/common/'));
        $this->assign('register_css', $this->get_css('massets/css/register/'));
        $this->assign('hide_header_info', $step == 'converted');

        $this->assign('css', file_get_contents($this->getConfig('document_root') . '/massets/css/register/base-0001.css'), true);
        $this->assign('css', file_get_contents($this->getConfig('document_root') . '/massets/css/tariff_detail/0010-tariff-detail.css'), true);
        $this->assign('css', file_get_contents($this->getConfig('document_root') . '/massets/css/tariff_detail/0011-tariff-overview.css'), true);
        $this->assign('css', file_get_contents($this->getConfig('document_root') . '/massets/css/common/0130-tariffinfo.css'), true);
        $this->assign('favorite_css', $this->get_css('massets/css/favorite/'));

        return $assigned_data;

    }

    /**
     * Check if the given phone number is mobile number.
     * Sorry that this method is in controller,
     * in mobile version it is the part of best practices.
     *
     * @param string $prefix    Phone preix
     * @param string $number    Phone number
     * @return boolean
     */
    protected function is_mobile_phone($prefix, $number) {

        // *** 1. Validation with ZF2
        $phoneNumber = $prefix . $number;

        // Remove leading 0 if set
        $phoneNumberValidator = $this->str_replace_on_start($phoneNumber, '0', '');

        // Check if the number is mobile with ZF validator

        $phoneValidator = new \Zend\I18n\Validator\PhoneNumber();
        $phoneValidator->setCountry('DE');
        $phoneValidator->allowedTypes(['mobile']);
        $phoneValidator->allowPossible(true);

        if (!$phoneValidator->isValid($phoneNumberValidator)) {
            return false;
        }

        // *** 2. Check the mobile prefixes

        $known_mobile_prefixes = [
            '0150', '01505', '0151', '01511', '01512', '01514', '01515', '0152', '01520', '01522',
            '01525', '0155', '0157', '01570', '01575', '01577', '01578', '0159', '0160', '0162',
            '0163', '0170', '0171', '0172', '0173', '0174', '0175', '0176', '0177', '0178', '0179'
        ];

        // Replace the country code prefixes if set
        $phoneToCheck = $this->str_replace_on_start($phoneNumber, ['+49', '0049'], '0');

        for ($i = 0, $max = count($known_mobile_prefixes); $i < $max; ++$i) {

            if (strpos($phoneToCheck, $known_mobile_prefixes[$i]) === 0) {
                return true;
            }

        }

        return false;

    }

    /**
     * Replace the substring if the haystack starts with this substring
     *
     * @param string $haystack          The string to search in.
     * @param string|array $needle      String that we search in haystack. Can be array of strings.
     * @param string $replace           The replacement value that replaces found search values.
     *                                  An array may be used to designate multiple replacements.
     * @return string
     */
    protected function str_replace_on_start($haystack, $needle, $replace) {

        $prefixesToReplace = $needle;

        if (is_string($needle)) {
            $prefixesToReplace = [$needle];
        }

        $res = $haystack;

        for ($i = 0, $max = count($prefixesToReplace); $i < $max; ++$i) {

            if (strpos($haystack, $prefixesToReplace[$i]) === 0) {
                $res = substr_replace($haystack, $replace, 0, strlen($prefixesToReplace[$i]));
            }

        }

        return $res;

    }

    /**
     * Verify if $user_info has all necessary values to complete a lead
     *
     * @param array $user_info Key-value array of user information
     * @return bool True if info is sufficient to complete a lead
     *
     * @link https://jira.check24.de/browse/PVPKV-1901 Ticket for SSO which required this
     */
    protected function address_data_complete($user_info) {

        foreach (['gender', 'firstname', 'surname', 'email', 'street', 'streetnumber', 'prefixmobile', 'mobile'] AS $key) {

            if (empty($user_info[$key])) {
                return false;
            }

        }

        // Check if the 'mobile' number is really mobile

        $is_mobile = $this->is_mobile_phone($user_info['prefixmobile'], $user_info['mobile']);

        if (!$is_mobile) {
            return false;
        }

        return true;

    }

    /**
     * Return the needed correctly formated parameters to create the home link
     *
     * @param $calc_parameter {array} The calculation parameter
     * @return array
     */
    public function get_home_link_query_string_params($calc_parameter) {

        $params = array();

        $params['c24api_insured_person'] = $calc_parameter['insured_person'];
        $params['c24api_profession'] = $calc_parameter['profession'];
        $params['c24api_existing_insurance'] = '';
        $params['c24api_contribution_carrier'] = $calc_parameter['contribution_carrier'];
        $params['c24api_contribution_rate'] = $calc_parameter['contribution_rate'];
        $params['c24api_parent1_insured'] = $calc_parameter['parent1_insured'];
        $params['c24api_parent2_insured'] = $calc_parameter['parent2_insured'];
        $params['c24api_children_age'] = $calc_parameter['children_age'];
        $params['c24api_parent_servant_or_servant_candidate'] = $calc_parameter['parent_servant_or_servant_candidate'];
        $params['c24api_birthdate'] = $calc_parameter['birthdate'];
        $params['c24api_insure_date'] = $calc_parameter['insure_date'];

        return $params;

    }

    /**
     * Get the correct tracking page key based on the route and $subscriptionType (expert/non-expert)
     *
     * @param null|string $subscriptionType
     * @param string $mapping Mapping to use, possible values:
     *                        - "piwik" for Piwik names
     *                        - "gtm" for Google Tag Manager names
     * @return mixed|string
     */
    private function getTrackingPageName($subscriptionType = '', $mapping = 'piwik') {
        check_string($subscriptionType, 'subscriptionType', true);

        if (! $subscriptionType) {
            $subscriptionType = $this->getParam('subscriptiontype');
        }

        $route = $this->getParam('step') . '/' . $subscriptionType;

        $pages = [
            'piwik' => [
                'address/expert'    => 'consultant',
                'address/offer'     => 'offer',
                'converted/expert'  => 'requestthankyou_expert',
                'converted/offer'   => 'requestthankyou',
            ],
            'gtm' => [
                'converted/expert'  => 'Dankeseite (Expert)',
                'converted/offer'   => 'Dankeseite',
            ]

        ];

        $pagename = '';

        if (isset($pages[$mapping][$route])) {
            $pagename = $pages[$mapping][$route];
        } else if (isset($pages['piwik'][$route])) {    // we use piwik as fallback so others can overwrite its names
            $pagename = $pages['piwik'][$route];
        }

        return $pagename;
    }

    /**
     * Create Action
     *
     * Create register container and redirect to index and main logic of register process
     *
     * @return array
     */
    public function createAction() {

        // Create new register container id
        $registercontainer_id = $this->createRegistercontainer(
            $this->getParam('calculationparameter_id'),
            $this->getParam('product_id'),
            $this->getParam('tariffversion_id'),
            $this->getParam('tariffversion_variation_key'),
            $this->getParam('subscriptiontype')
        );

        $product_id = $this->getParam('product_id');

        // Get additional query params
        /** @var \Zend\Http\PhpEnvironment\Request $request */
        $request = $this->getRequest();

        return $this->redirect()->toRoute(
            'mobile/pkv/register',
            [
                'product_id'           => $product_id,
                'registercontainer_id' => $registercontainer_id,
                'step'                 => 'address',
                'subscriptiontype'     => $this->getParam('subscriptiontype')
            ],
            [
                'query' => $request->getUri()->getQueryAsArray()
            ]
        );

    }

    /**
     * Create registercontainer
     *
     * @param string  $calculationparameter_id     Calculationparameter id
     * @param integer $product_id                  Product id
     * @param integer $tariffversion_id            Tariffversion id
     * @param string  $tariffversion_variation_key Tariffversion variation key
     * @param string  $subscriptiontype            Subscription type
     *
     * @return string
     */
    private function createRegistercontainer($calculationparameter_id, $product_id, $tariffversion_id, $tariffversion_variation_key, $subscriptiontype) {

        $referer_url = $this->getSession()->offsetGet('referer_url');

        $registercontainer_data = registermanager::create_registercontainer(
            $calculationparameter_id,
            $product_id,
            $tariffversion_id,
            $tariffversion_variation_key,
            $subscriptiontype,
            $this->getDeviceOutput(),
            $this->getDeviceType(),
            $referer_url == null ? '' : $referer_url
        );

        return $registercontainer_data['registercontainer_id'];
    }

    /**
     * Create online action
     *
     * @return mixed
     */
    public function createOnlineAction() {

        $registercontainer_id = $this->createRegistercontainer(
            $this->getParam('calculationparameter_id'),
            $this->getParam('product_id'),
            $this->getParam('tariffversion_id'),
            $this->getParam('tariffversion_variation_key'),
            $this->getParam('subscriptiontype')
        );

        $product_id = $this->getParam('product_id');

        $next_module = registermanager::handle_subscription_type(
            $registercontainer_id,
            (int)$product_id,
            'online'
        );

        return $this->redirect_to_step(
            $registercontainer_id, $product_id, $next_module
        );

    }

    /**
     * Create online action
     *
     * @return mixed
     */
    public function createOfflineAction() {

        $registercontainer_id = $this->createRegistercontainer(
            $this->getParam('calculationparameter_id'),
            $this->getParam('product_id'),
            $this->getParam('tariffversion_id'),
            $this->getParam('tariffversion_variation_key'),
            $this->getParam('subscriptiontype')
        );

        $product_id = $this->getParam('product_id');

        $next_module = registermanager::handle_subscription_type(
            $registercontainer_id,
            (int)$product_id,
            'offline'
        );

        return $this->redirect_to_step(
            $registercontainer_id, $product_id, $next_module
        );

    }

    /**
     * Redirect to step
     *
     * @param string $registercontainer_id Registercontainer id
     * @param integer $product_id Product id
     * @param string $stepname Stepname
     * @param array $extra_params Extra parameters for url
     * @return mixed
     */
    public function redirect_to_step($registercontainer_id, $product_id, $stepname, $extra_params = []) {

        return $this->redirect()->toUrl(
            $this->generate_step_url($registercontainer_id, $product_id, $stepname, $extra_params)
        );

    }

    /**
     * Generate step url
     *
     * @param string $registercontainer_id Registermanager id
     * @param integer $product_id Product id
     * @param string $stepname Step name
     * @param array $extra_params Extra parameters for url
     * @return string
     */
    public function generate_step_url($registercontainer_id, $product_id, $stepname, $extra_params = []) {

        $base_url = $this->url()->fromRoute('mobile/pkv/register', [
            'product_id' => $product_id,
            'registercontainer_id' => $registercontainer_id,
            'step' => $stepname
        ]);
        $base_url .= '?deviceoutput=' . $this->getDeviceOutput();

        if (empty($extra_params)) {
            return $base_url;
        }

        $base_url .= '?';

        foreach ($extra_params AS $key => $val) {
            $base_url .= $key . '=' . $val . '&';
        }

        return $base_url;

    }

    /**
     * Generate result url
     *
     * @param integer $product_id Product id
     * @param string $calculationparameter_id Calculationparameter id
     * @param integer $tariffversion_id Tariffversion id
     * @param string $tariffversion_variation_key Tariffversion variation key
     * @return string
     */
    public function generate_result_url($product_id, $calculationparameter_id, $tariffversion_id, $tariffversion_variation_key) {

        if (product_id_exists($product_id)) {

            return $this->url()->fromRoute('mobile/pkv/tariffdetail') .
            '&c24api_calculationparameter_id=' . urlencode($calculationparameter_id) .
            '&c24api_tariffversion_id=' . urlencode($tariffversion_id) .
            '&c24api_tariffversion_variation_key=' . urlencode($tariffversion_variation_key);

        }

        return '';

    }

    /**
     * Generate link to calculation result
     *
     * @param integer $product_id Product ID
     * @param string $calculationparameter_id Calculation Param ID
     *
     * @return string
     */
    public function generate_calculation_result_url($product_id, $calculationparameter_id) {

        Check::is_integer($product_id, 'product_id');
        Check::is_string($calculationparameter_id, 'calculationparameter_id');

        $url = $this->get_compare_link($product_id);
        $url .= '&c24api_calculationparameter_id=' . urlencode($calculationparameter_id);

        return $url;

    }

    /**
     * Redirect to result form url
     *
     * @param integer $product_id Product ID
     * @param string $calculationparameter_id Calculation Param ID
     *
     * @return string
     */
    public function redirect_calculation_result_url($product_id, $calculationparameter_id) {

        Check::is_integer($product_id, 'product_id');
        Check::is_string($calculationparameter_id, 'calculationparameter_id');

        return $this->redirect()->toUrl(
            $this->generate_calculation_result_url(
                $product_id, $calculationparameter_id
            )
        );

    }

    /**
     * Get url parameter value
     *
     * @param string $name Parameter name
     * @return string
     */
    public function get_url_parameter_value($name) {
        return (isset($_GET[$name]) ? $_GET[$name] : '');
    }

    /**
     * Redirect to result form url
     *
     * @param integer $product_id Product id
     *
     * @throws InvalidArgumentException Undefined product id
     * @return string
     */
    public function redirect_to_result_form_url($product_id) {

        Check::is_integer($product_id, 'product_id');

        if (product_id_exists($product_id)) {
            return $this->redirect()->toRoute('mobile/pkv/result');
        } else {
            throw new InvalidArgumentException('Undefined product id');
        }

    }

    /**
     * Redirect to result tariff detail url
     *
     * @param integer $product_id Product id
     * @param string $calculationparameter_id Calculationparameter id
     * @param integer $tariffversion_id Tariffversion id
     * @param string $tariffversion_variation_key Tariffversion variation key
     * @return mixed
     */
    public function redirect_to_result_tariff_detail_url($product_id, $calculationparameter_id, $tariffversion_id, $tariffversion_variation_key) {

        $url = $this->generate_result_url($product_id, $calculationparameter_id, $tariffversion_id, $tariffversion_variation_key);
        return $this->redirect()->toUrl($url);

    }

    /**
     * Get ajax json url
     *
     * @param string $module Module name
     *
     * @throws InvalidArgumentException XHR Route for "$module" not found!
     * @return string
     */
    public function get_ajax_json_url($module) {
        return $this->url()->fromRoute('ajax_json/' . $module);
    }

    /**
     * Get compare link for given product id
     *
     * @param integer $product_id Product id
     *
     * @throws InvalidArgumentException Undefined product id
     * @return string
     */
    public function get_compare_link($product_id) {

        Check::is_integer($product_id, 'product_id');

        if (product_id_exists($product_id)) {
            return $this->url()->fromRoute('mobile/pkv/result');
        } else {
            throw new InvalidArgumentException('Undefined product id');
        }

    }

    /**
     * Get client
     *
     * @param integer $product_id Product id
     * @return \shared\classes\calculation\client\client
     */
    public function get_client($product_id) {
        return $this->getCalculationClient($product_id);
    }

    /**
     * Generate general tracking pixel
     *
     * @param integer $product_id Product id
     * @param string $area_id Area Id
     * @param string $action_id Action Id
     * @return \shared\classes\calculation\client\client
     */
    public function generate_generaltracking_pixel($product_id, $area_id = '', $action_id = null) {
        return $this->generateGeneralTrackingPixel($product_id, $area_id, $action_id);
    }

    /**
     * Generate general tracking action pixel
     *
     * @param integer $product_id Product id
     * @param string $area_id Area id
     * @return \shared\classes\calculation\client\client
     */
    public function generate_generaltracking_action($product_id, $area_id = '') {
        return $this->generateGeneralTrackingAction($product_id, $area_id);
    }

    /**
     * Get google conversion pixel
     *
     * @param integer $product_id Product id
     * @param string $type Type
     * @param integer $partner_id Partner id
     * @return string
     */
    public function get_googleconversion_pixel($product_id, $type, $partner_id) {
        return $this->getGoogleConversionPixel($product_id, $type, $partner_id);
    }

    /**
     * @param registermanager $registermanager
     * @param $step
     */
    private function handleFormError(registermanager $registermanager, $step) {

        /** @var \Zend\Http\Request $request */
        $request = $this->getRequest();

        #if (!($this->getConfig('environment') != 'development')) {
        #    return;
        #}

        $i = 0;
        $remove_from_session = [];
        $field_errors_session = new \Zend\Session\Container('field_errors', $this->get('Common\Session\Manager'));
        $storage = $field_errors_session->getManager()->getStorage();

        if ($request->isPost())
        {
            $field_errors = $registermanager->get_form()->getMessages();
            $email_fields = [];

            if (count($field_errors) > 0)
            {
                if (isset($storage['field_errors']))
                {
                    foreach ($storage['field_errors'] AS $key => $value)
                    {
                        if (!isset($field_errors[$key]))
                        {
                            $remove_from_session[$i] = $key;
                            $i++;
                        }
                    }

                    for ($j = 0; $j < $i; $j++) {
                        $field_errors_session->offsetUnset($remove_from_session[$j]);
                    }

                    foreach ($field_errors AS $key => $value)
                    {
                        if ($field_errors_session->offsetExists($key))
                        {
                            $email_fields[$key] = ''
                                . ' Value: ' . $registermanager->get_form()->get($key)->getValue()
                                . ' Error: ' . json_encode($registermanager->get_form()->get($key)->getMessages());

                            $field_errors_session->offsetSet($key, $registermanager->get_form()->get($key)->getValue());
                        } else {
                            $field_errors_session->offsetSet($key, $registermanager->get_form()->get($key)->getValue());
                        }
                    }
                }
            } else {

                if (isset($storage['field_errors']))
                {
                    foreach ($storage['field_errors'] AS $key => $value)
                    {
                        $remove_from_session[$i] = $key;
                        $i++;
                    }

                    for ($j = 0; $j < $i; $j++) {
                        $field_errors_session->offsetUnset($remove_from_session[$j]);
                    }
                }
            }

            if (count($email_fields) > 0)
            {
                $email_body  = 'ContainerID: ' . $registermanager->get_registercontainer_id() . PHP_EOL . PHP_EOL;
                $email_body .= 'Step: ' . $step . PHP_EOL . PHP_EOL;

                foreach ($email_fields AS $key => $value) {
                    $email_body .= 'Field: ' . $key . PHP_EOL . $value . PHP_EOL . PHP_EOL;
                }

                $this->sendEmail(sprintf('Double form error on %s Mobile', strtoupper($this->getProductKey())), $email_body);
            }
        }

        elseif(isset($storage['field_errors']))
        {
            foreach ($storage['field_errors'] AS $key => $value) {
                $remove_from_session[$i] = $key;
                $i++;
            }

            for ($j = 0; $j < $i; $j++) {
                $field_errors_session->offsetUnset($remove_from_session[$j]);
            }
        }
    }

    /**
     * Check for a BPM cookie and prefill values using BPM if we're not logged in
     *
     * @param \Zend\Http\Request $request
     * @param \Zend\Http\Response $response
     * @param \Mobile\Form\Form $form
     */
    private function prefillFromBPM(\Zend\Http\Request $request, \Zend\Http\Response $response, \Mobile\Form\Form $form)
    {
        $cookie = $request->getCookie();

        /** @var \Common\BPM\Client $bpm */
        $bpm = $this->getServiceLocator()->get('Common\BPM\Client');

        $hash = sha1(microtime());

        // Load BPM values
        if ($cookie && $cookie->offsetExists('bpm') && !empty($cookie->bpm)) {
            $hash = $cookie->bpm;
            $data = $bpm->get($hash);

            foreach ($data as $key => $value) {
                if (! $form->has($key)) {
                    continue;
                }

                $element = $form->get($key);

                if (! $element->getValue()) {
                    $element->setValue($value);
                }
            }
        }

        // And save if this is a form submit
        if ($request->isPost()) {
            $store = [];
            foreach ($bpm->getFieldMap() as $key) {
                $value = $request->getPost($key);
                if (!empty ($value)) {
                    $store[$key] = $value;
                }
            }

            if ($store) {
                $bpm->set($hash, $store);
                $cookie = new SetCookie('bpm', $hash, time() + Client::COOKIE_EXPIRE, '/', $bpm->getCookieDomain());
                $response->getHeaders()->addHeader($cookie);
            }
        }
    }

}
