<?php

    
    namespace classes\filter;

    /**
     * Class represents the default values for adults employees.
     *
     * @author Viktar Khomich <viktar.khomich@check24.de>
     */
    class adult_employee_state extends abstract_profession_person_state {

        /**
         * Get payout start list
         *
         * @return array
         */
        public function getPayoutStartOptions() {

            return [
                '0'   => 'kein Krankentagegeld',
                '43'  => 'ab dem 43. Tag',
                '92'  => 'ab dem 92. Tag',
                '183' => 'ab dem 183. Tag'
            ];

        }

    }