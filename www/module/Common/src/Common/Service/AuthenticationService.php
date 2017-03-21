<?php

namespace Common\Service;

/**
 * Service Class for c24login Authentication
 *
 * @package Common\Service
 * @author  Alexander Roddis <alexander.roddis@check24.de>
 * @author  Jaha Deliu <jaha.deliu@check24.de>
 * @author  Robert Eichholtz <robert.eichholtz@check24.de>
 *
 */
class AuthenticationService
{
    /**
     * @var \classes\myc24login|null
     */
    protected $c24_login_instance = null;

    /**
     * Constructor
     *
     * @param \classes\myc24login|NULL $c24_login_instance C24 login instance
     *
     * @return void
     */
    public function __construct(\classes\myc24login $c24_login_instance = null)
    {
        $this->set_c24_login_instance($c24_login_instance);
    }

    /**
     * Login Instance getter
     *
     * @return \classes\myc24login|null $c24_login_instance Login instance
     */
    protected function get_c24_login_instance()
    {
        return $this->c24_login_instance;
    }

    /**
     * Login instance setter
     *
     * @param \classes\myc24login $c24_login_instance Login instance
     *
     * @return void
     */
    protected function set_c24_login_instance($c24_login_instance)
    {
        $this->c24_login_instance = $c24_login_instance;
    }

    /**
     * User authentication state
     *
     * @return bool User authentication state
     */
    public function is_authenticated()
    {
        return $this->get_c24_login_instance()->get_user_data() !== null;
    }

    /**
     * C24login User
     *
     * @return array|NULL User data or NULL
     */
    public function get_user()
    {
        return $this->get_c24_login_instance()->get_user_data();
    }

    /**
     * Get User surname
     *
     * @return string User surname
     */
    public function get_user_surname()
    {
        return $this->get_c24_login_instance()->get_user_data()['surname'];
    }

    /**
     * Get User email
     *
     * @return string User email
     */
    public function get_user_email()
    {
        return $this->get_c24_login_instance()->get_user_data()['email'];
    }

    /**
     * Get User gender
     *
     * @return string User gender
     */
    public function get_user_gender()
    {
        return $this->get_c24_login_instance()->get_user_data()['gender'];
    }

    /**
     * Get c24login seesion id
     *
     * @return string Session id
     */
    public function get_c24session_id()
    {
        $c24session = !empty($_COOKIE['c24session']) ? $_COOKIE['c24session'] : '';
        return $c24session;
    }

    /**
     * Get user id
     *
     * @return string User id
     */
    public function get_user_id()
    {
        return $this->get_c24_login_instance()->get_user_data()['user_id'];
    }
}