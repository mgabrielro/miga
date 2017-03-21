<?php

    namespace classes\calculation\client\controller\helper;

    use \shared\classes\calculation\client\view\helper\base;
    use \shared\classes\calculation\client\model\tariff;
    use \shared\classes\common\utils;

    /**
     * request offer button helper
     *
     * @author Robert Eichholtz <robert.eichholtz@check24.de>
     */
    class request_offer_button extends base {

        /**
         * @var tariff
         */
        private $tariff = null;

        /**
         * @param tariff $tariff The Tariff
         */
        public function set_tariff(tariff $tariff) {
            $this->tariff = $tariff;
        }

        /**
         * @param string $subscription_url The Subscription URL
         */
        public function set_subscription_url($subscription_url)
        {
            utils::check_string($subscription_url, 'subscription_url');
            $this->view->subscription_url = $subscription_url;
        }

        /**
         * @param string $css_class Additional CSS Classes
         */
        public function set_css_class($css_class = '') {
            $this->view->css_class = $css_class;
        }

        /**
         * Returns the rendered output.
         *
         * @return string
         */
        protected function create_output()
        {
            $this->view->daily_price = $this->get_daily_price();
            $this->view->tooltip_text = $this->get_tooltip_text();

            return $this->view->render($this->get_product_name() . '/request_offer_button.phtml');
        }

        /**
         * @return string
         */
        protected function get_product_name() {
            return get_def('product/' . $this->view->tariff->get_tariff_product_id());
        }

        /**
         * @return array
         */
        protected function get_tooltip_text() {
            return preg_split('/\\r\\n|\\r|\\n/', $this->view->i18n->translate('compare_tooltip_offer_button', $this->get_product_name()));
        }

        /**
         * @return array
         */
        protected function get_daily_price() {
            return explode(',', number_format($this->view->tariff->get_paymentperiod_size() * $this->view->tariff->get_paymentperiod_count() / 365, 2, ',', '.'));
        }
    }