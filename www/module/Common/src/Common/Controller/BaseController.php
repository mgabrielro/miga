<?php

namespace Common\Controller;

use classes\calculation\mclient\client;
use Zend\Mail;
use Common\Controller\Traits\CouponTrait;
use Common\Controller\Traits\TrackingTrait;
use Common\Model\ResponseModel;
use Common\Validator\Check;
use Psr\Http\Message\ResponseInterface;
use Zend\Http\Header\SetCookie;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Mvc\Exception\BadMethodCallException;
use Zend\View\Model\JsonModel;
use Zend\Http\Request;
use Zend\Session\Container as SessionContainer;
use Zend\View\Model\ViewModel;
use \shared\classes\calculation\client\client as CalculationClient;

/**
 * Class BaseController
 *
 * @package Common\Controller
 * @author Robert Eichholtz <robert.eichholtz@check24.de>
 */
abstract class BaseController extends AbstractActionController
{
    /**
     * implements Coupon Handling Methods
     */
    use CouponTrait;

    /**
     * implements Tracking Handling Methods
     */
    use TrackingTrait;

    /**
     * Pkvfavorites COOKIE name
     */
    const PKVFAVORITES_MOBILE = 'pkvfavorites_mobile';

    /**
     * Session key to inform us if we already triggered the deletion
     * of potential duplicate favorite tariffs for the logged in user id
     */
    const FAVORITE_DELETED_DUPLICATE = 'favorite_deleted_duplicate_tariffs';

    /**
     * @var array
     */
    protected $session_container = [];

    /**
     * @var
     */
    protected $calculation_client;

    /**
     * Function to check if user is logged in or not
     * @return bool
     */
    public function isLoggedIn() {
        $userData = $this->getUserData();

        if (!empty($userData['user_id']) && $userData['user_id'] > 0) {
            return true;
        }

        return false;
    }

    /**
     * Function to get user data array
     * @return array
     * 
     */
    public function getUserData() {

        /** @var \classes\myc24login $c24login */
        $c24login = $this->get('C24Login');
        $userData = $c24login->get_user_data();

        if (!is_array($userData)) {
            return [];
        }
        return $userData;
    }

    /**
     * Is User Session Expired
     *
     * @return bool
     */
    public function isExpiredSession() {

        /** @var \classes\myc24login $c24login */
        $c24login = $this->get('C24Login');
        return $c24login->is_session_expired();

    }


    /**
     * Get expired user data
     *
     * @return string
     */
    public function getExpiredUserData() {

        /** @var \classes\myc24login $c24login */
        $c24login = $this->get('C24Login');
        return $c24login->get_expired_session_user_data();

    }


    /**
     * should be implemented
     */
    public function indexAction() {
        throw new BadMethodCallException('indexAction currently not implemented!');
    }

    /**
     * @param string|null $template
     * @param array $parameters
     *
     * @return ViewModel
     */
    protected function getViewModel($template = null, array $parameters = [])
    {
        $model = new ViewModel($parameters);

        if(is_string($template)) {
            $model->setTemplate($template);
        }

        return $model;
    }

    /**
     * get json response
     *
     * @param array|ResponseInterface $data
     * @return JsonModel
     */
    protected function getJsonModel($data)
    {
        $jsonModel = new JsonModel();

        if($data instanceof ResponseInterface)
        {
            $model = new ResponseModel($data->getBody()->getContents());

            $jsonModel->setVariables([
                'code'    => $model->getStatusCode(),
                'status'  => $model->getStatusMessage(),
                'content' => $model->getData()
            ]);

        } else {
            $jsonModel->setVariables([
                'code'    => 200,
                'status'  => 'OK',
                'content' => $data
            ]);
        }

        return $jsonModel;
    }

    /**
     * simple wrapper for Service Locator
     *
     * @param $name
     * @return array|object
     */
    protected function get($name)
    {
        Check::is_string($name, 'name');
        return $this->getServiceLocator()->get($name);
    }

