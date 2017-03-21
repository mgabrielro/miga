<?php

    namespace classes {

        /**
         * Googleconversionpixel class to generate google pixel on thx page
         *
         * @author Tobias Albrecht <tobias.albrecht@check24.de>
         * @copyright rapidsoft GmbH
         * @version 1.0
         */
        class googleconversionpixel {

            /**
             * Generate pixel based on parameter
             *
             * @param integer $product_id Product id
             * @param string $subscription_type Subscription type
             * @param integer $partner_id Partner id
             * @param string $tracking_id Tracking id
             * @return string
             */
            public static function generate($product_id, $subscription_type, $partner_id, $tracking_id) {

                \shared\classes\common\utils::check_int($product_id, 'product_id');
                \shared\classes\common\utils::check_string($subscription_type, 'subscription_type', false, array('online', 'offline'));
                \shared\classes\common\utils::check_int($partner_id, 'partner_id');
                \shared\classes\common\utils::check_string($tracking_id, 'tracking_id', true);

                switch ($product_id) {

                    case 1 :
                    case 2 :

                        // We only show pixel on online leads

                        if ($subscription_type != 'online') {
                            return '';
                        }

                        // Currently we have only pid 24 leads on mobile version

                        if ($partner_id != 24) {
                            return '';
                        }

                        switch ($tracking_id) {

                            case 'CH24_E_GO' :
                            case 'CH24_E_GO_1' :
                            case 'CH24_E_GO_2' :
                            case 'CH24_E_GO_SL' :
                            case 'CH24_E_GO2' :
                            case 'CH24_E_GOB' :
                            case 'CH24_E_GO_COMP' :
                            case 'CH24_E_GO_CO' :
                            case 'CH24_E_GO_3' :
                            case 'CH24_E_GO_GXS_Strom' :
                            case 'CH24_E_GO_GXS_Gas' :
                            case 'CH24_E_GO_Energie' :

                                return '
                                    <!-- Google Code for Vergleich Conversion Page -->
                                    <script type="text/javascript">
                                        /* <![CDATA[ */
                                            var google_conversion_id = 1045196198;
                                            var google_conversion_language = "de";
                                            var google_conversion_format = "3";
                                            var google_conversion_color = "ffffff";
                                            var google_conversion_label = "8iLxCKi_YRCm27HyAw";
                                            var google_conversion_value = 0;
                                        /* ]]> */
                                    </script>
                                    <script type="text/javascript" src="https://www.googleadservices.com/pagead/conversion.js"></script>
                                    <noscript>
                                        <div style="display:inline;">
                                            <img height="1" width="1" style="border-style:none;" alt="" src="https://www.googleadservices.com/pagead/conversion/1045196198/?label=8iLxCKi_YRCm27HyAw&amp;guid=ON&amp;script=0"/>
                                        </div>
                                    </noscript>

                                    <!-- Google Code for Energie Conversion Page -->
                                    <script type="text/javascript">
                                        /* <![CDATA[ */
                                        var google_conversion_id = 997240025;
                                        var google_conversion_language = "en";
                                        var google_conversion_format = "3";
                                        var google_conversion_color = "ffffff";
                                        var google_conversion_label = "O91fCL-GgQUQ2dnC2wM";
                                        var google_conversion_value = 0;
                                        /* ]]> */
                                    </script>
                                    <script type="text/javascript" src="https://www.googleadservices.com/pagead/conversion.js"></script>
                                    <noscript>
                                        <div style="display:inline;">
                                            <img height="1" width="1" style="border-style:none;" alt="" src="https://www.googleadservices.com/pagead/conversion/997240025/?value=0&label=O91fCL-GgQUQ2dnC2wM&guid=ON&script=0"/>
                                        </div>
                                    </noscript>
                                ';

                        }

                        break;

                    case 3 :

                        // We only show pixel on online leads

                        if ($subscription_type != 'online') {
                            return '';
                        }

                        // Currently we have only pid 24 leads on mobile version

                        if ($partner_id != 24) {
                            return '';
                        }

                        switch ($tracking_id) {

                            case 'CH24_T_GO' :
                            case 'CH24_T_GO_1' :
                            case 'CH24_T_GO_2' :
                            case 'CH24_T_GO_3' :
                            case 'CH24_T_GO_4' :
                            case 'CH24_T_GO_5' :
                            case 'CH24_T_GO_V' :
                            case 'CH24_T_GO_SL' :
                            case 'CH24_T_GO_COMP' :
                            case 'CH24_T_GO_CO' :
                            case 'CH24_T_GO_LTE_1' :

                                return '
                                    <!-- Google Code for DSL Abschluss Conversion Page -->
                                    <script type="text/javascript">
                                        /* <![CDATA[ */
                                        var google_conversion_id = 1045196198;
                                        var google_conversion_language = "de";
                                        var google_conversion_format = "3";
                                        var google_conversion_color = "ffffff";
                                        var google_conversion_label = "P_ulCPyHngEQptux8gM";
                                        var google_conversion_value = 0;
                                        /* ]]> */
                                    </script>
                                    <script type="text/javascript" src="https://www.googleadservices.com/pagead/conversion.js"></script>
                                    <noscript>
                                        <div style="display:inline;">
                                            <img height="1" width="1" style="border-style:none;" alt="" src="https://www.googleadservices.com/pagead/conversion/1045196198/?label=P_ulCPyHngEQptux8gM&amp;guid=ON&amp;script=0"/>
                                        </div>
                                    </noscript>
                                ';

                        }

                        break;

                }

            }

        }

    }