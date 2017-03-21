<?php

namespace Common\View\Helper;

use Common\Service\AuthenticationService;
use Zend\View\Helper\AbstractHelper;

/**
 * Class AuthenticationHelper
 *
 * @package Common\View\Helper
 * @author  Alexander Roddis <alexander.roddis@check24.de>
 * @author  Jaha Deliu <jaha.deliu@check24.de>
 * @author  Robert Eichholtz <robert.eichholtz@check24.de>
 */
class AuthenticationHelper extends AbstractHelper
{
    /**
     * Aplication Service
     *
     * @var AuthenticationService|null
     */
    protected $authentication_service = null;

    /**
     * Constructor
     *
     * @param AuthenticationService $authentication_service Authenticaiton service
     * @return void
     */
    public function __construct(AuthenticationService $authentication_service)
    {
        $this->set_authentication_service($authentication_service);
    }

    /**
     * Invoke
     *
     * @return AuthenticationHelper
     */
    public function __invoke()
    {
        return $this;
    }

    /**
     * Set authentication service
     *
     * @param AuthenticationService $authentication_service Authenticaion service
     *
     * @return void
     */
    protected function set_authentication_service($authentication_service)
    {
        $this->authentication_service = $authentication_service;
    }

    /**
     * Get authentication service
     *
     * @return AuthenticationService|null
     */
    protected function get_authentication_service()
    {
        return $this->authentication_service;
    }

    /**
     * Authentication state
     *
     * @return bool Authentication state
     */
    public function is_authenticated()
    {
        return $this->get_authentication_service()->is_authenticated();
    }

    /**
     * Get user
     *
     * @return array|NULL C24login User
     */
    public function get_user()
    {
        return $this->get_authentication_service()->get_user();
    }

    /**
     * Get user email
     *
     * @return string Email
     */
    public function get_email()
    {
        return $this->get_authentication_service()->get_user_email();
    }

    /**
     * Get User surname
     *
     * @return string Surname
     */
    public function get_surname()
    {
        return $this->get_authentication_service()->get_user_surname();
    }

    /**
     * Get user gender
     *
     * @return string Gender
     */
    public function get_gender()
    {
        return $this->get_authentication_service()->get_user_gender();
    }

    /**
     * Get c24login session id
     *
     * @return string Session id
     */
    public function get_session_id()
    {
        return $this->get_authentication_service()->get_c24session_id();
    }

    /**
     * Get c24login user id
     *
     * @return string User id
     */
    public function get_user_id()
    {
        return $this->get_authentication_service()->get_user_id();
    }
}