    /**
     * returns the definition product object
     *
     * @param null $product_id
     *
     * @return mixed
     */
    protected function getProduct($product_id = null)
    {
        if(null === $product_id) {
            return $this->getConfig('defs')->products->{$this->getProductId()};
        }

        return $this->getConfig('defs')->products->{$product_id};
    }

    /**
     * get current product id
     *
     * @return int|null
     */
    protected function getProductId() {
        return $this->getConfig('product')->id;
    }

    /**
     * get current product id
     *
     * @return int|null
     */
    protected function getProductKey($product_id = null)
    {
        if(null === $product_id) {
            return $this->getConfig('product')->key;
        }

        return $this->getProduct($product_id)->key;
    }

    /**
     * simple wrapper to fetch Parameters from Routing
     *
     * @param string $name
     * @param mixed|null $default
     *
     * @return mixed
     */
    protected function getParam($name, $default = null)
    {
        Check::is_string($name, 'name');
        return $this->getEvent()->getRouteMatch()->getParam($name, $default);
    }

    /**
     * simple wrapper to fetch Query Parameters from current URL
     *
     * @param string $name
     * @param mixed|null $default
     *
     * @return array|object
     */
    protected function getQuery($name, $default = null)
    {
        Check::is_string($name, 'name');
        return $this->getRequest()->getQuery($name, $default);
    }

    /**
     * @param string     $name
     * @param bool|false $clearStorage
     *
     * @return \Zend\Session\Container
     */
    protected function getSessionContainer($name, $clearStorage = false)
    {
        if(isset($this->session_container[$name]) && $this->session_container[$name] instanceof SessionContainer)
        {
            if($clearStorage) {
                $this->session_container[$name]->getManager()->getStorage()->clear($name);
            }

            return $this->session_container[$name];
        }

        $this->session_container[$name] = new SessionContainer($name, $this->get('Common\Session\Manager'));

        if($clearStorage) {
            $this->session_container[$name]->getManager()->getStorage()->clear($name);
        }

        return $this->session_container[$name];
    }

    /**
     * Set referrer in session
     *
     * Tracking, tracking_id in URL overwrites
     * existing tracking_id in session, default is empty
     *
     * @param Request $request
     */
    protected function handleReferrer(Request $request)
    {
        if (!empty($request->getQuery('ref'))) {
            $this->getSession()->offsetSet('referer_url', $request->getQuery('ref'));
        } else if (!$this->getSession()->offsetExists('referer_url') && $request->getHeader('referer')) {
            $this->getSession()->offsetSet('referer_url', $request->getHeader('referer')->getFieldValue());
        } else if (!$this->getSession()->offsetExists('referer_url') || empty($this->getSession()->offsetGet('referer_url'))) {
            $this->getSession()->offsetSet('referer_url', 'm.check24.de');
        }

    }

    /**
     * Get session
     *
     * @return \Zend\Session\Container
     */
    protected function getSession() {
        return $this->getServiceLocator()->get('SessionContainer');
    }

