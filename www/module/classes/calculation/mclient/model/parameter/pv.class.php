<?php

    namespace classes\calculation\mclient\model\parameter;

    /**
     * The parameter model for product PV.
     *
     * @author Igor Duspara <igor.duspara@check24.de>
     */
    class pv extends base {

        /**
         * Get paymentperiod
         *
         * @return string
         */
        public function get_paymentperiod() {
            return $this->data['paymentperiod'];
        }

        /**
         * Returns the birthdate of the comparison.
         *
         * @return string Iso date.
         */
        public function get_birthdate() {
            return $this->data['birthdate'];
        }

    }
