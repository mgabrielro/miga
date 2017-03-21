<?php

    namespace classes\helper;

    /**
     * Get the campaign period info from api
     *
     * @author Sufijen Bani <sufijen.bani@check24.de>
     */
    class shopping_campaign {

        /**
         * Get campaign data
         *
         * @param string $campaign_name The name of the campaign
         * @return array|NULL
         */
        public static function is_active() {

            $coupon_campaign_period = \classes\api\campaign_period::get('shopping_winter_2014');

            if($coupon_campaign_period) {

                return (
                    time() >= strtotime($coupon_campaign_period['valid_from']) &&
                    time() < strtotime($coupon_campaign_period['valid_to'])
                );

            } else {
                return false;
            }

        }

    }