    /**
     * Handle the pkvfavorites_mobile COOKIE, in order to be sure that it is available,
     * when the user tries to add a tariff to his favorites
     *
     * @return void
     */
    protected function handlePkvfavoritesMobile() {

        /** @var client $client */
        $client                    = $this->getServiceLocator()->get(client::class);
        $session                   = $this->getServiceLocator()->get("SessionContainer");
        $request                   = $this->getRequest();
        $cookieLifetime            = $this->getFavoritesCookieLifetime();
        $userData                  = $this->getUserData();
        $isLoggedin                = (!empty($userData['user_id']) && $userData['user_id'] > 0) ? true : false;

        // if there is no cookie, we create one now
        if (!$request->getCookie() || !$request->getCookie()->offsetExists(self::PKVFAVORITES_MOBILE)) {

            if ($isLoggedin) {
                $pkvfavorites_mobile = $userData['user_id'];
            } else {
                $pkvfavorites_mobile = \Mobile\Controller\FavoriteController::generate_pkvfavorites_mobile_token();
            }

            $this->setCookie(self::PKVFAVORITES_MOBILE, $pkvfavorites_mobile, $cookieLifetime);

        } else {
            $pkvfavorites_mobile = $this->getPkvfavoritesCookieValue();
        }

        if ($isLoggedin) {

            $sso_user_id = (int) $userData['user_id'];

            /**
             * If we did not already triggered the deletion of potential duplicate
             * favorite tariffs for this user id, we do it now
             */
            if (!$session->offsetExists(self::FAVORITE_DELETED_DUPLICATE) || $session->offsetGet(self::FAVORITE_DELETED_DUPLICATE) == false) {

                $client->delete_duplicate_favorite_tariffs_bey_user_id($sso_user_id);
                $session->offsetSet(self::FAVORITE_DELETED_DUPLICATE, true);

            }

            /**
             * If we do not have the sso_user_id in the favorites COOKIE, we make the update now,
             * and we also update all potential favorites records sso_user_id column value
             * based on the session_id
             */
            if ($pkvfavorites_mobile != $sso_user_id) {

                $client->update_favorites_user_id_by_token($sso_user_id, $pkvfavorites_mobile);
                $this->setCookie(self::PKVFAVORITES_MOBILE, $sso_user_id, $cookieLifetime);

            }

        }

    }

    /**
     * Get the pkvfavorites Cookie value
     *
     * @return string      The pkvfavorites cookie value or empty string
     */
    public function getPkvfavoritesCookieValue() {

        $cookie = $this->getRequest()->getCookie();

        $pkvfavorites_token = '';

        if ($cookie && $cookie->offsetExists(self::PKVFAVORITES_MOBILE) && !empty($cookie->pkvfavorites_mobile)) {
            $pkvfavorites_token = $cookie->pkvfavorites_mobile;
        }

        return $pkvfavorites_token;

    }

    /**
     * Get the 30 days time, to be used for the cookie lifetime
     *
     * @return integer
     */
    public function getFavoritesCookieLifetime() {
       return time() + 60 * 60 * 24 * 30;
    }

    /**
     * Get cookie domain
     *
     * @return string The cookie domain
     */
    protected function getCookieDomain() {
        return $this->get('ZendConfig')->check24->cookie->domain;
    }

    /**
     * Get the device output
     *
     * @return string
     */
    protected function getDeviceOutput() {
        return $this->serviceLocator->get('DeviceOutput')->get();
    }

    /**
     * Get the device type
     *
     * @return string
     */
    protected function getDeviceType() {
        return $this->serviceLocator->get('DeviceType')->get();
    }

    /**
     * Returns the current HTTP Protocol if is 'http' or 'https'
     *
     * @return string
     */
    protected function getProtocol()
    {
        $isSSL   = !empty($_SERVER['HTTP_SSL']) && $_SERVER['HTTP_SSL'] == 'true';
        $isHTTPS = !empty($_SERVER['HTTP_X_HTTPS']) && $_SERVER['HTTP_X_HTTPS'] == 'on';

        return ($isHTTPS || $isSSL) ? 'https' : 'http';
    }

    /**
     * return the check24 Configuration
     *
     * @param null $key
     * @return mixed
     */
    protected function getConfig($key = null)
    {
        $config = $this->getServiceLocator()->get('ZendConfig')->check24;
        return (!is_null($key) && isset($config[$key])) ? $config[$key] : $config;
    }

    /**
     * add points value to template
     *
     * @return void
     */
    protected function assignPointPlan()
    {
        $point_plan = $this->get('\classes\helper\c24points')->get_point_plan();

        // user has point plan
        if ($point_plan) {
            $this->assign('point_plan', $point_plan);
        }
    }

    /**
     * assign to layout template
     *
     * @param $key
     * @param $value
     */
    public function assign($key, $value, $append = false)
    {
        if($append) {
            $this->layout()->{$key} .= $value;
        } else {
            $this->layout()->{$key} = $value;
        }
    }

