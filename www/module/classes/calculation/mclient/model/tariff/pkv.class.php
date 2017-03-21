<?php

    namespace classes\calculation\mclient\model\tariff;

    /**
     * Represents the tariff model for pkv.
     *
     * @author Igor Duspara <igor.duspara@check24.de>
     */
    class pkv extends pv {

        /**
         * Returns the tariff product id.
         *
         * @return integer
         */
        public function get_tariff_product_id() {
            return 21;
        }

        /**
         * Returns acceptance_rate_by_insurer
         *
         * @return string
         */
        public function get_acceptance_rate_by_insurer() {
            return $this->data['tariff']['product_dependent_features']['acceptance_rate_by_insurer'];
        }

        /**
         * Returns additional_health_examination_by_doctor
         *
         * @return string
         */
        public function get_additional_health_examination_by_doctor() {
            return $this->data['tariff']['product_dependent_features']['additional_health_examination_by_doctor'];
        }

        /**
         * Returns additional_health_examination_by_doctor_comment
         *
         * @return string
         */
        public function get_additional_health_examination_by_doctor_comment() {
            return $this->data['tariff']['product_dependent_features']['additional_health_examination_by_doctor_comment'];
        }

        /**
         * Returns air_sport
         *
         * @return string
         */
        public function get_air_sport() {
            return $this->data['tariff']['product_dependent_features']['air_sport'];
        }

        /**
         * Returns air_sport_comment
         *
         * @return string
         */
        public function get_air_sport_comment() {
            return $this->data['tariff']['product_dependent_features']['air_sport_comment'];
        }

        /**
         * Returns average_contribution
         *
         * @return integer
         */
        public function get_average_contribution() {
            return $this->data['tariff']['product_dependent_features']['average_contribution'];
        }

        /**
         * Returns complaints_rate
         *
         * @return string
         */
        public function get_complaints_rate() {
            return $this->data['tariff']['product_dependent_features']['complaints_rate'];
        }

        /**
         * Returns contract_cancellation
         *
         * @return string
         */
        public function get_contract_cancellation() {
            return $this->data['tariff']['product_dependent_features']['contract_cancellation'];
        }

        /**
         * Returns contribution_history_of_run_time
         *
         * @return string
         */
        public function get_contribution_history_of_run_time() {
            return $this->data['tariff']['product_dependent_features']['contribution_history_of_run_time'];
        }

        /**
         * Returns contribution_history_of_run_time_comment
         *
         * @return string
         */
        public function get_contribution_history_of_run_time_comment() {
            return $this->data['tariff']['product_dependent_features']['contribution_history_of_run_time_comment'];
        }

        /**
         * Returns diving_sport
         *
         * @return string
         */
        public function get_diving_sport() {
            return $this->data['tariff']['product_dependent_features']['diving_sport'];
        }

        /**
         * Returns diving_sport_comment
         *
         * @return string
         */
        public function get_diving_sport_comment() {
            return $this->data['tariff']['product_dependent_features']['diving_sport_comment'];
        }

        /**
         * Returns dynamic_min
         *
         * @return float
         */
        public function get_dynamic_min() {
            return $this->data['tariff']['product_dependent_features']['dynamic_min'];
        }

        /**
         * Returns dynamic_max
         *
         * @return float
         */
        public function get_dynamic_max() {
            return $this->data['tariff']['product_dependent_features']['dynamic_max'];
        }

        /**
         * Returns early_death_benefit
         *
         * @return string
         */
        public function get_early_death_benefit() {
            return $this->data['tariff']['product_dependent_features']['early_death_benefit'];
        }

        /**
         * Returns easy_start_option
         *
         * @return string
         */
        public function get_easy_start_option() {
            return $this->data['tariff']['product_dependent_features']['easy_start_option'];
        }

        /**
         * Returns easy_start_option_comment
         *
         * @return string
         */
        public function get_easy_start_option_comment() {
            return $this->data['tariff']['product_dependent_features']['easy_start_option_comment'];
        }

        /**
         * Returns extension_option
         *
         * @return string
         */
        public function get_extension_option() {
            return $this->data['tariff']['product_dependent_features']['extension_option'];
        }

        /**
         * Returns extension_option_comment
         *
         * @return string
         */
        public function get_extension_option_comment() {
            return $this->data['tariff']['product_dependent_features']['extension_option_comment'];
        }

        /**
         * Returns health_examination_period
         *
         * @return string
         */
        public function get_health_examination_period() {
            return $this->data['tariff']['product_dependent_features']['health_examination_period'];
        }

        /**
         * Returns health_examination_period_comment
         *
         * @return string
         */
        public function get_health_examination_period_comment() {
            return $this->data['tariff']['product_dependent_features']['health_examination_period_comment'];
        }

        /**
         * Returns health_issues_self_disclosure_by_customer
         *
         * @return string
         */
        public function get_health_issues_self_disclosure_by_customer() {
            return $this->data['tariff']['product_dependent_features']['health_issues_self_disclosure_by_customer'];
        }

        /**
         * Returns increase_of_risk
         *
         * @return string
         */
        public function get_increase_of_risk() {
            return $this->data['tariff']['product_dependent_features']['increase_of_risk'];
        }

        /**
         * Returns increase_option
         *
         * @return string
         */
        public function get_increase_option() {
            return $this->data['tariff']['product_dependent_features']['increase_option'];
        }

        /**
         * Returns increase_option_comment
         *
         * @return string
         */
        public function get_increase_option_comment() {
            return $this->data['tariff']['product_dependent_features']['increase_option_comment'];
        }

        /**
         * Returns increasing_the_payout_for_accidental_death
         *
         * @return string
         */
        public function get_increasing_the_payout_for_accidental_death() {
            return $this->data['tariff']['product_dependent_features']['increasing_the_payout_for_accidental_death'];
        }

        /**
         * Returns insured_sum_history
         *
         * @return string
         */
        public function get_insured_sum_history() {
            return $this->data['tariff']['product_dependent_features']['insured_sum_history'];
        }

        /**
         * Returns insurer_financial_stability
         *
         * @return string
         */
        public function get_insurer_financial_stability() {
            return $this->data['tariff']['product_dependent_features']['insurer_financial_stability'];
        }

        /**
         * Returns insurer_market_share
         *
         * @return string
         */
        public function get_insurer_market_share() {
            return $this->data['tariff']['product_dependent_features']['insurer_market_share'];
        }

        /**
         * Returns motorcyclist_regular_road
         *
         * @return string
         */
        public function get_motorcyclist_regular_road() {
            return $this->data['tariff']['product_dependent_features']['motorcyclist_regular_road'];
        }

        /**
         * Returns motorcyclist_regular_road_comment
         *
         * @return string
         */
        public function get_motorcyclist_regular_road_comment() {
            return $this->data['tariff']['product_dependent_features']['motorcyclist_regular_road_comment'];
        }

        /**
         * Returns mountain_sport
         *
         * @return string
         */
        public function get_mountain_sport() {
            return $this->data['tariff']['product_dependent_features']['mountain_sport'];
        }

        /**
         * Returns mountain_sport_comment
         *
         * @return string
         */
        public function get_mountain_sport_comment() {
            return $this->data['tariff']['product_dependent_features']['mountain_sport_comment'];
        }

        /**
         * Returns nationality
         *
         * @return string
         */
        public function get_nationality() {
            return $this->data['tariff']['product_dependent_features']['nationality'];
        }

        /**
         * Returns suitable_for_smoker
         *
         * @return string
         */
        public function get_suitable_for_smoker() {
            return $this->data['tariff']['product_dependent_features']['suitable_for_smoker'];
        }

        /**
         * Returns non_smoker_years
         *
         * @return integer
         */
        public function get_non_smoker_years() {
            return $this->data['tariff']['product_dependent_features']['non_smoker_years'];
        }

        /**
         * Returns non_smoker_comment
         *
         * @return string
         */
        public function get_non_smoker_comment() {
            return $this->data['tariff']['product_dependent_features']['non_smoker_comment'];
        }

        /**
         * Returns children
         *
         * @return string
         */
        public function get_children() {
            return $this->data['tariff']['product_dependent_features']['children'];
        }

        /**
         * Returns children_comment
         *
         * @return string
         */
        public function get_children_comment() {
            return $this->data['tariff']['product_dependent_features']['children_comment'];
        }

        /**
         * Returns objection_of_a_contract
         *
         * @return string
         */
        public function get_objection_of_a_contract() {
            return $this->data['tariff']['product_dependent_features']['objection_of_a_contract'];
        }

        /**
         * Returns paying_out_at_dread_disease
         *
         * @return string
         */
        public function get_paying_out_at_dread_disease() {
            return $this->data['tariff']['product_dependent_features']['paying_out_at_dread_disease'];
        }

        /**
         * Returns payment_contribution
         *
         * @return integer
         */
        public function get_payment_contribution() {
            return $this->data['tariff']['product_dependent_features']['payment_contribution'];
        }

        /**
         * Returns performance_in_case_of_death
         *
         * @return string
         */
        public function get_performance_in_case_of_death() {
            return $this->data['tariff']['product_dependent_features']['performance_in_case_of_death'];
        }

        /**
         * Returns performance_in_case_of_death_comment
         *
         * @return string
         */
        public function get_performance_in_case_of_death_comment() {
            return $this->data['tariff']['product_dependent_features']['performance_in_case_of_death_comment'];
        }

        /**
         * Returns performance_in_case_of_death_abroad
         *
         * @return string
         */
        public function get_performance_in_case_of_death_abroad() {
            return $this->data['tariff']['product_dependent_features']['performance_in_case_of_death_abroad'];
        }

        /**
         * Returns performance_in_case_of_death_abroad_comment
         *
         * @return string
         */
        public function get_performance_in_case_of_death_abroad_comment() {
            return $this->data['tariff']['product_dependent_features']['performance_in_case_of_death_abroad_comment'];
        }

        /**
         * Returns preliminary_insurance_cover
         *
         * @return string
         */
        public function get_preliminary_insurance_cover() {
            return $this->data['tariff']['product_dependent_features']['preliminary_insurance_cover'];
        }

        /**
         * Returns preliminary_insurance_cover_comment
         *
         * @return string
         */
        public function get_preliminary_insurance_cover_comment() {
            return $this->data['tariff']['product_dependent_features']['preliminary_insurance_cover_comment'];
        }

        /**
         * Returns profit_participation_maximum_of_contribution
         *
         * @return integer
         */
        public function get_profit_participation_maximum_of_contribution() {
            return $this->data['tariff']['product_dependent_features']['profit_participation_maximum_of_contribution'];
        }

        /**
         * Returns reimbursement_of_health_examination
         *
         * @return string
         */
        public function get_reimbursement_of_health_examination() {
            return $this->data['tariff']['product_dependent_features']['reimbursement_of_health_examination'];
        }

        /**
         * Returns reimbursement_of_health_examination_comment
         *
         * @return string
         */
        public function get_reimbursement_of_health_examination_comment() {
            return $this->data['tariff']['product_dependent_features']['reimbursement_of_health_examination_comment'];
        }

        /**
         * Returns residence
         *
         * @return string
         */
        public function get_residence() {
            return $this->data['tariff']['product_dependent_features']['residence'];
        }

        /**
         * Returns special_tariff_conditions
         *
         * @return string
         */
        public function get_special_tariff_conditions() {
            return $this->data['tariff']['product_dependent_features']['special_tariff_conditions'];
        }

        /**
         * Returns stable_profit_participation_last_ten_years
         *
         * @return string
         */
        public function get_stable_profit_participation_last_ten_years() {
            return $this->data['tariff']['product_dependent_features']['stable_profit_participation_last_ten_years'];
        }

        /**
         * Returns stable_profit_participation_last_ten_years_comment
         *
         * @return string
         */
        public function get_stable_profit_participation_last_ten_years_comment() {
            return $this->data['tariff']['product_dependent_features']['stable_profit_participation_last_ten_years_comment'];
        }

        /**
         * Returns takeover_contributions_on_occupational_disability
         *
         * @return string
         */
        public function get_takeover_contributions_on_occupational_disability() {
            return $this->data['tariff']['product_dependent_features']['takeover_contributions_on_occupational_disability'];
        }

        /**
         * Returns takeover_contributions_to_disability
         *
         * @return string
         */
        public function get_takeover_contributions_to_disability() {
            return $this->data['tariff']['product_dependent_features']['takeover_contributions_to_disability'];
        }

        /**
         * Returns tariff_to_non_smoking_tariff
         *
         * @return string
         */
        public function get_tariff_to_non_smoking_tariff() {
            return $this->data['tariff']['product_dependent_features']['tariff_to_non_smoking_tariff'];
        }

        /**
         * Returns terms
         *
         * @return string
         */
        public function get_terms() {
            return $this->data['tariff']['product_dependent_features']['terms'];
        }

        /**
         * Returns the application_from_interface
         *
         * @return string
         */
        public function get_application_from_interface() {
            return $this->data['tariff']['product_dependent_features']['application_from_interface'];
        }

        /**
         * Returns the application_extra_from_interface
         *
         * @return string
         */
        public function get_application_extra_from_interface() {
            return $this->data['tariff']['product_dependent_features']['application_extra_from_interface'];
        }

        /**
         * Returns the vvg_from_interface
         *
         * @return string
         */
        public function get_vvg_from_interface() {
            return $this->data['tariff']['product_dependent_features']['vvg_from_interface'];
        }

        /**
         * Returns the total_score
         *
         * @return integer
         */
        public function get_total_score() {
            return $this->data['tariff']['product_dependent_features']['total_score'];
        }

        /**
         * Returns the extra_bullet_icon
         *
         * @return string
         */
        public function get_extra_bullet_icon() {
            return $this->data['tariff']['product_dependent_features']['extra_bullet_icon'];
        }

        /**
         * Returns the extra_bullet
         *
         * @return string
         */
        public function get_extra_bullet() {
            return $this->data['tariff']['product_dependent_features']['extra_bullet'];
        }

        /**
         * Returns the extra_bullet for mobile
         *
         * @return string
         */
        public function get_extra_bullet_mobile() {
            return $this->data['tariff']['product_dependent_features']['extra_bullet_mobile'];
        }

        /**
         * Returns the extra_bullet tooltip
         *
         * @return string
         */
        public function get_extra_bullet_tooltip() {
            return $this->data['tariff']['product_dependent_features']['extra_bullet_tooltip'];
        }

        /**
         * Returns the final age
         *
         * @return string
         */
        public function get_finalage() {
            return $this->data['tariff']['product_dependent_features']['finalage'];
        }

        /**
         * Returns the max period
         *
         * @return integer
         */
        public function get_maxperiod() {
            return $this->data['tariff']['product_dependent_features']['maxperiod'];
        }

        /**
         * Returns the min period
         *
         * @return integer
         */
        public function get_minperiod() {
            return $this->data['tariff']['product_dependent_features']['minperiod'];
        }

        /**
         * Returns the max insurance sum
         *
         * @return integer
         */
        public function get_maxinsurancesum() {
            return $this->data['tariff']['product_dependent_features']['maxinsurancesum'];
        }

        /**
         * Returns the min insurance sum
         *
         * @return integer
         */
        public function get_mininsurancesum() {
            return $this->data['tariff']['product_dependent_features']['mininsurancesum'];
        }

        /**
         * Get price progression
         *
         * @return array
         */
        public function get_price_progression() {
            return $this->data['price']['progression'];
        }

        /**
         * Returns the resulting grade (based on total / max).
         *
         * @return float
         */
        public function get_tariff_grade_result() {
            return $this->data['tariff']['features']['global']['content']['grade'];
        }

        /**
         * Returns the name of the calculated grade (like "sehr gut").
         *
         * @return string
         */
        public function get_tariff_grade_name() {
            return $this->data['tariff']['features']['global']['content']['name'];
        }

        /**
         * Get the tariff special_action array
         *
         * @return array
         */
        public function get_special_action() {
            //return $this->data['special_action'];
            return array ('active' => 'no');
        }

        /**
         * Determines running special actions for tariff
         *
         * @return boolean
         */
        public function has_special_action_running() {

            return '';

            if ($this->get_special_action()['active'] == 'yes' &&
                date('Y-m-d H:i:s', strtotime($this->get_special_action()['valid_to'])) >= date('Y-m-d H:i:s')) {
                return true;
            } else {
                return false;
            }

        }

        /* TODO: PKV methods listed below, remove unnecessary methods from above */

        /**
         * Is favorite tariff?
         *
         * @return boolean
         */
        public function is_favorite_tariff() {
            return isset($this->data['result']['is_favorite']) && $this->data['result']['is_favorite'] == 'yes';
        }

        /**
         * Get is promo tariff
         *
         * @return boolean
         */
        public function is_promo_tariff($is_compare_reg = false) {

            $is_new_promotion = isset($this->data['tariff']['promotion_version_new']) && $this->data['tariff']['promotion_version_new'];

            if ($is_new_promotion && isset($this->data['tariff']['promotion_type'])) {

                $is_promo = ($this->get_result_position() == 0 && !empty($this->data['tariff']['promotion_type']));
                return $is_promo;

            } else if (!$is_compare_reg && !$is_new_promotion) {
                return ($this->get_result_position() == 0 && $this->get_tariff_promotion() != 'no');
            } else {
                return $this->get_tariff_promotion();
            }

        }

        /**
         * Get potentially value for a reordered promoted tariff.
         *
         * The promoted tariffs should be on the first positions of results
         * and also in organic results. This functions returns the value if
         * the promo tariff is in organic result.
         *
         * @return boolean
         */
        public function is_promo_reordered_tariff() {

            if (isset($this->data['result']['promoted_reordered'])) {
                return $this->data['result']['promoted_reordered'] == 'yes';
            }

            return false;

        }

        /**
         * Get promotion type.
         *
         * @return string
         */
        public function get_promotion_type() {

            $promotion_type = '';

            if (isset($this->data['tariff']['promotion_type'])) {
                $promotion_type = $this->data['tariff']['promotion_type'];
            }

            return $promotion_type;

        }

        /**
         * Returns the payment period size contribution (net).
         *
         * @return float
         */
        public function get_paymentperiod_size_net_contribution() {
            return $this->data['paymentperiod']['size']['net']['contribution'];
        }

        /**
         * Retrurn the price difference text between the moment when the user
         * saved the tariff as favorite and the actual price - see PVPKV-3246
         *
         * @return string
         */
        public function get_price_difference_text() {

            if(isset($this->data['paymentperiod']['size']['price_difference_text'])) {
                return $this->data['paymentperiod']['size']['price_difference_text'];
            }

            return '';

        }

        /**
         * Returns the payment period size saving (net).
         *
         * @return float
         */
        public function get_paymentperiod_size_net_saving() {
            return $this->data['paymentperiod']['size']['net']['saving'];
        }

        /**
         * Returns the payment period size saving (net) per year.
         *
         * @return float
         */
        public function get_paymentperiod_size_net_saving_per_year() {
            return $this->get_paymentperiod_size_net_saving() * 12;
        }

        /**
         * Get tariff features
         *
         * @return mixed
         */
        public function get_tariff_features() {
            return $this->data['tariff']['features'];
        }

        /**
         * Set features tree
         *
         * @param array $features Features
         *
         * @return void
         */
        public function set_tariff_features($features) {
            $this->data['tariff']['features'] = $features;
        }

        /**
         * The percentage of the reimbursement of medical service (Erstattung ärztl. Leistungen)
         *
         * @return float
         */
        public function get_med_reimbursement() {
            return $this->data['tariff']['product_dependent_features']['med_reimbursement'];
        }

        /**
         * The comment of the reimbursement of medical service.
         *
         * @return string|null
         */
        public function get_med_reimbursement_comment() {
            return $this->data['tariff']['product_dependent_features']['med_reimbursement_comment'];
        }

        /**
         * The percentage of the direct medical consultation benefits (Leistung bei Direktkonsultation Facharzt)
         *
         * @return float
         */
        public function get_med_direct_medical_consultation() {
            return $this->data['tariff']['product_dependent_features']['med_direct_medical_consultation'];
        }

        /**
         * Health care screening check (Vorsorgeuntersuchungen über GKV-Niveau)
         * Possible values: yes, no.
         *
         * @return string
         */
        public function get_med_healthcare_screening_check() {
            return $this->data['tariff']['product_dependent_features']['med_healthcare_screening_check'];
        }

        /**
         * Benefits above maximum rate (Leistungen über Regelsätze der Gebührenordnung)
         * Possible values; yes, no.
         *
         * @return string
         */
        public function get_med_above_maximum_rate() {
            return $this->data['tariff']['product_dependent_features']['med_above_maximum_rate'];
        }

        /**
         * Benefits above statutory maximum rate (Leistungen über Höchstsätze der Gebührenordnung)
         * Possible values; yes, no.
         *
         * @return string
         */
        public function get_med_above_statutory_maximum_rate() {
            return $this->data['tariff']['product_dependent_features']['med_above_statutory_maximum_rate'];
        }

        /**
         * Reimbursement of recommend inoculation (Übernahme empfohlene Schutzimpfungen)
         * Possible values: yes, no.
         *
         * @return string
         */
        public function get_med_recommend_inoculation_reimbursement() {
            return $this->data['tariff']['product_dependent_features']['med_recommend_inoculation_reimbursement'];
        }

        /**
         * Foreign travel inoculation (Schutzimpfungen für Auslandsreisen)
         *
         * @return string
         */
        public function get_med_foreign_travel_inoculation() {
            return $this->data['tariff']['product_dependent_features']['med_foreign_travel_inoculation'];
        }

        /**
         * Foreign travel inoculation (Schutzimpfungen für Auslandsreisen).
         *
         * @return integer
         */
        public function get_med_foreign_travel_inoculation_limit() {
            return $this->data['tariff']['product_dependent_features']['med_foreign_travel_inoculation_limit'];
        }

        /**
         * Fertility treatment (Kinderwunschbehandlung)
         * Possible values: yes, no.
         *
         * @return string
         */
        public function get_med_fertility_treatment() {
            return $this->data['tariff']['product_dependent_features']['med_fertility_treatment'];
        }

        /**
         * Inpatient transport cost (ambulante Transportkosten)
         * Possible values: yes, no.
         *
         * @return string
         */
        public function get_med_inpatient_transport_cost() {
            return $this->data['tariff']['product_dependent_features']['med_inpatient_transport_cost'];
        }

        /**
         * The percentage of the reimbursement of drugs (Erstattung Arznei- und Verbandsmittel)
         *
         * @return float
         */
        public function get_drug_reimbursement() {
            return $this->data['tariff']['product_dependent_features']['drug_reimbursement'];
        }

        /**
         * The percentage of the reimbursement of direct medical consulting (Erstattung bei Direktkonsultation Facharzt)
         *
         * @return float
         */
        public function get_drug_direct_consulting_reimbursement() {
            return $this->data['tariff']['product_dependent_features']['drug_direct_consulting_reimbursement'];
        }

        /**
         * The percentage of the general refund of health aid (Generelle Erstattung Hilfsmittel (z.B. Hörgeräte, Rollstühle))
         *
         * @return float
         */
        public function get_healthaid_general_refund() {
            return $this->data['tariff']['product_dependent_features']['healthaid_general_refund'];
        }

        /**
         * Open health aid catalog (offener Hilfsmittelkatalog)
         * Possible values: yes, no.
         *
         * @return string
         */
        public function get_healthaid_open_health_aid_catalog() {
            return $this->data['tariff']['product_dependent_features']['healthaid_open_health_aid_catalog'];
        }

        /**
         * The limit of the visual aid benefits (Sehhilfen (Brille, Kontaktlinsen))
         *
         * @return integer
         */
        public function get_healthaid_visual_aid_limit() {
            return $this->data['tariff']['product_dependent_features']['healthaid_visual_aid_limit'];
        }

        /**
         * The period of the visual aid benefits (Sehhilfen (Brille, Kontaktlinsen))
         *
         * @return integer
         */
        public function get_healthaid_visual_aid_period() {
            return $this->data['tariff']['product_dependent_features']['healthaid_visual_aid_period'];
        }

        /**
         * The limit of the lasik (operative Sehschärfenkorrektur (Lasik))
         *
         * @return string
         */
        public function get_healthaid_lasik_limit() {
            return $this->data['tariff']['product_dependent_features']['healthaid_lasik_limit'];
        }

        /**
         * The period of the lasik (operative Sehschärfenkorrektur (Lasik))
         *
         * @return string
         */
        public function get_healthaid_lasik_period() {
            return $this->data['tariff']['product_dependent_features']['healthaid_lasik_period'];
        }

        /**
         * The timepoint of the lasik benefit.
         *
         * @return integer
         */
        public function get_healthaid_lasik_timepoint() {
            return $this->data['tariff']['product_dependent_features']['healthaid_lasik_timepoint'];
        }

        /**
         * Whether the timepoint of the lasik benefit is proved or not.
         *
         * @return string
         */
        public function get_healthaid_lasik_proved() {
            return $this->data['tariff']['product_dependent_features']['healthaid_lasik_proved'];
        }

        /**
         * The percentage of the general reimbursement of remedy (Generelle Erstattung Heilmittel)
         *
         * @return float
         */
        public function get_remedy_general_reimbursement() {
            return $this->data['tariff']['product_dependent_features']['remedy_general_reimbursement'];
        }

        /**
         * Manual therapy (Manuelle Therapie (Massagen, Krankengymnastik etc.))
         * Possible values: yes, no.
         *
         * @return string
         */
        public function get_remedy_manual_therapy() {
            return $this->data['tariff']['product_dependent_features']['remedy_manual_therapy'];
        }

        /**
         * The percentage of the ergotherapy (Ergotherapiy)
         *
         * @return float
         */
        public function get_remedy_ergotherapy() {
            return $this->data['tariff']['product_dependent_features']['remedy_ergotherapy'];
        }

        /**
         * The percentage of the speech therapy (Logopädie).
         *
         * @return float
         */
        public function get_remedy_speech_therapy() {
            return $this->data['tariff']['product_dependent_features']['remedy_speech_therapy'];
        }

        /**
         * Outpatient prenatal care (Ambulante Geburtsvorbereitung oder Rückbildungsgymnastik)
         * Possible values; yes, no.
         *
         * @return string
         */
        public function get_remedy_prenatal_care() {
            return $this->data['tariff']['product_dependent_features']['remedy_prenatal_care'];
        }

        /**
         * The percentage of the reimbursement of non-medical practitioner benefits (Erstattung Heilpraktikerleistungen).
         *
         * @return float
         */
        public function get_amed_non_med_practitioner_reimbursement() {
            return $this->data['tariff']['product_dependent_features']['amed_non_med_practitioner_reimbursement'];
        }

        /**
         * The limit of the reimbursement of non-medical practitioner benefits.
         *
         * @return integer
         */
        public function get_amed_non_med_practitioner_reimbursement_limit() {
            return $this->data['tariff']['product_dependent_features']['amed_non_med_practitioner_reimbursement_limit'];
        }

        /**
         * The percentage of the scope of alternative methods in treatment (Umfang alternative Behandlungsmethoden)
         *
         * @return float
         */
        public function get_amed_treatment_scope() {
            return $this->data['tariff']['product_dependent_features']['amed_treatment_scope'];
        }

        /**
         * The limit of the scope of alternative methods in treatment (Umfang alternative Behandlungsmethoden)
         *
         * @return integer
         */
        public function get_amed_treatment_scope_limit() {
            return $this->data['tariff']['product_dependent_features']['amed_treatment_scope_limit'];
        }

        /**
         * The percentage of the reimbursement of psychotherapy
         *
         * @return float
         */
        public function get_psychotherapy_reimbursement() {
            return $this->data['tariff']['product_dependent_features']['psychotherapy_reimbursement'];
        }

        /**
         * The amount of session for the reimbursement of psychotherapy
         *
         * @return integer
         */
        public function get_psychotherapy_reimbursement_session() {
            return $this->data['tariff']['product_dependent_features']['psychotherapy_reimbursement_session'];
        }

        /**
         * Psychotherapy without approval.
         * Possible values; yes, no;
         *
         * @return string
         */
        public function get_psychotherapy_without_approval() {
            return $this->data['tariff']['product_dependent_features']['psychotherapy_without_approval'];
        }

        /**
         * The time point of the psychotherapy without approval.
         *
         * @return integer
         */
        public function get_psychotherapy_without_approval_timepoint() {
            return $this->data['tariff']['product_dependent_features']['psychotherapy_without_approval_timepoint'];
        }

        /**
         * Delegation to an psychotherapist possible.
         * Possible values: yes, no.
         *
         * @return string
         */
        public function get_psychotherapy_delegation() {
            return $this->data['tariff']['product_dependent_features']['psychotherapy_delegation'];
        }

        /**
         * The type of attending doctor.
         * Only fixed values possible.
         *
         * @return string
         */
        public function get_treatment_attending_doctor() {
            return $this->data['tariff']['product_dependent_features']['treatment_attending_doctor'];
        }

        /**
         * Benefits above maximum rate.
         * Possible value; yes, no.
         *
         * @return string
         */
        public function get_treatment_above_maximum_rate() {
            return $this->data['tariff']['product_dependent_features']['treatment_above_maximum_rate'];
        }

        /**
         * Mixed clinic without acceptance letter.
         * Possible values: yes, no.
         *
         * @return string
         */
        public function get_treatment_clinic_without_acceptance_letter() {
            return $this->data['tariff']['product_dependent_features']['treatment_clinic_without_acceptance_letter'];
        }

        /**
         * Psychotherapy (offered by state) without approval.
         * Possible value; yes, no.
         *
         * @return string
         */
        public function get_treatment_psychotherapy_without_approval() {
            return $this->data['tariff']['product_dependent_features']['treatment_psychotherapy_without_approval'];
        }

        /**
         * The inpatient accommodation privacy type.
         * Possible values (constant):
         * - ::HOSPITALIZATION_ACCOMMODATION_SHAREDROOM
         * - ::HOSPITALIZATION_ACCOMMODATION_TWINROOM
         * - ::HOSPITALIZATION_ACCOMMODATION_SINGLEROOM
         *
         * @return string
         */
        public function get_hospitalization_accommodation() {
            return $this->data['tariff']['product_dependent_features']['hospitalization_accommodation'];
        }

        /**
         * The maximum age for impatient accommodation for escort of children.
         * Possible values: yes, no.
         *
         * @return integer
         */
        public function get_hospitalization_children_escort_accommodation_age() {
            return $this->data['tariff']['product_dependent_features']['hospitalization_children_escort_accommodation_age'];
        }

        /**
         * The duration of impatient accommodation for escort of children.
         * Value in days.
         *
         * @return integer
         */
        public function get_hospitalization_children_escort_accommodation_duration() {
            return $this->data['tariff']['product_dependent_features']['hospitalization_children_escort_accommodation_duration'];
        }

        /**
         * The percentage of the dental treatment reimbursement.
         *
         * @return float
         */
        public function get_dental_treatment() {
            return $this->data['tariff']['product_dependent_features']['dental_treatment'];
        }

        /**
         * The limit of the dental treatment reimbursement in the first year.
         *
         * @return integer
         */
        public function get_dental_treatment_limit_1y() {
            return $this->data['tariff']['product_dependent_features']['dental_treatment_limit_1y'];
        }

        /**
         * Benefits over maximum fees.
         * Possible values: yes, no.
         *
         * @return string
         */
        public function get_dental_over_maximum_fee() {
            return $this->data['tariff']['product_dependent_features']['dental_over_maximum_fee'];
        }

        /**
         * The percentage of the dentures reimbursement.
         *
         * @return float
         */
        public function get_dental_dentures() {
            return $this->data['tariff']['product_dependent_features']['dental_dentures'];
        }

        /**
         * The limit of the reimbursement of dentures in the first year.
         *
         * @return integer
         */
        public function get_dental_dentures_limit_1y() {
            return $this->data['tariff']['product_dependent_features']['dental_dentures_limit_1y'];
        }

        /**
         * The percentage of the inlays reimbursement.
         *
         * @return float
         */
        public function get_dental_inlay() {
            return $this->data['tariff']['product_dependent_features']['dental_inlay'];
        }

        /**
         * The limit of the reimbursement of inlays in the first year.
         *
         * @return integer
         */
        public function get_dental_inlay_limit_1y() {
            return $this->data['tariff']['product_dependent_features']['dental_inlay_limit_1y'];
        }

        /**
         * The percentage of the implants reimbursement.
         *
         * @return float
         */
        public function get_dental_implant() {
            return $this->data['tariff']['product_dependent_features']['dental_implant'];
        }

        /**
         * The amount limit of the reimbursement of implants.
         *
         * @return integer
         */
        public function get_dental_implant_limit_amount() {
            return $this->data['tariff']['product_dependent_features']['dental_implant_limit_amount'];
        }

        /**
         * The financial limit of the reimbursement of implants in the first year.
         *
         * @return integer
         */
        public function get_dental_implant_limit_1y() {
            return $this->data['tariff']['product_dependent_features']['dental_implant_limit_1y'];
        }

        /**
         * Benefits regardless of prophylaxis.
         * Possible values; yes, no.
         *
         * @return string
         */
        public function get_dental_regardless_prophylaxis_benefits() {
            return $this->data['tariff']['product_dependent_features']['dental_regardless_prophylaxis_benefits'];
        }

        /**
         * Constant reimbursement percentage
         * Possible values; yes, no.
         *
         * @return string
         */
        public function get_dental_constant_reimbursement_percentage() {
            return $this->data['tariff']['product_dependent_features']['dental_constant_reimbursement_percentage'];
        }

        /**
         * The limit of the dental treatment reimbursement in the first year.
         *
         * @return integer
         */
        public function get_dental_budgetary_limit_1y() {
            return $this->data['tariff']['product_dependent_features']['dental_budgetary_limit_1y'];
        }

        /**
         * The limit of the dental treatment reimbursement in the second year.
         *
         * @return integer
         */
        public function get_dental_budgetary_limit_2y() {
            return $this->data['tariff']['product_dependent_features']['dental_budgetary_limit_2y'];
        }

        /**
         * The limit of the dental treatment reimbursement in the third year.
         *
         * @return integer
         */
        public function get_dental_budgetary_limit_3y() {
            return $this->data['tariff']['product_dependent_features']['dental_budgetary_limit_3y'];
        }

        /**
         * The limit of the dental treatment reimbursement in the fourth year.
         *
         * @return integer
         */
        public function get_dental_budgetary_limit_4y() {
            return $this->data['tariff']['product_dependent_features']['dental_budgetary_limit_4y'];
        }

        /**
         * The limit of the dental treatment reimbursement in the fifth year.
         *
         * @return integer
         */
        public function get_dental_budgetary_limit_5y() {
            return $this->data['tariff']['product_dependent_features']['dental_budgetary_limit_5y'];
        }

        /**
         * The limit of the dental treatment reimbursement in the sixth year.
         *
         * @return integer
         */
        public function get_dental_budgetary_limit_6y() {
            return $this->data['tariff']['product_dependent_features']['dental_budgetary_limit_6y'];
        }

        /**
         * Renounce of medical expenses.
         * Zeitraum?
         *
         * @return string
         */
        public function get_dental_medical_expenses_renounce() {
            return $this->data['tariff']['product_dependent_features']['dental_medical_expenses_renounce'];
        }

        /**
         * The maximum refund of dental expenses (permanent)
         * Possible values; yes, no.
         *
         * @return string
         */
        public function get_dental_no_maximum_refund() {
            return $this->data['tariff']['product_dependent_features']['dental_no_maximum_refund'];
        }

        /**
         * The percentage of the reimbursement of orthodontia benefits.
         *
         * @return float
         */
        public function get_dental_orthodontia() {
            return $this->data['tariff']['product_dependent_features']['dental_orthodontia'];
        }

        /**
         * The age limit of the reimbursement of orthodontia benefits.
         *
         * @return integer
         */
        public function get_dental_orthodontia_age_limit() {
            return $this->data['tariff']['product_dependent_features']['dental_orthodontia_age_limit'];
        }

        /**
         * Outpatient cures.
         * Possible values; yes, no.
         *
         * @return string
         */
        public function get_cure_outpatient() {
            return $this->data['tariff']['product_dependent_features']['cure_outpatient'];
        }

        /**
         * The limit of the reimbursement of outpatient cures.
         *
         * @return integer
         */
        public function get_cure_outpatient_limit() {
            return $this->data['tariff']['product_dependent_features']['cure_outpatient_limit'];
        }

        /**
         * The timepoint of the reimbursement of the utpatient cures.
         *
         * @return integer
         */
        public function get_cure_outpatient_timepoint() {
            return $this->data['tariff']['product_dependent_features']['cure_outpatient_timepoint'];
        }

        /**
         * Inpatient cures
         *
         * @return string
         */
        public function get_cure_inpatient() {
            return $this->data['tariff']['product_dependent_features']['cure_inpatient'];
        }

        /**
         * The limit of the reimbursement of inpatient cures.
         *
         * @return string
         */
        public function get_cure_inpatient_limit() {
            return $this->data['tariff']['product_dependent_features']['cure_inpatient_limit'];
        }

        /**
         * The time point fo the reimbursement of inpatient cures.
         *
         * @return string
         */
        public function get_cure_inpatient_timepoint() {
            return $this->data['tariff']['product_dependent_features']['cure_inpatient_timepoint'];
        }

        /**
         * Rehab
         *
         * @return string
         */
        public function get_cure_rehab() {
            return $this->data['tariff']['product_dependent_features']['cure_rehab'];
        }

        /**
         * Follow-up treatment
         *
         * @return string
         */
        public function get_cure_followup_treatment() {
            return $this->data['tariff']['product_dependent_features']['cure_followup_treatment'];
        }

        /**
         * Renounce of health resort
         *
         * @return string
         */
        public function get_cure_health_resort_renounce() {
            return $this->data['tariff']['product_dependent_features']['cure_health_resort_renounce'];
        }

        /**
         * The comment fo cost sharing.
         *
         * @return string
         */
        public function get_provision_costsharing_comment() {
            return $this->data['tariff']['product_dependent_features']['provision_costsharing_comment'];
        }

        /**
         * The limit of sharing amount.
         *
         * @return integer
         */
        public function get_provision_costsharing_limit() {
            return $this->data['tariff']['product_dependent_features']['provision_costsharing_limit'];
        }

        /**
         * The percentage of the cost sharing.
         *
         * @return float
         */
        public function get_provision_costsharing_percentage() {
            return $this->data['tariff']['product_dependent_features']['provision_costsharing_percentage'];
        }

        /**
         * The sector of the cost sharing.
         *
         * @return string
         */
        public function get_provision_costsharing_sector() {
            return $this->data['tariff']['product_dependent_features']['provision_costsharing_sector'];
        }

        /**
         * Cost sharing.
         *
         * @return string
         */
        public function get_provision_costsharing() {
            return $this->data['tariff']['product_dependent_features']['provision_costsharing'];
        }

        /**
         * The additional cost sharing.
         *
         * @return string
         */
        public function get_provision_additional_costsharing() {
            return $this->data['tariff']['product_dependent_features']['provision_additional_costsharing'];
        }

        /**
         * The asection of the additional cost sharing.
         *
         * @return string
         */
        public function get_provision_additional_costsharing_section() {
            return $this->data['tariff']['product_dependent_features']['provision_additional_costsharing_section'];
        }

        /**
         * The amount of the additional cost sharing.
         *
         * @return float
         */
        public function get_provision_additional_costsharing_amount() {
            return $this->data['tariff']['product_dependent_features']['provision_additional_costsharing_amount'];
        }

        /**
         * The children insurance by oneself.
         *
         * @return string
         */
        public function get_provision_children_insurance_oneself() {
            return $this->data['tariff']['product_dependent_features']['provision_children_insurance_oneself'];
        }

        /**
         * The the minimum age for an insurance of children by oneself.
         *
         * @return integer
         */
        public function get_provision_children_insurance_oneself_age() {
            return $this->data['tariff']['product_dependent_features']['provision_children_insurance_oneself_age'];
        }

        /**
         * Guaranteed reimbursement of contributions
         *
         * @return string
         */
        public function get_provision_contribution_reimbursement() {
            return $this->data['tariff']['product_dependent_features']['provision_contribution_reimbursement'];
        }

        /**
         * The limit of the guaranteed reimbursement of contributions.
         *
         * @return float
         */
        public function get_provision_contribution_reimbursement_limit() {
            return $this->data['tariff']['product_dependent_features']['provision_contribution_reimbursement_limit'];
        }

        /**
         * The comment of the amount of the contribution reimbursement.
         * This is an free-text field!
         *
         * @return string
         */
        public function get_provision_contribution_reimbursement_amount() {
            return $this->data['tariff']['product_dependent_features']['provision_contribution_reimbursement_amount'];
        }

        /**
         * The comment of the amount of the contribution reimbursement.
         * This is an free-text field!
         *
         * @return string
         */
        public function get_provision_contribution_reimbursement_amount_limit() {
            return $this->data['tariff']['product_dependent_features']['provision_contribution_reimbursement_amount_limit'];
        }

        /**
         * The limit of the amount of the contribution reimbursement.
         * This is an free-text field!
         *
         * @return string
         */
        public function get_provision_contribution_reimbursement_amount_1y() {
            return $this->data['tariff']['product_dependent_features']['provision_contribution_reimbursement_amount_1y'];
        }

        /**
         * The comment of the contribution reimbursement amount.
         *
         * @return string
         */
        public function get_provision_contribution_reimbursement_amount_comment() {
            return $this->data['tariff']['product_dependent_features']['provision_contribution_reimbursement_amount_comment'];
        }

        /**
         * Healthy life-style bonus
         *
         * @return string
         */
        public function get_provision_healthy_lifestyle_bonus() {
            return $this->data['tariff']['product_dependent_features']['provision_healthy_lifestyle_bonus'];
        }

        /**
         * The limit of the healthy life-style bonus reimbursement.
         *
         * @return string
         */
        public function get_provision_healthy_lifestyle_bonus_limit() {
            return $this->data['tariff']['product_dependent_features']['provision_healthy_lifestyle_bonus_limit'];
        }

        /**
         * Higher insurance option possible
         *
         * @return string
         */
        public function get_provision_higher_insurance_option() {
            return $this->data['tariff']['product_dependent_features']['provision_higher_insurance_option'];
        }

        /**
         * A description of additional tariff specials.
         *
         * @return string
         */
        public function get_provision_additional_tariff_specials() {
            return $this->data['tariff']['product_dependent_features']['provision_additional_tariff_specials'];
        }

        /**
         * Does the insurance covers internationally
         *
         * @return string
         */
        public function get_provision_international_insurance_cover() {
            return $this->data['tariff']['product_dependent_features']['provision_international_insurance_cover'];
        }

        /**
         * The limit of reimbursement of internationally insurance cover in the first year.
         *
         * @return integer
         */
        public function get_provision_international_insurance_cover_limit_1y() {
            return $this->data['tariff']['product_dependent_features']['provision_international_insurance_cover_limit_1y'];
        }

        /**
         * The limit of reimbursement of internationally insurance cover in the second year.
         *
         * @return integer
         */
        public function get_provision_international_insurance_cover_limit_2y() {
            return $this->data['tariff']['product_dependent_features']['provision_international_insurance_cover_limit_2y'];
        }

        /**
         * International repatriation
         *
         * @return string
         */
        public function get_provision_international_repatriation() {
            return $this->data['tariff']['product_dependent_features']['provision_international_repatriation'];
        }

        /**
         * The health care screening check.
         *
         * @return string
         */
        public function get_provision_healthcare_screening_check() {
            return $this->data['tariff']['product_dependent_features']['provision_healthcare_screening_check'];
        }

        /**
         * The health care screening check
         *
         * @return string
         */
        public function get_provision_children_costsharing_same() {
            return $this->data['tariff']['product_dependent_features']['provision_children_costsharing_same'];
        }

        /**
         * The amount the the cost sharing for children.
         *
         * @return string
         */
        public function get_provision_children_costsharing_amount() {
            return $this->data['tariff']['product_dependent_features']['provision_children_costsharing_amount'];
        }

        /**
         * The comment message of teh cost sharing for children.
         *
         * @return string
         */
        public function get_provision_children_costsharing_comment() {
            return $this->data['tariff']['product_dependent_features']['provision_children_costsharing_comment'];
        }

        /**
         * The rating of the certainty of the organization.
         *
         * @return integer
         */
        public function get_provider_evaluation_organization_certainty() {
            return $this->data['provider']['evaluation_organization_certainty'];
        }

        /**
         * The rating of the stability of the contributions.
         *
         * @return integer
         */
        public function get_provider_evaluation_contribution_stability() {
            return $this->data['provider']['evaluation_contribution_stability'];
        }

        /**
         * The rating of the customer focus.
         *
         * @return integer
         */
        public function get_provider_evaluation_customer_focus() {
            return $this->data['provider']['evaluation_customer_focus'];
        }

        /**
         * Increasing with an additional health checkup
         *
         * @return string
         */
        public function get_provider_pdhospital_increase_without_hcheck() {
            return $this->data['provider']['pdhospital_increase_without_hcheck'];
        }

        /**
         * Increasing with an additional health checkup
         *
         * @return string
         */
        public function get_provider_pdhospital_increase_without_hcheck_timepoint() {
            return $this->data['provider']['pdhospital_increase_without_hcheck_timepoint'];
        }

        /**
         * Dynamic increase possible
         *
         * @return string
         */
        public function get_provider_pdhospital_dynamic_incrase_timepoint() {
            return $this->data['provider']['pdhospital_dynamic_incrase_timepoint'];
        }

        /**
         * The renounce of an waiting period after an relief disease
         *
         * @return string
         */
        public function get_provider_pdhospital_relief_disease_renounce() {
            return $this->data['provider']['pdhospital_relief_disease_renounce'];
        }

        /**
         * The renounce of an waiting period after an relief disease
         *
         * @return string
         */
        public function get_provider_pdhospital_relief_disease_renounce_timepoint() {
            return $this->data['provider']['pdhospital_relief_disease_renounce_timepoint'];
        }

        /**
         * The renounce of alcohol
         *
         * @return string
         */
        public function get_provider_pdhospital_alcohol_renounce() {
            return $this->data['provider']['pdhospital_alcohol_renounce'];
        }

        /**
         * Cure with benefits
         *
         * @return string
         */
        public function get_provider_pdhospital_cure_benefits() {
            return $this->data['provider']['pdhospital_cure_benefits'];
        }

        /**
         * Cancellation restriction
         *
         * @return string
         */
        public function get_provider_pdhospital_cancelation_restriction() {
            return $this->data['provider']['pdhospital_cancelation_restriction'];
        }

        /**
         * Occupational disability benefits
         *
         * @return string
         */
        public function get_provider_pdhospital_occupational_disability() {
            return $this->data['provider']['pdhospital_occupational_disability'];
        }

        /**
         * The duration of occupational disability benefits until payout stop.
         *
         * @return integer
         */
        public function get_provider_pdhospital_occupational_disability_duration() {
            return $this->data['provider']['pdhospital_occupational_disability_duration'];
        }

        /**
         * Medication above maximum rate
         *
         * @return string|NULL
         */
        public function get_med_above_maximum_rate_comment() {
            return $this->data['tariff']['product_dependent_features']['med_above_maximum_rate_comment'];
        }

        /**
         * Direct medical consultation
         *
         * @return string|NULL
         */
        public function get_med_direct_medical_consultation_comment() {
            return $this->data['tariff']['product_dependent_features']['med_direct_medical_consultation_comment'];
        }

        /**
         * Is a screening check required?
         *
         * @return string|NULL
         */
        public function get_med_healthcare_screening_check_comment() {
            return $this->data['tariff']['product_dependent_features']['med_healthcare_screening_check_comment'];
        }

        /**
         * Medication above statutory maximum rate
         *
         * @return string|NULL
         */
        public function get_med_above_statutory_maximum_rate_comment() {
            return $this->data['tariff']['product_dependent_features']['med_above_statutory_maximum_rate_comment'];
        }

        /**
         * Recommend inoculation reimbursement
         *
         * @return string|NULL
         */
        public function get_med_recommend_inoculation_reimbursement_comment() {
            return $this->data['tariff']['product_dependent_features']['med_recommend_inoculation_reimbursement_comment'];
        }

        /**
         * Foreign travel inoculation
         *
         * @return string|NULL
         */
        public function get_med_foreign_travel_inoculation_comment() {
            return $this->data['tariff']['product_dependent_features']['med_foreign_travel_inoculation_comment'];
        }

        /**
         * Fertility training
         *
         * @return string|NULL
         */
        public function get_med_fertility_treatment_comment() {
            return $this->data['tariff']['product_dependent_features']['med_fertility_treatment_comment'];
        }

        /**
         * Inpatient transport cost
         *
         * @return string|NULL
         */
        public function get_med_inpatient_transport_cost_comment() {
            return $this->data['tariff']['product_dependent_features']['med_inpatient_transport_cost_comment'];
        }

        /**
         * Drug reinbursement
         *
         * @return string|NULL
         */
        public function get_drug_reimbursement_comment() {
            return $this->data['tariff']['product_dependent_features']['drug_reimbursement_comment'];
        }

        /**
         * Drug direct consulting reimbursement
         *
         * @return string|NULL
         */
        public function get_drug_direct_consulting_reimbursement_comment() {
            return $this->data['tariff']['product_dependent_features']['drug_direct_consulting_reimbursement_comment'];
        }

        /**
         * Healthaid general refund
         *
         * @return string|NULL
         */
        public function get_healthaid_general_refund_comment() {
            return $this->data['tariff']['product_dependent_features']['healthaid_general_refund_comment'];
        }

        /**
         * Healthaid open healthaid catalogue
         *
         * @return string|NULL
         */
        public function get_healthaid_open_health_aid_catalog_comment() {
            return $this->data['tariff']['product_dependent_features']['healthaid_open_health_aid_catalog_comment'];
        }

        /**
         * Healthaid visual aid
         *
         * @return string|NULL
         */
        public function get_healthaid_visual_aid_comment() {
            return $this->data['tariff']['product_dependent_features']['healthaid_visual_aid_comment'];
        }

        /**
         * Healthaid Lasik
         *
         * @return string|NULL
         */
        public function get_healthaid_lasik_comment() {
            return $this->data['tariff']['product_dependent_features']['healthaid_lasik_comment'];
        }

        /**
         * Remedy general reimbursement
         *
         * @return string|NULL
         */
        public function get_remedy_general_reimbursement_comment() {
            return $this->data['tariff']['product_dependent_features']['remedy_general_reimbursement_comment'];
        }

        /**
         * Remedy manual therapy
         *
         * @return string|NULL
         */
        public function get_remedy_manual_therapy_comment() {
            return $this->data['tariff']['product_dependent_features']['remedy_manual_therapy_comment'];
        }

        /**
         * Remedy ergotherapy
         *
         * @return string|NULL
         */
        public function get_remedy_ergotherapy_comment() {
            return $this->data['tariff']['product_dependent_features']['remedy_ergotherapy_comment'];
        }

        /**
         * Remedy speech therapy
         *
         * @return string|NULL
         */
        public function get_remedy_speech_therapy_comment() {
            return $this->data['tariff']['product_dependent_features']['remedy_speech_therapy_comment'];
        }

        /**
         * Remedy prenatal cara
         *
         * @return string|NULL
         */
        public function get_remedy_prenatal_care_comment() {
            return $this->data['tariff']['product_dependent_features']['remedy_prenatal_care_comment'];
        }

        /**
         * Non medical practitioner reimbursement
         *
         * @return string|NULL
         */
        public function get_amed_non_med_practitioner_reimbursement_comment() {
            return $this->data['tariff']['product_dependent_features']['amed_non_med_practitioner_reimbursement_comment'];
        }

        /**
         * Treatment scope
         *
         * @return string|NULL
         */
        public function get_amed_treatment_scope_comment() {
            return $this->data['tariff']['product_dependent_features']['amed_treatment_scope_comment'];
        }

        /**
         * Psychotherapy reimbursement
         *
         * @return string|NULL
         */
        public function get_psychotherapy_reimbursement_comment() {
            return $this->data['tariff']['product_dependent_features']['psychotherapy_reimbursement_comment'];
        }

        /**
         * Psychotherapy without approval
         *
         * @return string|NULL
         */
        public function get_psychotherapy_without_approval_comment() {
            return $this->data['tariff']['product_dependent_features']['psychotherapy_without_approval_comment'];
        }

        /**
         * Psychotherapy delegation
         *
         * @return string|NULL
         */
        public function get_psychotherapy_delegation_comment() {
            return $this->data['tariff']['product_dependent_features']['psychotherapy_delegation_comment'];
        }

        /**
         * Treatment attending doctor
         *
         * @return string|NULL
         */
        public function get_treatment_attending_doctor_comment() {
            return $this->data['tariff']['product_dependent_features']['treatment_attending_doctor_comment'];
        }

        /**
         * Treatment above maximum rate
         *
         * @return string|NULL
         */
        public function get_treatment_above_maximum_rate_comment() {
            return $this->data['tariff']['product_dependent_features']['treatment_above_maximum_rate_comment'];
        }

        /**
         * Treatment psychotherapy without approval
         *
         * @return string|NULL
         */
        public function get_treatment_psychotherapy_without_approval_comment() {
            return $this->data['tariff']['product_dependent_features']['treatment_psychotherapy_without_approval_comment'];
        }

        /**
         * Treatment clinic without acceptance letter
         *
         * @return string|NULL
         */
        public function get_treatment_clinic_without_acceptance_letter_comment() {
            return $this->data['tariff']['product_dependent_features']['treatment_clinic_without_acceptance_letter_comment'];
        }

        /**
         * Hospitalization accommodation
         *
         * @return string|NULL
         */
        public function get_hospitalization_accommodation_comment() {
            return $this->data['tariff']['product_dependent_features']['hospitalization_accommodation_comment'];
        }

        /**
         * Hospitalization children escort accomodation
         *
         * @return string|NULL
         */
        public function get_hospitalization_children_escort_accommodation_comment() {
            return $this->data['tariff']['product_dependent_features']['hospitalization_children_escort_accommodation_comment'];
        }

        /**
         * Dental treatment
         *
         * @return string|NULL
         */
        public function get_dental_treatment_comment() {
            return $this->data['tariff']['product_dependent_features']['dental_treatment_comment'];
        }

        /**
         * Dental over maximum fee
         *
         * @return string|NULL
         */
        public function get_dental_over_maximum_fee_comment() {
            return $this->data['tariff']['product_dependent_features']['dental_over_maximum_fee_comment'];
        }

        /**
         * Dentures
         *
         * @return string|NULL
         */
        public function get_dental_dentures_comment() {
            return $this->data['tariff']['product_dependent_features']['dental_dentures_comment'];
        }

        /**
         * Dental inlays
         *
         * @return string|NULL
         */
        public function get_dental_inlay_comment() {
            return $this->data['tariff']['product_dependent_features']['dental_inlay_comment'];
        }

        /**
         * Dental implants
         *
         * @return string|NULL
         */
        public function get_dental_implant_comment() {
            return $this->data['tariff']['product_dependent_features']['dental_implant_comment'];
        }

        /**
         * Dental regardless of prophylaxis benefits
         *
         * @return string|NULL
         */
        public function get_dental_regardless_prophylaxis_benefits_comment() {
            return $this->data['tariff']['product_dependent_features']['dental_regardless_prophylaxis_benefits_comment'];
        }

        /**
         * Dental constant reimbursement percentage
         *
         * @return string|NULL
         */
        public function get_dental_constant_reimbursement_percentage_comment() {
            return $this->data['tariff']['product_dependent_features']['dental_constant_reimbursement_percentage_comment'];
        }

        /**
         * Dental medical expenses renounce
         *
         * @return string|NULL
         */
        public function get_dental_medical_expenses_renounce_comment() {
            return $this->data['tariff']['product_dependent_features']['dental_medical_expenses_renounce_comment'];
        }

        /**
         * Dental no maximum refund
         *
         * @return string|NULL
         */
        public function get_dental_no_maximum_refund_comment() {
            return $this->data['tariff']['product_dependent_features']['dental_no_maximum_refund_comment'];
        }

        /**
         * Dental orthodontia
         *
         * @return string|NULL
         */
        public function get_dental_orthodontia_comment() {
            return $this->data['tariff']['product_dependent_features']['dental_orthodontia_comment'];
        }

        /**
         * Common level of the dental service for the given tariff in German language
         *
         * @throws \rs_logic_exception Invalid dental german value
         * @return string Dental german value
         */
        public function get_dental_german() {

            $dental_list = [
                'basic'   => 'Basis-Zahnleistung',
                'comfort' => 'Komfort-Zahnleistung',
                'premium' => 'Premium-Zahnleistung'
            ];

            $dental_german = $this->get_dental();

            if (array_key_exists($dental_german, $dental_list)) {
                return $dental_list[$dental_german];
            }

            throw new \rs_logic_exception(sprintf('Invalid dental german value, expected basic, comfort, premium. [dental_gearman: %s]', $dental_german));

        }

        /**
         * Cure outpatient
         *
         * @return string|NULL
         */
        public function get_cure_outpatient_comment() {
            return $this->data['tariff']['product_dependent_features']['cure_outpatient_comment'];
        }

        /**
         * Cure inpatient
         *
         * @return string|NULL
         */
        public function get_cure_inpatient_comment() {
            return $this->data['tariff']['product_dependent_features']['cure_inpatient_comment'];
        }

        /**
         * Cure followup treatment
         *
         * @return string|NULL
         */
        public function get_cure_followup_treatment_comment() {
            return $this->data['tariff']['product_dependent_features']['cure_followup_treatment_comment'];
        }

        /**
         * Cure health resort
         *
         * @return string|NULL
         */
        public function get_cure_health_resort_renounce_comment() {
            return $this->data['tariff']['product_dependent_features']['cure_health_resort_renounce_comment'];
        }

        /**
         * Provision Healthcare screening check
         *
         * @return string|NULL
         */
        public function get_provision_healthcare_screening_check_comment() {
            return $this->data['tariff']['product_dependent_features']['provision_healthcare_screening_check_comment'];
        }

        /**
         * Provision contribution reimbursement
         *
         * @return string|NULL
         */
        public function get_provision_contribution_reimbursement_comment() {
            return $this->data['tariff']['product_dependent_features']['provision_contribution_reimbursement_comment'];
        }

        /**
         * Provision healthy lifestyle bonus
         *
         * @return string|NULL
         */
        public function get_provision_healthy_lifestyle_bonus_comment() {
            return $this->data['tariff']['product_dependent_features']['provision_healthy_lifestyle_bonus_comment'];
        }

        /**
         * Provision higher insurance option
         *
         * @return string|NULL
         */
        public function get_provision_higher_insurance_option_comment() {
            return $this->data['tariff']['product_dependent_features']['provision_higher_insurance_option_comment'];
        }

        /**
         * Additional tariff specials
         *
         * @return string|NULL
         */
        public function get_provision_additional_tariff_specials_comment() {
            return $this->data['tariff']['product_dependent_features']['provision_additional_tariff_specials_comment'];
        }

        /**
         * International insurance cover
         *
         * @return string|NULL
         */
        public function get_provision_international_insurance_cover_comment() {
            return $this->data['tariff']['product_dependent_features']['provision_international_insurance_cover_comment'];
        }

        /**
         * International repatriation
         *
         * @return string|NULL
         */
        public function get_provision_international_repatriation_comment() {
            return $this->data['tariff']['product_dependent_features']['provision_international_repatriation_comment'];
        }

        /**
         * Evaluation organization certainty
         *
         * @return string|NULL
         */
        public function get_evaluation_organization_certainty_comment() {
            return $this->data['provider']['evaluation_organization_certainty_comment'];
        }

        /**
         * Contribution stability
         *
         * @return string|NULL
         */
        public function get_evaluation_contribution_stability_comment() {
            return $this->data['provider']['evaluation_contribution_stability_comment'];
        }

        /**
         * Customer focus
         *
         * @return string|NULL
         */
        public function get_evaluation_customer_focus_comment() {
            return $this->data['provider']['evaluation_customer_focus_comment'];
        }

        /**
         * Hospital increase without health check
         *
         * @return string|NULL
         */
        public function get_pdhospital_increase_without_hcheck_comment() {
            return $this->data['provider']['pdhospital_increase_without_hcheck_comment'];
        }

        /**
         * Hospital releaf disease waiting
         *
         * @return string|NULL
         */
        public function get_pdhospital_relief_disease_renounce_comment() {
            return $this->data['provider']['pdhospital_relief_disease_renounce_comment'];
        }

        /**
         * Alcohol renounce
         *
         * @return string|NULL
         */
        public function get_pdhospital_alcohol_renounce_comment() {
            return $this->data['provider']['pdhospital_alcohol_renounce_comment'];
        }

        /**
         * Cure benefits
         *
         * @return string|NULL
         */
        public function get_pdhospital_cure_benefits_comment() {
            return $this->data['provider']['pdhospital_cure_benefits_comment'];
        }

        /**
         * Cancelation restriction
         *
         * @return string|NULL
         */
        public function get_pdhospital_cancelation_restriction_comment() {
            return $this->data['provider']['pdhospital_cancelation_restriction_comment'];
        }

        /**
         * Occupational disability
         *
         * @return string|NULL
         */
        public function get_pdhospital_occupational_disability_comment() {
            return $this->data['provider']['pdhospital_occupational_disability_comment'];
        }

        /**
         * Termination reference point
         *
         * @deprecated PKV-Altlast (PVPKV-303)
         * @return string|NULL
         */
        public function get_termination_reference_point_comment() {
            return $this->data['tariff']['product_dependent_features']['termination_reference_point_comment'];
        }

        /**
         * Provision children insurance
         *
         * @return string|NULL
         */
        public function get_provision_children_insurance_oneself_comment() {
            return $this->data['tariff']['product_dependent_features']['provision_children_insurance_oneself_comment'];
        }

        /**
         * Additional costsharing
         *
         * @return string|NULL
         */
        public function get_provision_additional_costsharing_comment() {
            return $this->data['tariff']['product_dependent_features']['provision_additional_costsharing_comment'];
        }

        /**
         * Rehab
         *
         * @return string|NULL
         */
        public function get_cure_rehab_comment() {
            return $this->data['tariff']['product_dependent_features']['cure_rehab_comment'];
        }

        /**
         * Dental budgetary limit
         *
         * @return string|NULL
         */
        public function get_dental_budgetary_limit_4_6y_comment() {
            return $this->data['tariff']['product_dependent_features']['dental_budgetary_limit_4_6y_comment'];
        }

        /**
         * Dental budgetary limit
         *
         * @return string|NULL
         */
        public function get_dental_budgetary_limit_1_3y_comment() {
            return $this->data['tariff']['product_dependent_features']['dental_budgetary_limit_1_3y_comment'];
        }

        /**
         * Whether the tariff is available in the association (Bund) or not.
         *
         * @return string
         */
        public function get_scope_association() {
            return $this->data['tariff']['product_dependent_features']['scope_association'];
        }

        /**
         * Whether the tariff is available in the state Baden-Württemberg or not.
         *
         * @return string
         */
        public function get_scope_bw() {
            return $this->data['tariff']['product_dependent_features']['scope_bw'];
        }

        /**
         * Whether the tariff is available in the state Bavaria or not.
         *
         * @return string
         */
        public function get_scope_by() {
            return $this->data['tariff']['product_dependent_features']['scope_by'];
        }

        /**
         * Whether the tariff is available in the state Berlin or not.
         *
         * @return string
         */
        public function get_scope_be() {
            return $this->data['tariff']['product_dependent_features']['scope_be'];
        }

        /**
         * Whether the tariff is available in the state Brandenburg or not.
         *
         * @return string
         */
        public function get_scope_bb() {
            return $this->data['tariff']['product_dependent_features']['scope_bb'];
        }

        /**
         * Whether the tariff is available in the state Bremen or not.
         *
         * @return string
         */
        public function get_scope_hb() {
            return $this->data['tariff']['product_dependent_features']['scope_hb'];
        }

        /**
         * Whether the tariff is available in the state Hamburg or not.
         *
         * @return string
         */
        public function get_scope_hh() {
            return $this->data['tariff']['product_dependent_features']['scope_hh'];
        }

        /**
         * Whether the tariff is available in the state Hesse or not.
         *
         * @return string
         */
        public function get_scope_he() {
            return $this->data['tariff']['product_dependent_features']['scope_he'];
        }

        /**
         * Whether the tariff is available in the state Mecklenburg-Vorpommern or not.
         *
         * @return string
         */
        public function get_scope_mv() {
            return $this->data['tariff']['product_dependent_features']['scope_mv'];
        }

        /**
         * Whether the tariff is available in the state Lower Saxony or not.
         *
         * @return string
         */
        public function get_scope_ni() {
            return $this->data['tariff']['product_dependent_features']['scope_ni'];
        }

        /**
         * Whether the tariff is available in the state North Rhine-Westphalia or not.
         *
         * @return string
         */
        public function get_scope_nw() {
            return $this->data['tariff']['product_dependent_features']['scope_nw'];
        }

        /**
         * Whether the tariff is available in the state Rhineland-Palatinate or not.
         *
         * @return string
         */
        public function get_scope_rp() {
            return $this->data['tariff']['product_dependent_features']['scope_rp'];
        }

        /**
         * Whether the tariff is available in the state Saarland or not.
         *
         * @return string
         */
        public function get_scope_sl() {
            return $this->data['tariff']['product_dependent_features']['scope_sl'];
        }

        /**
         * Whether the tariff is available in the state Saxony or not.
         *
         * @return string
         */
        public function get_scope_sn() {
            return $this->data['tariff']['product_dependent_features']['scope_sn'];
        }

        /**
         * Whether the tariff is available in the state Saxony-Anhalt or not.
         *
         * @return string
         */
        public function get_scope_st() {
            return $this->data['tariff']['product_dependent_features']['scope_st'];
        }

        /**
         * Whether the tariff is available in the state Schleswig-Holstein or not.
         *
         * @return string
         */
        public function get_scope_sh() {
            return $this->data['tariff']['product_dependent_features']['scope_sh'];
        }

        /**
         * Get dental
         *
         * @return string
         */
        public function get_dental() {
            return $this->data['tariff']['product_dependent_features']['dental'];
        }

        /**
         * Whether the tariff is available in the state Thuringia or not.
         *
         * @return string
         */
        public function get_scope_th() {
            return $this->data['tariff']['product_dependent_features']['scope_th'];
        }

        /**
         * Returns all tariff feature bullets
         *
         * @return array
         */
        public function get_tariff_feature_bullets() {

            return [
                [
                    'tooltip' => $this->get_tariff_feature1_tooltip(),
                    'details' => $this->get_tariff_feature1_details(),
                    'color'   => $this->get_tariff_feature1_color()
                ],
                [
                    'tooltip' => $this->get_tariff_feature2_tooltip(),
                    'details' => $this->get_tariff_feature2_details(),
                    'color'   => $this->get_tariff_feature2_color()
                ],
                [
                    'tooltip' => $this->get_tariff_feature3_tooltip(),
                    'details' => $this->get_tariff_feature3_details(),
                    'color'   => $this->get_tariff_feature3_color()
                ],
                [
                    'tooltip' => $this->get_tariff_feature4_tooltip(),
                    'details' => $this->get_tariff_feature4_details(),
                    'color'   => $this->get_tariff_feature4_color()
                ]
            ];

        }

        /**
         * Tariff feature 1 tooltip
         *
         * @param \shared\classes\calculation\client\model\base $data Get data
         *
         * @return string
         */
        public function get_tariff_feature1_tooltip() {
            //return $this->get_insured_person_state()->get_tariff_feature1_tooltip($this);
            return $this->data['tariff']['product_dependent_features']['tariff_feature1_tooltip'];
        }

        /**
         * Tariff feature 1 details
         *
         * @return string
         */
        public function get_tariff_feature1_details() {
            //return $this->get_insured_person_state()->get_tariff_feature1_details($this);
            return $this->data['tariff']['product_dependent_features']['tariff_feature1_details'];
        }

        /**
         * Tariff feature 1 color
         *
         * @return string
         */
        public function get_tariff_feature1_color() {
            return $this->data['tariff']['product_dependent_features']['tariff_feature1_color'];
        }

        /**
         * Get tariff feature 1 color for children.
         *
         * @return string
         */
        public function get_tariff_feature1_color_for_children() {

            $color = 'green';

            if ($this->get_provision_children_costsharing_amount() >= \classes\calculation\client\model\parameter\pkv::CHILDREN_COSTSHARING_AMOUNT_COMFORT) {
                $color = 'yellow';
            }

            if ($this->get_provision_children_costsharing_amount() >= \classes\calculation\client\model\parameter\pkv::CHILDREN_COSTSHARING_AMOUNT_PREMIUM) {
                $color = 'red';
            }

            return $color;

        }

        /**
         * Tariff feature 21 tooltip
         *
         * @return string
         */
        public function get_tariff_feature2_tooltip() {
            return $this->data['tariff']['product_dependent_features']['tariff_feature2_tooltip'];
        }

        /**
         * Tariff feature 2 details
         *
         * @return string
         */
        public function get_tariff_feature2_details() {
            return $this->data['tariff']['product_dependent_features']['tariff_feature2_details'];
        }

        /**
         * Tariff feature 2 color
         *
         * @return string
         */
        public function get_tariff_feature2_color() {
            return $this->data['tariff']['product_dependent_features']['tariff_feature2_color'];
        }

        /**
         * Tariff feature 3 tooltip
         *
         * @return string
         */
        public function get_tariff_feature3_tooltip() {
            return $this->data['tariff']['product_dependent_features']['tariff_feature3_tooltip'];
        }

        /**
         * Tariff feature 3 details
         *
         * @return string
         */
        public function get_tariff_feature3_details() {
            return $this->data['tariff']['product_dependent_features']['tariff_feature3_details'];
        }

        /**
         * Tariff feature 3 color
         *
         * @return string
         */
        public function get_tariff_feature3_color() {
            return $this->data['tariff']['product_dependent_features']['tariff_feature3_color'];
        }

        /**
         * Tariff feature 4 tooltip
         *
         * @return string
         */
        public function get_tariff_feature4_tooltip() {
            return $this->data['tariff']['product_dependent_features']['tariff_feature4_tooltip'];
        }

        /**
         * Tariff feature 4 details
         *
         * @return string
         */
        public function get_tariff_feature4_details() {
            return $this->data['tariff']['product_dependent_features']['tariff_feature4_details'];
        }

        /**
         * Tariff feature 4 color
         *
         * @return string
         */
        public function get_tariff_feature4_color() {
            return $this->data['tariff']['product_dependent_features']['tariff_feature4_color'];
        }

        /**
         * The editorial score.
         *
         * @return string
         */
        public function get_editorialrating_score() {
            return $this->data['tariff']['product_dependent_features']['editorialrating_score'];
        }

        /**
         * The editorial grade.
         *
         * @return string
         */
        public function get_editorialrating_grade() {
            return $this->data['tariff']['product_dependent_features']['editorialrating_grade'];
        }

        /**
         * The comment of the editorial rating.
         *
         * @return string
         */
        public function get_editorialrating_comment() {
            return $this->data['tariff']['product_dependent_features']['editorialrating_comment'];
        }

        /**
         * The tariff group
         *
         * @return string
         */
        public function get_tariff_group() {
            return $this->data['tariff']['product_dependent_features']['tariff_group'];
        }

        /**
         * Returns is gold grade or not
         *
         * @return boolean
         */
        public function is_gold_grade() {
            return isset($this->data['tariff']['is_gold_grade']) && $this->data['tariff']['is_gold_grade'];
        }

    }
