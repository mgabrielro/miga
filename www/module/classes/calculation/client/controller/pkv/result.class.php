<?php

    namespace classes\calculation\client\controller\pkv;

    /**
     * result
     *
     * @author Robert Curth <robert.curth@check24.de>
     */
    class result extends \classes\calculation\client\controller\pv\result {

        /**
         * Use our own form wrapper class to use the form elements with own template classes
         *
         * @return \classes\calculation\client\form Form object
         */
        protected function create_form_object() {

            return $this->getServiceLocator()->get('classes\calculation\client\form');

        }

        /**
         * Called in run to define the form.
         *
         * @return \shared\classes\calculation\client\form
         */
        protected function define_form() {

            $form = parent::define_form();

            $form->add_hidden_field('c24_calculate');
            $form->add_hidden_field('c24api_currentinsurancetype');
            $form->add_hidden_field('c24api_birthdate');
            $form->add_hidden_field('c24api_protectiontype');
            $form->add_hidden_field('c24api_occupation_id');
            $form->add_hidden_field('c24api_occupation_name');
            $form->add_hidden_field('c24api_sum_course');
            $form->add_hidden_field('c24api_smoker');

            $form->add_ignore_hidden_field('c24api_calculationparameter_id');

            $form->add_text_field('c24api_insure_sum', '100000');
            $form->add_text_field('c24api_insure_period', '20');

            $form->add_checkbox_field('c24api_increasing_contribution', 'no', 'yes');
            $form->add_checkbox_field('c24api_children_discount',       'no', 'yes');
            $form->add_checkbox_field('c24api_insure_sum_increase_allowed', 'no', 'yes');
            $form->add_checkbox_field('c24api_runtime_increase_allowed',    'no', 'yes');
            $form->add_checkbox_field('c24api_disability_contribution_exemption', 'no', 'yes');
            $form->add_checkbox_field('c24api_constant_contribution', 'no', 'yes');

            $form->add_select_field('c24api_paymentperiod', $this->get_payment_options(), 'month');

            $form->add_checkbox_field('c24api_allow_backdating', 'yes');

            return $form;

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

    }
