<?php

    namespace classes\filter;

    /**
     * Base class for filter default behaviour depending on profession and insured person
     *
     * @author Viktar Khomich <viktar.khomich@check24.de>
     */
    abstract class abstract_profession_person_state {

        /** @var  array */
        protected $settings;

        /**
         * Create appropriate state object based on values profession and insured person.
         *
         * @param string $profession Profession.
         * @param string $insuredPerson Insured person.
         *
         * @throws \Exception When it wasn't found appropriate state object.
         *
         * @return abstract_profession_person_state
         */
        static public function factory($profession, $insuredPerson) {

            check_string($profession, 'profession', true);
            check_string($insuredPerson, 'insuredPerson', true);

            $state = NULL;

            if ($profession == 'employee' && $insuredPerson == 'adult') {
                $state = new adult_employee_state();
            } else if (in_array($profession, ['servant_candidate', 'servant']) && $insuredPerson == 'adult') {
                $state =  new adult_servant_state();
            } else if ($profession == 'freelancer'  && $insuredPerson == 'adult') {
                $state = new adult_freelancer_state();
            } else if ($profession == 'unemployed'  && $insuredPerson == 'adult') {
                $state = new adult_unemployed_state();
            } else if ($profession == 'student'  && $insuredPerson == 'adult') {
                $state = new adult_student_state();
            } else if (in_array($profession, ['servant_candidate', 'servant'])  && $insuredPerson == 'child') {
                $state = new child_servant_state();
            } else if ($insuredPerson == 'child') {
                $state = new child_state();
            } else {
                $state = new default_state();
            }

            if (is_null($state)) {
                throw new \Exception('Not found appropriate state object for insured person ' . $insuredPerson . ' and profession ' .  $profession);
            }

            return $state;

        }

        /**
         * Initilize default values for state objects. Some values will be rewritten in concrete classes.
         *
         * @return void
         */
        public function __construct() {

            $this->settings = [
                'dental'                           => 'comfort',
                'provision_costsharing_limit'      => '650',
                'hospitalization_accommodation'    => 'double',
                'pdhospital_payout_start'          => '43',
                'pdhospital_payout_amount'         => '100',
                'cure_rehab_visibility'            => false,
                'pdhospital_visibility'            => true,
                'provision_costsharing_visibility' => true,
            ];

        }

        /**
         * Get the accomodation list
         *
         * @return array
         */
        public function getAccomondationOptions() {

            return [
                'multi'  => 'Mehrbettzimmer',
                'double' => '2-Bett-Zimmer/Chefarzt',
                'single' => '1-Bett-Zimmer/Chefarzt'
            ];

        }

        /**
         * Get the accomodation list for result
         *
         * @return array
         */
        public function getAccomondationOptionsResult() {

            return [
                'multi'  => 'Mehrbettzimmer',
                'double' => '2-Bett-Zimmer/Chefarzt',
                'single' => '1-Bett-Zimmer/Chefarzt'
            ];

        }        

        /**
         * Get payout start list
         *
         * @return array
         */
        public function getPayoutStartOptions() {

            return [
                '0'   => 'kein Krankentagegeld',
                '15'  => 'ab dem 15. Tag',
                '22'  => 'ab dem 22. Tag',
                '29'  => 'ab dem 29. Tag',
                '43'  => 'ab dem 43. Tag',
                '92'  => 'ab dem 92. Tag',
                '183' => 'ab dem 183. Tag'
            ];

        }

        /**
         * Get default value for dental.
         *
         * @return string
         */
        public function getDefaultDental() {
            return $this->settings['dental'];
        }

        /**
         * Get default value for dental.
         *
         * @return string
         */
        public function getDefaultProvisionCostsharingLimit() {
            return $this->settings['provision_costsharing_limit'];
        }

        /**
         * Get default value for Hospitalization accomodation.
         *
         * @return string
         */
        public function getDefaultHospitalizationAccommodation() {
            return $this->settings['hospitalization_accommodation'];
        }

        /**
         * Get default pdhospital payout start.
         *
         * @return string
         */
        public function getDefaultPdhospitalPayoutStart() {
            return $this->settings['pdhospital_payout_start'];
        }

        /**
         * Get pdhospital payout amount.
         *
         * @return string
         */
        public function getDefaultPdhospitalPayoutAmount() {
            return $this->settings['pdhospital_payout_amount'];
        }

        /**
         * Get cure rehab visibility.
         *
         * @return string
         */
        public function checkCureAndRehabVisibility() {
            return $this->settings['cure_rehab_visibility'];
        }

        /**
         * Get pdhospital visibility.
         *
         * @return string
         */
        public function checkPdhospitalVisibility() {
            return $this->settings['pdhospital_visibility'];
        }

        /**
         * Get provision Costsharing limit visibility.
         *
         * @return string
         */
        public function checkProvisionCostsharingLimitVisibility() {
            return $this->settings['provision_costsharing_visibility'];
        }

    }