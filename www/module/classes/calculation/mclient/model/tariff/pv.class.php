<?php

    namespace classes\calculation\mclient\model\tariff;

    use classes\calculation\client\model\parameter\pkv;

    /**
     * Represents the tariff model for pv.
     *
     * @author Igor Duspara <igor.duspara@check24.de>
     */
    abstract class pv extends base {

        const PROMOTION_CAMPAIGN = 'promotion';

        /**
         * Get tariff promotion
         *
         * @return string Either 'no', 'sofortbonus' or 'topoeko'
         */
        public function get_tariff_promotion() {
            return $this->data['tariff']['promotion'];
        }

        /**
         * Get tariff interferer
         *
         * @return string Is 'Yes' or 'No'
         */
        public function get_tariff_interferer() {
            return $this->data['tariff']['interferer'];
        }

        /**
         * Get tariff interferer_text
         *
         * @return string The interferer-text
         */
        public function get_tariff_interferer_text() {
            return $this->data['tariff']['interferer_text'];
        }

        /**
         * Get tariff interferer_tooltip_title
         *
         * @return string The tooltip-title of interferer
         */
        public function get_tariff_interferer_tooltip_title() {
            return $this->data['tariff']['interferer_tooltip_title'];
        }

        /**
         * Get tariff interferer_tooltip_text
         *
         * @return string The tooltip-text of interferer
         */
        public function get_tariff_interferer_tooltip_text() {
            return $this->data['tariff']['interferer_tooltip_text'];
        }

        /**
         * Get tariff interferer_profession()
         *
         * @return string The selected profession for interferer
         */
        public function get_tariff_interferer_profession() {
            return $this->data['tariff']['interferer_profession'];
        }

        /**
         * Get tariff variation key
         *
         * @return string Tariffvariation key
         */
        public function get_tariff_variation_key() {
            return $this->data['tariff']['variation_key'];
        }

        /**
         * Get tariff id
         *
         * @return string Tariff id
         */
        public function get_tariff_id() {
            return $this->data['tariff']['id'];
        }

        /**
         * Get tariff product id
         *
         * @return string Tariff product id
         */
        public function get_tariff_product_id() {
            return $this->data['tariff']['product_id'];
        }

        /**
         * Get tariff promotion title
         *
         * @return string
         */
        public function get_tariff_promotion_title() {


            if (isset($this->data['tariff']['promotion_version_new']) && $this->data['tariff']['promotion_version_new'] && isset($this->data['tariff']['promotion_type'])) {

                $promotion_data = $this->data['tariff']['promotion_data'];

                if (isset($promotion_data[$this->parameter->get_profession()])) {
                    return $promotion_data[$this->parameter->get_profession()]['title'];
                }

            } else {
                return $this->data['tariff']['promotion_title'];
            }

        }

        /**
         * Returns promotion name to be view in the first tariff of the compare result
         *
         * @param string $profession Profession of the tariff
         *
         * @return string
         */
        public function get_tariff_promotion_bin($profession) {

            $mapping = [
                'high_benefit'              => 'Leistungs-Empfehlung',
                'high_price_benefit'        => 'Preis-Leistungs-Empfehlung',
                self::PROMOTION_CAMPAIGN    => 'Aktion'
            ];

            if (isset($this->data['tariff']['promotion_version_new']) && $this->data['tariff']['promotion_version_new']
                && isset($this->data['tariff']['promotion_type']) && !empty($this->data['tariff']['promotion_type'])) {

                if ($this->data['tariff']['promotion_type'] == self::PROMOTION_CAMPAIGN) {

                    if (!empty($this->data['tariff']['promotion_data'])) {

                        foreach ($this->data['tariff']['promotion_data'] as $item) {

                            foreach ($item as $profession_key => $promotion_data) {

                                if ($profession == $profession_key || $profession == pkv::PROFESSION_ALL) {
                                    return $promotion_data['title'];
                                }

                            }

                        }

                    }

                }

                $promotion_type = $this->data['tariff']['promotion_type'];
                return $mapping[$promotion_type];

            } else {
                $promotion_bin = $this->data['tariff']['promotion_bin'];
                return !empty($promotion_bin) ? $mapping[$promotion_bin] : '';
            }

        }

        /**
         * Get tariff validfrom
         *
         * @return string
         */
        public function get_tariff_validfrom() {
            return $this->data['tariff']['validfrom'];
        }

        /**
         * Get tariff cancellationperiod days
         *
         * @return integer
         */
        public function get_tariff_cancellationperiod_days() {
            return $this->data['tariff']['cancellationperiod_days'];
        }

        /**
         * Returns the attachment urls of the tariff.
         *
         * The result is an assoc array. Keys identifies the attachment and are
         * one of \tariff\attachment\base::get_all_names().
         *
         * @return assoc
         */
        public function get_tariff_attachments() {
            return $this->data['tariff']['attachments'];
        }

        /**
         * Get tariff code
         *
         * @return string
         */
        public function get_tariff_code() {
            return $this->data['tariff']['code'];
        }

        /**
         * Get tariff actioncode
         *
         * @return string
         */
        public function get_tariff_actioncode() {
            return $this->data['tariff']['actioncode'];
        }

        /**
         * Get tariff variation key
         *
         * @return array
         */
        public function get_tariff_tips() {
            return $this->data['tariff']['tips'];
        }

        /**
         * Get tariff variation key
         *
         * @return string
         */
        public function get_tariff_tips_as_string() {

            if ($this->data['tariff']['tips'] !== NULL) {
                return trim(implode('. ', $this->data['tariff']['tips']));
            } else {
                return '';
            }

        }

        /**
         * Get tariff communication
         *
         * @return string
         */
        public function get_tariff_communication() {

            if (isset($this->data['tariff']['communication'])) {
                return $this->data['tariff']['communication'];
            } else {
                return NULL;
            }

        }

        /**
         * Returns the max total score of the tariff grade calculation.
         *
         * @return integer
         */
        public function get_tariff_grade_max_points() {
            return $this->data['tariff']['grade']['max_points'];
        }

        /**
         * Returns the actual total score of the tariff grade calculation.
         *
         * @return integer
         */
        public function get_tariff_grade_total_points() {
            return $this->data['tariff']['grade']['total_points'];
        }

        /**
         * Returns the resulting grade (based on total / max).
         *
         * @return float
         */
        public function get_tariff_grade_result() {
            return $this->data['tariff']['grade']['result'];
        }

        /**
         * Returns the name of the calculated grade (like "sehr gut").
         *
         * @return string
         */
        public function get_tariff_grade_name() {
            return $this->data['tariff']['grade']['name'];
        }

        /**
         * Returns the feature array containing all results and metadata.
         *
         * The structure ist:
         * [
         *   FEATURE_KEY1 => [
         *      'icon'       => {OK,NotOK,''},
         *      'max_points' => integer,        // max points of this feature
         *      'points'     => integer,        // current points of this feature
         *      'txt'        => string
         *   ]
         * ]
         *
         * @return array
         */
        public function get_tariff_grade_feature_details() {
            return $this->data['tariff']['grade']['feature_details'];
        }

        /**
         * Returns the array with tariff feature.
         *
         * @return mixed
         */
        public function get_tariff_feature() {
            return isset($this->data['tariff']['feature']) ? $this->data['tariff']['feature'] : [];
        }

        /**
         * Returns the total price net in euro cent. This is a wrapper for
         * ::get_price_net_total for backwards compatibility, but will be
         * removed soon.
         *
         * @return float
         * @deprecated Please use ::get_price_net_total instead.
         */
        public function get_price_price() {
            return $this->data['price']['net']['total'];
        }

        /**
         * Returns the total price net in euro cent. This is a wrapper for
         * ::get_price_net_total for backwards compatibility, but will be
         * removed soon.
         *
         * @return float
         * @deprecated Please use ::get_price_net_total
         */
        public function get_price_price_with_bonus() {
            return $this->get_price_net_without_bonus();
        }

        /**
         * Returns the total price net in euro.
         * This method is deprecated and will be removed soon. Please calculate
         * the euro price yourself...
         *
         * @return float
         * @deprecated Please calculate the euro price yourself.
         */
        public function get_price_price_with_bonus_euro() {
            return $this->get_price_price_with_bonus() / 100;
        }

        /**
         * Returns the price net in euro cent without bonus. This is a wrapper
         * for ::get_price_net_without_bonus for backwards compatibility, but
         * will be removed soon.
         *
         * @return float
         * @deprecated Please use ::get_price_net_without_bonus
         */
        public function get_price_regularprice() {
            return $this->get_price_net_without_bonus();
        }

        /**
         * Returns the total price net in euro cent.
         *
         * @return float
         */
        public function get_price_net_total() {
            return $this->data['price']['net']['total'];
        }

        /**
         * Returns the total price gross in euro cent.
         *
         * @return float
         */
        public function get_price_gross_total() {
            return $this->data['price']['gross']['total'];
        }

        /**
         * Returns the price net without bonus in euro cent.
         *
         * @return float
         */
        public function get_price_net_without_bonus() {
            return $this->data['price']['net']['without_bonus'];
        }

        /**
         * Returns the price gross without bonus in euro cent.
         *
         * @return float
         */
        public function get_price_gross_without_bonus() {
            return $this->data['price']['gross']['without_bonus'];
        }

        /**
         * Get bonus
         *
         * @return array
         */
        public function get_bonus() {
            return $this->data['bonus'];
        }

        /**
         * Returns all boni where $bonus[$key] == $value.
         *
         * For instance  ::get_boni_by('condition_id', $value)  returns all
         * boni matching the given condition_id.
         *
         * @param string $key  Key of the boni to check.
         * @param mixed $value Value to check against.
         * @return array
         */
        public function get_boni_by($key, $value) {

            \shared\classes\common\utils::check_string($key, 'key');

            $bonus_data = $this->get_bonus();
            $result = array();

            for ($i = 0, $n = count($bonus_data); $i < $n; ++$i) {

                if ($bonus_data[$i][$key] == $value) {
                    $result[] = $bonus_data[$i];
                }

            }

            return $result;

        }

        /**
         * Get paymentperiod period
         *
         * @return string The payment period (year, semester, quarter, month).
         */
        public function get_paymentperiod_period() {
            return $this->data['paymentperiod']['period'];
        }

        /**
         * Get paymentperiod count
         *
         * @return integer
         */
        public function get_paymentperiod_count() {
            return $this->data['paymentperiod']['count'];
        }

        /**
         * Get paymentperiod size total (net). This is a wrapper for
         * ::get_paymentperiod_size_net_total for backward compatibility.
         *
         * @return float
         * @deprecated Please use get_paymentperiod_size_net_total.
         */
        public function get_paymentperiod_size() {
            return $this->get_paymentperiod_size_net_total();
        }

        /**
         * Get paymentperiod size without bonus (net). This is a wrapper for
         * ::get_paymentperiod_size_net_without_bonus for backward compatibility.
         *
         * @return float
         * @deprecated Please use get_paymentperiod_size_net_without_bonus
         */
        public function get_paymentperiod_size_without_bonuses() {
            return $this->get_paymentperiod_size_net_without_bonus();
        }

        /**
         * Returns the payment period size total (net).
         *
         * @return float
         */
        public function get_paymentperiod_size_net_total() {
            return $this->data['paymentperiod']['size']['net']['total'];
        }

        /**
         * Returns the payment period size total (gross).
         *
         * @return float
         */
        public function get_paymentperiod_size_gross_total() {
            return $this->data['paymentperiod']['size']['gross']['total'];
        }

        /**
         * Returns the payment period size without bonus (net).
         *
         * @return float
         */
        public function get_paymentperiod_size_net_without_bonus() {
            return $this->data['paymentperiod']['size']['net']['without_bonus'];
        }

        /**
         * Returns the payment period size without bonus (gross).
         *
         * @return float
         */
        public function get_paymentperiod_size_gross_without_bonus() {
            return $this->data['paymentperiod']['size']['gross']['without_bonus'];
        }

        /**
         * Get paymentperiod label
         *
         * @return string
         */
        public function get_paymentperiod_label() {
            return $this->data['paymentperiod']['label'];
        }

        /**
         * Get paymentperiod label adjectiv
         *
         * @return string
         */
        public function get_paymentperiod_label_adjectiv() {
            return $this->data['paymentperiod']['label_adjectiv'];
        }

        /**
         * Get paymentperiod lower size
         *
         * @return float
         */
        public function get_paymentperiod_lower_size() {
            return $this->data['paymentperiod']['lower_size'];
        }

        /**
         * Get paymentperiod upper size
         *
         * @return float
         */
        public function get_paymentperiod_upper_size() {
            return $this->data['paymentperiod']['upper_size'];
        }

        /**
         * Get customdata
         *
         * @return array
         */
        public function get_customdata() {
            return $this->data['customdata'];
        }

        /**
         * Get postfilter flags
         *
         * @return array
         */
        public function get_flags() {
            return $this->data['flags'];
        }

        /**
         * Returns the payment duration
         *
         * @return integer
         */
        public function get_payment_duration() {
            return $this->data['payment']['duration'];
        }

        /**
         * Get payment options
         *
         * @return string
         */
        public function get_payment_options() {
            return $this->data['payment']['options'];
        }

        /**
         * Get payment transfer cost once
         *
         * @return float
         */
        public function get_payment_transfer_cost_once() {
            return $this->data['payment']['transfer']['cost']['once'];
        }

        /**
         * Get payment transfer cost monthly
         *
         * @return float
         */
        public function get_payment_transfer_cost_monthly() {
            return $this->data['payment']['transfer']['cost']['monthly'];
        }

        /**
         * Returns the url to subscribe this tariff.
         *
         * @return string
         */
        public function get_subscription() {
            return $this->data['subscription'];
        }

        /**
         * Returns the customer feedback data for this tariff.
         *
         * @return array
         */
        public function get_customerfeedback() {
            return $this->data['customerfeedback'];
        }

        /**
         * Returns the efeedback data for this tariff.
         *
         * @return array
         */
        public function get_efeedback() {
            return $this->data['efeedback'];
        }

    }

