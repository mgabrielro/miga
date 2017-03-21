<?php

    namespace classes;

    use \shared\classes\dal;
    use \shared\classes\common\utils;

    use \Zend\Http\Request;
    use \Zend\Http\Response;
    use \Zend\Session\Container;;
    use \Zend\Http\Header\SetCookie;

    /**
     * Extension for wpset
     *
     * @author Andreas Frömer <andreas.froemer@check24.de>
     */
    class wpset extends \shared\classes\wpset {

        private $fallback_tracking_id = 'checkvers';

        /**
         * @var Request
         */
        protected $request;

        /**
         * @var Response
         */
        protected $response;

        /**
         * Constructor
         *
         * @param \Zend\Session\Container $session
         * @return void
         */
        public function __construct(Container $session, dal\wpset $wpset_dal, Request $request, Response $response) {
            $this->request  = $request;
            $this->response = $response;

            parent::__construct($session, $wpset_dal);

        }

        /**
         * Get get tracking id
         *
         * @return string|NULL
         */
        protected function get_get_tracking_id() {

            if ($this->request->getQuery('tracking_id')) {
                return $this->request->getQuery('tracking_id');
            }

            if ($this->request->getQuery('tid')) {
                return $this->request->getQuery('tid');
            }

            return NULL;
        }

        /**
         * Get get wpset
         *
         * @return string|NULL
         */
        protected function get_get_wpset() {

            if ($this->request->getQuery('wpset')) {
                return $this->request->getQuery('wpset');
            }

            return parent::get_get_wpset();

        }

        /**
         * Get wpset from cookie
         *
         * @return string|NULL
         */
        protected function get_wpset_from_cookie() {

            if ($this->request->getCookie() && $this->request->getCookie()->offsetExists('wpset')) {
                return $this->request->getCookie()->wpset;
            }

            return NULL;
        }

        /**
         * Get tracking id
         *
         * @param integer $product_id Product id
         * @throws \shared\classes\common\exception\argument Raised if mapping is missing for pdocut id
         * @return string
         */
        public function get_tracking_id($product_id) {

            $tracking_id = parent::get_tracking_id($product_id);

            // Check for NULL tracking_id
            // This fixes #PVKZU-

            if ($tracking_id == NULL) {
                $tracking_id = $this->fallback_tracking_id;
            }

            return $tracking_id;

        }

        /**
         * Set wpset cookie
         *
         * @param string $wpset Wpset
         * @param integer $lifetime = NULL Cookie lifetime in seconds
         * @return void
         */
        protected function set_wpset_cookie($wpset, $lifetime = NULL) {

            utils::check_string($wpset, 'wpset');

            if ($lifetime !== NULL) {

                utils::check_int($lifetime, 'lifetime', true);
                $cookie_lifetime = time() + $lifetime;

            } else {
                $cookie_lifetime = $lifetime;
            }

            $this->response->getHeaders()->addHeader(
                new SetCookie('wpset', $wpset, $cookie_lifetime, '/', '.check24.de')
            );

        }

    }