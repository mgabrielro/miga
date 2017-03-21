<?php

    namespace classes\calculation\client\controller\helper {

        /**
         * Generaltracking helper
         *
         * @author Igor Duspara
         * @version 1.0
         */
        class generaltracking_pv {

            /**
             * Constructor
             *
             * @param \shared\classes\calculation\client\controller\base $controller Controller
             * @param integer $product_id Product id
             * @param string $area_id Area id
             * @param integer $action_id Action id
             * @param string $product_name Product Name
             * @param integer $action_foreign_id Action foreign id
             * @return string
             */
            public static function run($controller, $product_id, $area_id, $action_id = 0, $product_name = NULL, $action_foreign_id = 0) {

                $generaltracking = new generate_generaltracking_pv($controller->create_view(),
                    $controller->get_client()->get_protocol(),
                    $product_id,
                    $controller->get_client()->get_partner_id(),
                    $controller->get_client()->get_tracking_id(),
                    $area_id,
                    $controller->get_client()->get_session_id(),
                    $action_id,
                    $action_foreign_id,
                    $controller->get_client()->get_referer_url(),
                    $controller->get_client()->get_deviceoutput(),
                    $product_name
                );

                return $generaltracking->get_output();

            }

        }

    }