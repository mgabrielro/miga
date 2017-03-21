<?php

    namespace classes\calculation\client\model\parameter;

    /**
     * The parameter model for product PKV.
     *
     * @author Igor Duspara <igor.duspara@check24.de>
     */
    class pkv extends pv {

        const PROFESSION_ALL                        = 'all';

        CONST INSURED_PERSON_ADULT                  = 'adult';
        CONST INSURED_PERSON_CHILD                  = 'child';

        CONST PROFESSION_EMPLOYEE                   = 'employee';
        CONST PROFESSION_FREELANCER                 = 'freelancer';
        CONST PROFESSION_SERVANT                    = 'servant';
        CONST PROFESSION_SERVANT_CANDIDATE          = 'servant_candidate';
        CONST PROFESSION_STUDENT                    = 'student';
        CONST PROFESSION_INTERN                     = 'intern';
        CONST PROFESSION_UNEMPLOYED                 = 'unemployed';

        CONST HOSPITALIZATION_MULTI                 = 'multi';
        CONST HOSPITALIZATION_DOUBLE                = 'double';
        CONST HOSPITALIZATION_SINGLE                = 'single';

        CONST DENTAL_BASIC                          = 'basic';
        CONST DENTAL_COMFORT                        = 'comfort';
        CONST DENTAL_PREMIUM                        = 'premium';

        CONST CHILDREN_COSTSHARING_AMOUNT_BASIC     = 350;
        CONST CHILDREN_COSTSHARING_AMOUNT_COMFORT   = 650;
        CONST CHILDREN_COSTSHARING_AMOUNT_PREMIUM   = 1000;


        /**
         * Returns provision_contribution_reimbursement the of the comparison
         *
         * @return mixed
         */
        public function get_contribution_carrier() {
            return $this->data['contribution_carrier'];
        }

        /**
         * Return german name of a state
         *
         * @throws \rs_logic_exception Invalid contribution german value
         * @return string
         */
        public function get_contribution_carrier_german() {

            $contribution_carrier_list = [
                'association' => 'Bund',
                'bw' => 'Baden-Württemberg',
                'by' => 'Bayern',
                'be' => 'Berlin',
                'bb' => 'Brandenburg',
                'hb' => 'Bremen',
                'hh' => 'Hamburg',
                'he' => 'Hessen',
                'mv' => 'Mecklenburg-Vorpommern',
                'ni' => 'Niedersachsen',
                'nw' => 'Nordrhein-Westfalen',
                'rp' => 'Rheinland-Pfalz',
                'sl' => 'Saarland',
                'sn' => 'Sachsen',
                'st' => 'Sachsen-Anhalt',
                'sh' => 'Schleswig-Holstein',
                'th' => 'Thüringen'
            ];

            $contribution_carrier = $this->get_contribution_carrier();

            if (array_key_exists($contribution_carrier, $contribution_carrier_list)) {
                return $contribution_carrier_list[$contribution_carrier];
            }

            throw new \rs_logic_exception(sprintf('Invalid contribution carrier value, expected association, bw, by, be, bb, hb, hh, he, mv, ni, nw, rp, sl, sn, st, sh, th. [contribution_carrier: %s]', $contribution_carrier));

        }

        /**
         * Returns provision_contribution_reimbursement the of the comparison
         *
         * @return mixed
         */
        public function get_contribution_rate() {
            return $this->data['contribution_rate'];
        }

        /**
         * Returns provision_contribution_reimbursement the of the comparison
         *
         * @return mixed
         */
        public function get_insured_person() {
            return $this->data['insured_person'];
        }

        /**
         * Returns provision_contribution_reimbursement the of the comparison
         *
         * @return mixed
         */
        public function get_parent1_insured() {
            return $this->data['parent1_insured'];
        }

        /**
         * Returns provision_contribution_reimbursement the of the comparison
         *
         * @return mixed
         */
        public function get_parent2_insured() {
            return $this->data['parent2_insured'];
        }

        /**
         * Returns cure_inpatient the of the comparison
         *
         * @return mixed
         */
        public function get_cure_inpatient() {
            return $this->data['cure_inpatient'];
        }

        /**
         * Returns dental_no_maximum_refund the of the comparison
         *
         * @return mixed
         */
        public function get_dental_no_maximum_refund() {
            return $this->data['dental_no_maximum_refund'];
        }

        /**
         * Returns treatment_above_maximum_rate the of the comparison
         *
         * @return mixed
         */
        public function get_treatment_above_maximum_rate() {
            return $this->data['treatment_above_maximum_rate'];
        }

        /**
         * Returns med_above_statutory_maximum_rate the of the comparison
         *
         * @return mixed
         */
        public function get_med_above_statutory_maximum_rate() {
            return $this->data['med_above_statutory_maximum_rate'];
        }

        /**
         * Returns direct_medical_consultation_benefit the of the comparison
         *
         * @return mixed
         */
        public function get_direct_medical_consultation_benefit() {
            return $this->data['direct_medical_consultation_benefit'];
        }

        /**
         * Returns amed_non_med_practitioner_reimbursement the of the comparison
         *
         * @return mixed
         */
        public function get_amed_non_med_practitioner_reimbursement() {
            return $this->data['amed_non_med_practitioner_reimbursement'];
        }

        /**
         * Returns provision_healthy_lifestyle_bonus the of the comparison
         *
         * @return mixed
         */
        public function get_provision_healthy_lifestyle_bonus() {
            return $this->data['provision_healthy_lifestyle_bonus'];
        }

        /**
         * Returns provision_contribution_reimbursement the of the comparison
         *
         * @return mixed
         */
        public function get_provision_contribution_reimbursement() {
            return $this->data['provision_contribution_reimbursement'];
        }

        /**
         * Returns the profession of the comparison.
         *
         * @return integer
         */
        public function get_profession() {
            return $this->data['profession'];
        }

        /**
         * Returns increasing_contribution of comparison.
         * Returns the profession of the comparison in German.
         *
         * @return string
         */
        public function get_profession_german() {

            $profession_list = [
                'employee' => 'Angestellter',
                'freelancer' => 'Selbständiger/Freiberufler',
                'servant' => 'Beamter',
                'servant_candidate' => 'Beamtenanwärter',
                'student' => 'Student',
                'intern' => 'Praktikant',
                'unemployed' => 'Nicht erwerbstätig',

            ];

            return $profession_list[$this->get_profession()];

        }

        /**
         * Returns the provision_costsharing_limit of the comparison
         *
         * @return integer
         */
        public function get_provision_costsharing_limit() {
            return $this->data['provision_costsharing_limit'];
        }

        /**
         * Returns the hospitalization_accommodation of the comparison
         *
         * @return integer
         */
        public function get_hospitalization_accommodation() {
            return $this->data['hospitalization_accommodation'];
        }

        /**
         * Returns the hospitalization_accommodation of the comparison in German
         *
         * @return integer
         */
        public function get_hospitalization_accommodation_german() {

            $hospitalization_accommodation_list = [
                'multi'  => 'Mehrbettzimmer oder besser',
                'double' => '2-Bett-Zimmer oder besser',
                'single' => '1-Bett-Zimmer'
            ];

            return $hospitalization_accommodation_list[$this->get_hospitalization_accommodation()];

        }

        /**
         * Returns the dental of the comparison
         *
         * @return integer
         */
        public function get_dental() {
            return $this->data['dental'];
        }

        /**
         * Returns the pdhospital_payout_amount_value of the comparison
         *
         * @return integer
         */
        public function get_pdhospital_payout_amount_value() {
            return $this->data['pdhospital_payout_amount_value'];
        }

        /**
         * Returns the pdhospital_payout_start of the comparison
         *
         * @return integer
         */
        public function get_pdhospital_payout_start() {
            return $this->data['pdhospital_payout_start'];
        }

        /**
         * Returns the pdhospital_payout_start of the comparison in the German language
         *
         * @return string
         */
        public function get_pdhospital_payout_start_german() {
            $payout_start_list = [
                '0'   => 'kein Krankentagegeld',
                '15'  => 'ab dem 15. Tag',
                '22'  => 'ab dem 22. Tag',
                '29'  => 'ab dem 29. Tag',
                '43'  => 'ab dem 43. Tag',
                '92'  => 'ab dem 92. Tag',
                '183' => 'ab dem 183. Tag'
            ];

            return $payout_start_list[$this->get_pdhospital_payout_start()];

        }

        /**
         * Return ISO date of insure date.
         *
         * @return string
         */
        public function get_insure_date() {
            return $this->data['insure_date'];
        }

        /**
         * Return ISO date of insure date.
         *
         * @return string
         */
        public function get_insure_date_german() {
            return date('d.m.Y', strtotime($this->data['insure_date']));
        }

        /**
         * Based on the birthdate, calculate the age.
         *
         * @return integer
         */
        public function get_age() {

            $birthdate = new \DateTime($this->get_birthdate());
            $today   = new \DateTime('today');
            $age = $birthdate->diff($today)->y;

            return $age;

        }

        /**
         * Returns the existing insurance parameter.
         *
         * @return string
         */
        public function get_existing_insurance() {
            return $this->data['existing_insurance'];
        }

        /**
         * Get age of chidlren
         *
         * @return integer
         */
        public function get_children_age() {
            return $this->data['children_age'];
        }

        /**
         * Return Common level of the dental service in German language
         *
         * @throws \rs_logic_exception Invalid dental german value
         * @return string
         */
        public function get_dental_german() {

            $dental_list = [
                'basic'   => 'Basis-Zahnleistung oder besser',
                'comfort' => 'Komfort-Zahnleistung oder besser',
                'premium' => 'Premium-Zahnleistung'
            ];

            $dental_german = $this->get_dental();

            if (array_key_exists($dental_german, $dental_list)) {
                return $dental_list[$dental_german];
            }

            throw new \rs_logic_exception(sprintf('Invalid dental german value, expected basic, comfort, premium. [dental_gearman: %s]', $dental_german));

        }

        /**
         * Return Treatment Doctor
         *
         * @return string
         */
        public function get_treatment_doctor() {

            if ($this->get_hospitalization_accommodation() == 'multi') {
                return '';
            }

            return ', Chefarzt';

        }

        /**
         * Return, if one of the parents is servant or servant candidate.
         *
         * Returns "yes" or "no".
         *
         * @return string
         */
        public function get_parent_servant_or_servant_candidate() {
            return $this->data['parent_servant_or_servant_candidate'];
        }

    }