    /**
     * Get wpset
     *
     * @return \shared\classes\wpset
     */
    protected function getWpset() {
        return $this->get('classes\wpset');
    }

    /**
     * return true if hotline must be shown or not
     *
     * @return boolean
     */
    protected function showHotline() {

        // Check closing days (chrismas)

        $closing_days = array();

        if (isset($closing_days[date('d-m')])) {
            return false;
        }

        // Check24 energy open times
        $open = array(
            0 => array('from' => 8, 'to' => 22),
            1 => array('from' => 8, 'to' => 22),
            2 => array('from' => 8, 'to' => 22),
            3 => array('from' => 8, 'to' => 22),
            4 => array('from' => 8, 'to' => 22),
            5 => array('from' => 8, 'to' => 22),
            6 => array('from' => 8, 'to' => 22),
        );

        if (!isset($open[date('w')])) {
            throw new \Exception('Undefined workday');
        }

        // Get current set for workday

        $hour_area = $open[date('w')];

        // Check open time

        if (date('w') >= 0 && date('w') < 6) {

            if (date('G') >= $hour_area['from'] && date('G') < $hour_area['to']) {
                return true;
            } else{
                return false;
            }

        } else {
            return false;
        }

    }

    /**
     * Create Calculation Client
     *
     * @param string $tracking_id Tracking id
     * @return CalculationClient
     */
    protected function createCalculationClient($service, $deviceType, $product_id = null)
    {
        Check::is_string($service, 'service');
        Check::is_string($deviceType, 'deviceType');

        if ($this->calculation_client === NULL)
        {
            if (null === $product_id) {
                $product_id = $this->getProductId();
            }

            $tracking_id = $this->getWpset()->get_tracking_id($product_id);

            /** @var CalculationClient $client */
            $client = $this->get($service);

            if (!empty($tracking_id)) {
                $client->set_tracking_id($tracking_id);
            }


            $client->set_deviceoutput($this->getDeviceOutput());

            $this->calculation_client = $client;
        }

        return $this->calculation_client;
    }

    /**
     * @param \Zend\Mvc\MvcEvent $e
     *
     * @return void
     */
    public function onDispatch(\Zend\Mvc\MvcEvent $e)
    {
        $routeMatch = $e->getRouteMatch();
        $this->layout()->routeName = $routeMatch->getMatchedRouteName();
        $this->layout()->step = $routeMatch->getParam('step') ? $routeMatch->getParam('step') : $this->layout()->routeName;

        $deviceoutput = $this->getDeviceOutput();
        $this->layout()->deviceoutput = $deviceoutput;

        $this->layout()->ssl = $this->getProtocol();

        $this->setCookie('deviceoutput', $deviceoutput, strtotime('+7 days'));
        $this->setCookie('devicetype', $this->getDeviceType(), strtotime('+7 days'));

        parent::onDispatch($e);
    }

    /**
     * Sets a cookie
     *
     * @param $name
     * @param $value
     * @param int $expire
     *
     * @return void
     */
    public function setCookie($name, $value, $expire = 0) {
        $response = $this->getResponse();

        $response->getHeaders()->addHeader(
            new SetCookie($name, $value, $expire, '/',  $this->getCookieDomain())
        );
    }

    /**
     * simple send mail
     *
     * @param string $subject
     * @param string $body
     * @param string|null $to
     * @param string|null $from
     */
    protected function sendEmail($subject, $body, $to = null, $from = null)
    {
        $mailToAddress   = $to ? $to : $this->getConfig('service')->email->{$this->getProductKey()};
        $mailFromAddress = $from ? $from : $this->getProductKey() . '-dev@check24.de';

        // SEND EMAIL
        $mail = new Mail\Message();
        $mail->setFrom($mailFromAddress, $mailFromAddress);
        $mail->addTo($mailToAddress, $mailToAddress);
        $mail->setSubject($subject);
        $mail->setBody($body);

        $transport = new Mail\Transport\Sendmail();
        $transport->send($mail);
    }
}