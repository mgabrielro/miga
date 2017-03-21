<?php

    namespace classes\calculation\mclient\model\parameter;

    /**
     * The parameter model for product PKV.
     *
     * @author Igor Duspara <igor.duspara@check24.de>
     */
    class pkv extends pv {

        /**
         * Returns the birthdate of the comparison.
         *
         * @return integer
         */
        public function get_insure_sum() {
            return $this->data['insure_sum'];
        }

        /**
         * Returns the insure_period of the comparison.
         *
         * @return integer
         */
        public function get_insure_period() {
            return $this->data['insure_period'];
        }

        /**
         * Returns the smoker of the comparison.
         *
         * @return boolean
         */
        public function get_smoker() {
            return $this->data['smoker'];
        }

        /**
         * Returns occupation_id of comparison.
         *
         * @return integer
         */
        public function get_occupation_id() {
            return $this->data['occupation_id'];
        }

        /**
         * Returns occpuation_name of the comparison.
         *
         * @return string
         */
        public function get_occupation_name() {
            return $this->data['occupation_name'];
        }

        /**
         * Returns increasing_contribution of comparison.
         *
         * @return boolean
         */
        public function get_increasing_contribution() {
            return $this->data['increasing_contribution'];
        }

        /**
         * Returns children_discount of comparison.
         *
         * @return boolean
         */
        public function get_children_discount() {
            return $this->data['children_discount'];
        }

        /**
         * Return sum_increase_allowed of comparison.
         *
         * @return boolean
         */
        public function get_insure_sum_increase_allowed() {
            return $this->data['insure_sum_increase_allowed'];
        }

        /**
         * Returns runtime_increase_allowed of comparison.
         *
         * @return boolean
         */
        public function get_runtime_increase_allowed() {
            return $this->data['runtime_increase_allowed'];
        }

        /**
         * Returns disability_contribution_exemption of comparison.
         *
         * @return boolean
         */
        public function get_disability_contribution_exemption() {
            return $this->data['disability_contribution_exemption'];
        }

        /**
         * Returns sum_course from comparison.
         *
         * @return string
         */
        public function get_sum_course() {
            return $this->data['sum_course'];
        }

        /**
         * Returns the constant_sum of the comparison.
         *
         * @return boolean
         */
        public function get_constant_sum() {
            return $this->data['constant_sum'];
        }

        /**
         * Returns the constant_sum of the comparison.
         *
         * @return boolean
         */
        public function get_protectiontype() {
            return $this->data['protectiontype'];
        }

        /**
         * Returns constant_contribution of comparision.
         *
         * @return boolean
         */
        public function get_constant_contribution() {
            return $this->data['constant_contribution'];
        }

        /**
         * Return ISO date of insure date.
         *
         * @return string
         */
        public function get_insure_date() {
            return $this->data['insure_date'];
        }

    }