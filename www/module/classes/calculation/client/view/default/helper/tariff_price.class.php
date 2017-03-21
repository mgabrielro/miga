<?php

namespace shared\classes\calculation\client\view\helper;
use classes\calculation\client\model\backdating;
use \DateTime;
use classes\calculation\client\model\insurance_starting_dates;
use shared\classes\calculation\client\model\tariff;
use shared\classes\calculation\client\view;

    /**
     * Renders the tariff price
     *
     * @author Robert Curth <robert.curth@check24.de>
     */
    class tariff_price extends base {

        private $tariff;
        private $secondary_tariff;

        /**
         * Constructor
         *
         * @param view $view View
         * @param tariff $tariff Tariff
         * @param tariff $secondary_tariff Secondary Tariff
         * @param backdating $backdating Backdating info
         *
         * @return void
         */
        public function __construct(view $view, tariff $tariff, tariff $secondary_tariff, $backdating) {

            $this->view = $view;
            $this->tariff  = $tariff;
            $this->secondary_tariff  = $secondary_tariff;
            $this->backdating = $backdating;

            parent::__construct($view);

        }

        /**
         * Renders the tariff's price
         *
         * @return string
         */
        protected function create_output() {

            $this->view->backdating = $this->backdating;
            $this->view->backdated_months = $this->backdated_months();
            $this->view->tariff = $this->tariff;
            $this->view->secondary_tariff = $this->secondary_tariff;
            $this->view->lifetime_savings = $this->lifetime_savings($this->tariff, $this->secondary_tariff);
            $this->view->insure_date = $this->backdating->get_optimal_date()->format('d.m.Y');

            return $this->view->render('pkv/tariff_price.phtml');

        }

        /**
         * Calculates how many month earlier the insurance would start
         *
         * @return integer
         */
        protected function backdated_months() {

            if (!$this->backdating->get_backdated_date()){
                return 0;
            }

            return date_diff($this->backdating->get_backdated_date(), $this->backdating->get_default_date())->format('%m');

        }


        /**
         * Calculates the lifetime savings for between a tariff pair
         *
         * @param array $backdated_tariff Backdated tariff
         * @param array $default_tariff The tariff with the default starting date
         *
         * @return float
         */
        protected function lifetime_savings($backdated_tariff, $default_tariff) {

            $backdated_price = $backdated_tariff->get_paymentperiod_size();
            $default_price = $default_tariff->get_paymentperiod_size();

            $payment_period_factors = [
                'year' => 1,
                'semester' => 2,
                'quarter' => 4,
                'month' => 12
            ];

            $years = $this->tariff->parameter->get_data()['insure_period'];
            $payment_periods_in_year = $payment_period_factors[$backdated_tariff->get_paymentperiod_period()];
            $payment_period_price_diff = ($default_price - $backdated_price);

            return round($payment_period_price_diff * $payment_periods_in_year * $years);

        }

    }