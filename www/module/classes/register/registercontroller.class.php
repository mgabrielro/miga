<?php

    namespace classes\register {

        /**
         * registercontroller
         *
         * Register controller interface
         *
         * @author Everyone
         */
        interface registercontroller {

            /**
             * Redirect to step
             *
             * @param string $registercontainer_id Registercontainer id
             * @param integer $product_id Product id
             * @param string $stepname Stepname
             * @return void
             */
            public function redirect_to_step($registercontainer_id, $product_id, $stepname);

            /**
             * Generate step url
             *
             * @param string $registercontainer_id Registermanager id
             * @param integer $product_id Product id
             * @param string $stepname Step name
             * @return string
             */
            public function generate_step_url($registercontainer_id, $product_id, $stepname);

            /**
             * Generate result url
             *
             * @param integer $product_id Product id
             * @param string $calculationparameter_id Calculationparameter id
             * @param integer $tariffversion_id Tariffversion id
             * @param string $tariffversion_variation_key Tariffversion variation key
             * @return string
             */
            public function generate_result_url($product_id, $calculationparameter_id, $tariffversion_id, $tariffversion_variation_key);

            /**
             * Redirect to result form url
             *
             * @param integer $product_id Product ID
             * @param string $calculationparameter_id Calculation Param ID
             *
             * @return string
             */
            public function redirect_calculation_result_url($product_id, $calculationparameter_id);

            /**
             * Get url parameter value
             *
             * @param string $name Parameter name
             *
             * @return mixed
             */
            public function get_url_parameter_value($name);

            /**
             * Redirect to result form url
             *
             * @param integer $product_id Product id
             * @return void
             */
            public function redirect_to_result_form_url($product_id);

            /**
             * Get ajax json url
             *
             * @param string $module Module
             *
             * @return string
             */
            public function get_ajax_json_url($module);

            /**
             * Get compare link for given product id
             *
             * @param integer $product_id Product id
             *
             * @return string
             */
            public function get_compare_link($product_id);

            /**
             * Get generaltracking pixel
             *
             * @param integer $product_id Product id
             * @param string $area_id Area id
             * @return string
             */
            public function generate_generaltracking_pixel($product_id, $area_id = '');

            /**
             * Get generaltracking action pixel
             *
             * @param integer $product_id Product id
             * @param string $area_id Area id
             * @return string
             */
            public function generate_generaltracking_action($product_id, $area_id = '');

            /**
             * Get google conversion pixel
             *
             * @param integer $product_id Product id
             * @param string $type Type
             * @param integer $partner_id Partner id
             * @return string
             */
            public function get_googleconversion_pixel($product_id, $type, $partner_id);

            /**
             * Get client
             *
             * @param integer $product_id Product id
             * @return \shared\classes\calculation\client\client
             */
            public function get_client($product_id);

        }

    }
