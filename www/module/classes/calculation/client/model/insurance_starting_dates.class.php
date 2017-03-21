<?php
namespace classes\calculation\client\model;
use DateTime;

    /**
     * Calculates the cheapest insure date
     *
     * @author Robert Curth <robert.curth@check24.de>
     */
    class insurance_starting_dates {

        private $birthdate;
        private $now;

        /**
         * Constructor
         *
         * @param string $birthdate Birthdate of the insured person
         * @param string $now Date of the calculation (default to current date)
         *
         * @return void
         */
        public function __construct($birthdate, $now = NULL) {
            $this->birthdate = new DateTime($birthdate);
            $this->now = $now ? $now : new DateTime();
        }

        /**
         * Calculates the optimal insurance date
         *
         * @return DateTime
         */
        public function get_optimal() {
            return $this->get_backdated() ? $this->get_backdated() : $this->get_default();
        }

        /**
         * Calculates the backdated insurance date (if available)
         *
         * @return DateTime
         */
        public function get_backdated() {
            if ($this->is_backdateable()) {
                return $this->date_before_birthday();
            }
        }

        /**
         * Calculates the default date when the insurance starts
         *
         * @return DateTime
         */
        public function get_default() {
            $now = clone($this->now);
            return $now->modify('first day of next month');
        }

        /**
         * Checks, whether we can offer backdating
         *
         * @return boolean
         */
        protected function is_backdateable() {

            if ($this->date_before_birthday()->format('Y') != $this->now->format('Y')) {
                return false;
            }

            return $this->month_diff() >= 0 && $this->month_diff() <= 2;

        }

        /**
         * Backdated date
         *
         * @return DateTime
         */
        protected function date_before_birthday() {

            $birthday_this_year = $this->birthday_this_year();

            if ($birthday_this_year->format('d') == '1') {
                return $birthday_this_year->modify('first day of last month');
            }

            return $birthday_this_year->modify('first day of this month');
            
        }

        /**
         * Difference between current month and month of birthday
         *
         * @return integer
         */
        protected function month_diff() {

            $birthday_month = (int) $this->date_before_birthday()->format('m');
            $current_month = (int) $this->now->format('m');
            return ($current_month - $birthday_month);

        }

        /**
         * Calculates this years birthday
         *
         * @return DateTime
         */
        protected function birthday_this_year() {
            return new DateTime($this->now->format('Y-') . $this->birthdate->format('m-d'));
        }

    }
