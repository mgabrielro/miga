<?php
namespace classes\calculation\client\model;

    /**
     * Backdating helper
     * @author Robert Curth <robert.curth@check24.de>
     */
    class backdating {

        var $insurance_starting_dates;
        var $enabled;

        /**
         * Constructor
         *
         * @param insurance_starting_dates $insurance_starting_dates Possible insurance starting dates
         * @param boolean $enabled Backdating allowed by user
         *
         * @return void
         */
        public function __construct($insurance_starting_dates, $enabled) {
            $this->insurance_starting_dates = $insurance_starting_dates;
            $this->enabled = $enabled;
        }

        /**
         * Is backdating active (enabled && availavle)
         *
         * @return boolean
         */
        public function is_active() {
            return false;
            if (!$this->enabled) {
                return false;
            }

            return $this->is_available();

        }

        /**
         * Could we offer backdating for this birthday
         *
         * @return boolean
         */
        public function is_available() {
            return false;
            return NULL != $this->insurance_starting_dates->get_backdated();
        }

        /**
         * The Backdated date
         *
         * @return mixed
         */
        public function get_backdated_date() {
            return $this->insurance_starting_dates->get_backdated();
        }

        /**
         * The Backdated date
         *
         * @return mixed
         */
        public function get_optimal_date() {
            return $this->insurance_starting_dates->get_optimal();
        }

        /**
         * Get the active insure date
         *
         * @return \DateTime|mixed
         */
        public function get_insure_date() {

            if ($this->is_active()){
                return $this->get_backdated_date();
            } else {
                return $this->get_default_date();
            }

        }

        /**
         * Get the default insure date
         *
         * @return \DateTime
         */
        public function get_default_date() {
            return $this->insurance_starting_dates->get_default();
        }

    }