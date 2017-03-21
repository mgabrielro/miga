<?php

    namespace classes\calculation\mclient\controller\pkv {

        /**
         * result
         *
         * Power result
         *
         * @author Everyone
         */
        class result extends \classes\calculation\mclient\controller\pv\result {

            /**
             * Use our own form wrapper class to use the form elements with own template classes
             *
             * @return \classes\calculation\mclient\form Form object
             */
            protected function create_form_object() {
                return $this->getServiceLocator()->get('classes\calculation\mclient\form');
            }

            /**
             * Called in run to define the form.
             *
             * @return \shared\classes\calculation\client\form
             */
            protected function define_form() {

                $form = parent::define_form();

                $form->add_hidden_field('c24_calculate');
                $form->add_hidden_field('c24api_birthdate');
                $form->add_hidden_field('c24api_sortfield', 'promotion');
                $form->add_hidden_field('c24api_sortorder', 'asc');

                $form->set_state(
                    \classes\filter\abstract_profession_person_state::factory($this->parameters['c24api_profession'], $this->parameters['c24api_insured_person'])
                );

                $form->add_hidden_field('c24api_product_id', (string)get_def('product_id'));
                $form->add_hidden_field('c24api_profession', '');
                $form->add_hidden_field('c24api_insured_person', '');

                $form->add_hidden_field('c24api_calculationparameter_id');

                /**
                 * This is the flag which will inform us from what page we are coming.
                 *
                 * Later when we will call the calculation server, in case this flag is set,
                 * we will together with all parameters the calculationparmaeter_id too, but if we are
                 * coming from another page, we will NOT send it anymore, because else we will NOT receive
                 * a new calculation (see BUG - PVPKV-2989)
                 */
                $form->add_ignore_hidden_field('c24api_from_input1');

                $form->add_checkbox_field('c24api_provision_contribution_reimbursement', 'no');
                $form->add_checkbox_field('c24api_provision_healthy_lifestyle_bonus', 'no');
                $form->add_checkbox_field('c24api_amed_non_med_practitioner_reimbursement', 'no');
                $form->add_checkbox_field('c24api_direct_medical_consultation_benefit', 'no');
                $form->add_checkbox_field('c24api_med_above_statutory_maximum_rate', 'no');
                $form->add_checkbox_field('c24api_treatment_above_maximum_rate', 'no');
                $form->add_checkbox_field('c24api_dental_no_maximum_refund', 'no');
                $form->add_checkbox_field('c24api_cure_and_rehab', 'no');

                $insure_date = $this->get_insure_date();

                $form->add_select_field('c24api_insure_date', $insure_date['months'], $insure_date['defaultMonth']);

                $form->add_select_field('c24api_provision_costsharing_limit', $this->get_provision_costsharing_limit(), $form->get_state()
                    ->getDefaultProvisionCostsharingLimit());

                $form->add_select_field('c24api_dental', $this->get_dental_list(), $form->get_state()
                    ->getDefaultDental());

                $form->add_select_field('c24api_hospitalization_accommodation', $form->get_state()->getAccomondationOptionsResult(), $form->get_state()
                    ->getDefaultHospitalizationAccommodation());

                $form->add_select_field('c24api_pdhospital_payout_start', $form->get_state()->getPayoutStartOptions(), $form->get_state()
                    ->getDefaultPdhospitalPayoutStart());

                $form->add_select_field('c24api_pdhospital_payout_amount_value', $this->get_pdhospital_payout_amount_list(), $form->get_state()
                    ->getDefaultPdhospitalPayoutAmount());


                return $form;

            }

            /**
             * Handle form data
             *
             * Prepair data before sending to api
             *
             * @param array $data Data
             * @return array
             */
            protected function handle_form_data(array $data) {
                return $data;
            }

            /**
             * Handle api parameter
             *
             * @param array $data Data
             * @return array
             */
            protected function handle_api_parameter(array $data) {

                $data = parent::handle_api_parameter($data);

                return $data;

            }

            /**
             * Defines the result view.
             *
             * @param \shared\classes\calculation\client\form $form Form to use.
             * @return \shared\classes\calculation\client\view
             */
            protected function define_result_view(\shared\classes\calculation\client\form $form) {

                $view = parent::define_result_view($form);
                return $view;

            }

            /**
             * Defines the header view.
             *
             * @param \shared\classes\calculation\client\form $form Form to use.
             * @return \shared\classes\calculation\client\view
             */
            protected function define_header_view(\shared\classes\calculation\client\form $form) {

                $view = parent::define_header_view($form);
                $view->gap_count = $this->response->get_data('parameter/gap_count');
                return $view;

            }

            /**
             * Get the select list options.
             *
             * @return array
             */
            protected function get_tariff_options() {

                static $tariff_options = NULL;

                if ($tariff_options === NULL) {

                    $tariff_options['excellent'] = 'sehr gut';
                    $tariff_options['very_good'] = 'mindestens gut';
                    $tariff_options['low']       = 'mindestens gering';
                    $tariff_options['no']        = 'alle Tarife';

                }

                return $tariff_options;

            }

            /**
             * Calculate the insurance start
             *
             * @return array
             */
            public function get_insure_date() {

                $date = new \DateTime('first day of this month');
                $defaultMonth = "";
                $date->sub(new \DateInterval('P2M'));
                $months = [];

                $today = new \DateTime('first day of this month');
                $is_december = $today->format('n') == 12 ? true : false;

                if($is_december) {

                    // Must remain December
                    $defaultMonth = $today->format('Y-m-d');

                }

                // we need 7 options in select list, starting with 2 months before now()
                for ($m = 0; $m < 7; $m++) {

                    $monthString = $date->format('d. ') . get_def('months')[$date->format('n')] . $date->format(' Y');
                    $isoMonth = $date->format('Y-m-d');

                    if ($m == 3 && !$is_december) {

                        // Default month will be the next month
                        $defaultMonth = $isoMonth;

                    }

                    $months[$isoMonth] = $monthString;
                    $date->add(new \DateInterval('P1M'));

                }

                return [
                    'months' => $months,
                    'defaultMonth' => $defaultMonth
                ];

            }

            /**
             * Get the Dental list
             *
             * @return array
             */
            public function get_dental_list() {
                return ['basic' => 'Basis', 'comfort' => 'Komfort', 'premium' => 'Premium'];
            }

            /**
             * Get the provision costsharing limit list ("Selbstbeteiligung")
             *
             * @return array
             */
            public function get_provision_costsharing_limit() {

                return [
                    '0'    => '0 €',
                    '350'  => 'max. 350 €',
                    '650'  => 'max. 650 €',
                    '800'  => 'max. 800 €',
                    '1000' => 'max. 1.000 €',
                    '1300' => 'max. 1.300 €',
                    '1600' => 'max. 1.600 €',
                    '-1'   => 'alle Werte anzeigen'
                ];

            }

            /**
             * Get the pdhospital_payout_amount list
             *
             * @return array
             */
            public function get_pdhospital_payout_amount_list() {

                $amounts = [];

                for ($amount = 0; $amount <= 200; $amount += 25) {
                    $amounts[$amount] = $amount . ' €';
                }

                return $amounts;

            }
            
            /**
             * Get the select list options.
             *
             * @return array
             */
            protected function get_payment_options() {

                static $payment_options = NULL;

                if ($payment_options === NULL) {

                    $payment_options['year']     = 'jährlich';
                    $payment_options['semester'] = 'halbjährlich';
                    $payment_options['quarter']  = 'vierteljährlich';
                    $payment_options['month']    = 'monatlich';

                }

                return $payment_options;

            }

            /**
             * Get the select list options.
             *
             * @param integer $months_count Month count
             * @return array
             */
            protected function get_insure_date_options($months_count = 5) {

                static $insure_date_options = NULL;

                if ($insure_date_options === NULL) {

                    $insure_date_values = [];
                    $date_today = new \DateTime(date('Y-m-d'));
                    $date = new \DateTime(date('Y-m-01'));

                    if ($date_today->format('j') >= 15) {
                        $date->modify('+1 month');
                    } else if ($date_today->format('j') == 14 && ($date_today->format('w') == 0 || $date_today->format('w') >= 5)) {
                        $date->modify('+1 month');
                    }

                    for ($i = 0; $i < $months_count; $i++) {

                        $insure_date_options[$date->format('Y-m-d')] = $date->format('d.m.Y');
                        $date->modify('+1 month');

                    }

                }

                return $insure_date_options;

            }

            /**
             * Generates the default insure date
             *
             * @return \DateTime
             */
            public static function get_default_insure_date() {

                $default_insure_date = new \DateTime(date('Y-m-01'));
                $default_insure_date->modify('+' . (date('d') <= 20 ? 1 : 2) . ' month');

                return $default_insure_date->format('Y-m-d');

            }

        }

    }
