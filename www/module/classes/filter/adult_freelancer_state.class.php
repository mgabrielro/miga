<?php

    
    namespace classes\filter;

    /**
     * Class represents the default values for adults freelancer.
     *
     * @author Viktar Khomich <viktar.khomich@check24.de>
     */
    class adult_freelancer_state extends abstract_profession_person_state {

        /**
         * Initilize default values for adult_freelancer_state. Some values was defined in parent class.
         *
         * @return void
         */
        public function __construct() {

            parent::__construct();

            $this->settings = array_merge($this->settings, [
                'provision_costsharing_limit'      => '1000',
                'hospitalization_accommodation'    => 'multi',
                'pdhospital_payout_amount'         => '50',
            ]);

        }

    }