<?php

    namespace classes\calculation\client\controller\helper;

    use \shared\classes\calculation\client\view\helper\base;

    /**
     * Class generate_tariffgrade_pkv
     *
     * @author Viktar Khomich <viktar.khomich@check24.de>
     */
    class generate_tariffgrade_pkv extends base {

        /**
         *  CSS class for smaller tariff grade description
         */
        const SMALLER_GRADE_CLASS = 'smaller';

        protected $tariff;
        protected $template_path;
        protected $calculation_parameter_id = '';

        private $grade_description = [
            'ranges'        => [1.1, 1.6, 2.6, 3.6, 4.1],
            'descriptions'  => [
                'exzellent',
                'sehr gut',
                'gut',
                'befriedigend',
                'ausreichend'
            ]
        ];

        /**
         * Used for css class for smaller tariff grade description
         *
         * @var string
         */
        private $grade_text_class = '';

        /**
         * Compare array to check for smaller css class
         *
         * @var array
         */
        private $grade_text_smaller = array('befriedigend', 'ausreichend');

        /**
         * Whether to enable or disable the view of the subscription button.
         *
         * @var bool
         */
        private $subscription_button_enabled = true;

        /**
         * Whether to enable or disable the caret on the Tooltip
         * @var bool
         */
        private $caret_enabled = true;

        /**
         * Constructor
         *
         * @param $tariff Tariff pkv
         * @param string $calculation_param_id The calculation parameter ID to use.
         *
         * @return void
         */
        public function __construct($tariff, $calculation_param_id = '') {

            \shared\classes\common\utils::check_object($tariff, 'tariff');
            \shared\classes\common\utils::check_string($calculation_param_id, 'calculation_param_id', true);

            $this->tariff = $tariff;
            $this->calculation_param_id = $calculation_param_id;

        }


        /**
         * Get current status
         *
         * @return boolean
         */
        public function is_subscription_button_enabled() {
            return $this->subscription_button_enabled;
        }

        /**
         * Set subscription button to enabled
         *
         * @param boolean $subscription_button_enabled Default value
         * @return void
         */
        public function set_subscription_button_enabled($subscription_button_enabled = true) {
            check_bool($subscription_button_enabled, 'subscription_button_enabled');
            $this->subscription_button_enabled = $subscription_button_enabled;
        }

        /**
         * Get current status
         *
         * @return boolean
         */
        public function is_caret_enabled() {
            return $this->caret_enabled;
        }

        /**
         * Set caret to enabled
         *
         * @param boolean $caret_enabled Default value
         * @return void
         */
        public function set_caret_enabled($caret_enabled) {
            check_bool($caret_enabled, 'caret_enabled');
            $this->caret_enabled = $caret_enabled;
        }

        /**
         * Generate note details for given tariff
         *
         * @param boolean $with_details Include all details in the rendered tree.
         * @return string
         */
        public function create_output($with_details = false) {

            $features_tree = $this->tariff->get_tariff_features();

            $output = '';

            if ($features_tree) {

                $output_caret = '';

                if ($this->caret_enabled) {
                    $output_caret = '<div class="c24-tooltip-grade-caret"></div>';
                }

                $output .= '
            <span style="display:none;" class="c24-tooltip-content">
                ' . $output_caret . '
                <div class="c24-tooltip-grade-close"></div>

                <div>

                    <div class="header_grade">
                       Berechnung der Tarifnote ' . number_format($features_tree['global']['content']['grade'], 1, ',', NULL) . ' (' . $this->get_grade_description($features_tree['global']['content']['grade']) . ')
                    </div>


                    <div id="tariff_grade">
                       <section>
                           <header>
                               <div class="main_headers">
                                   <div class="criteria"><h2>Kriterien</h2></div>
                                   <div class="grades"><h2>Note</h2></div>
                                   <div class="points"><h2>Punkte</h2></div>
                               </div>
                           </header>
                           <article>
               ';

                if ($with_details) {

                    $this->fill_tariffs_with_feature_tree();
                    $output .= $this->create_output_details();

                } else {
                    $output .= '<div class="c24-inner-tooltip-content"></div>';
                }

                $subscription = $this->tariff->get_subscription();

                $output_subscription_button = '';

                if ($this->is_subscription_button_enabled()) {

                    $output_subscription_button = '<div class="button">
                               <a class="c24-button btn_get_offer" href="' . $subscription['url'] . '" target="_self" style="padding: 5px!important;">Alle Tarifdetails anzeigen »</a>
                       </div>';

                }

                $output .= $output_subscription_button . '
                    <div id="tariff_grade_legend">
                        <ul>
                            <li><div class="green"></div> <span>Sehr gute Leistung</span></li>
                            <li><div class="orange"></div> <span>Gute Leistung</span></li>
                            <li><div class="gray"></div> <span>Durchschnittliche Leistung</span></li>
                        </ul>
                    </div>
                   </div>
                </div>
            </span>
            ';

            }

            return $output;

        }

        /**
         * Generates detail output for the tooltip.
         *
         * @return string
         */
        public function create_output_details() {

            $features_tree = $this->tariff->get_tariff_features();
            $output = '';

            if (isset($features_tree['global']['next'])) {

                $header_size_count = isset($features_tree['global']['next']) ? count($features_tree['global']['next']) : 0;
                $header_size = 0;
                $add_last_css_class = '';

                foreach ($features_tree['global']['next'] AS $group_key => $group) {

                    $header_size++;

                    if ($header_size_count == $header_size) {
                        $add_last_css_class = 'last';
                    }

                    $output .= '
                    <section class="' . $add_last_css_class . '">
                       <header>
                          <div class="sub_headers">
                          <div class="criteria">' . $group['content']['name'] . '</div>
                          <div class="grades">' . number_format($group['content']['grade'], 1, ',', NULL) . '</div>
                               <div class="points">
                                   <div class="ribbon ' . $this->get_color($group['content']['points']['color']) . '_full">
                                       ' . (int) $group['content']['points']['current_value'] . ' von ' . (int) $group['content']['points']['max_value'] . '
                                   </div>
                               </div>
                          </div>
                       </header>
                ';

                    foreach ($group['next'] AS $key_child_group => $child_group) {

                        if (isset($child_group['next']) && $child_group['next'] != NULL) {

                            $output .= '
                               <article>
                                   <div class="column1">' . $child_group['content']['name'] . '</div>
                                   <div class="column2">
                                       <div class="ribbon ' . $this->get_color($child_group['content']['points']['color']) . '">
                                           ' . (int) $child_group['content']['points']['current_value'] . ' von ' . (int) $child_group['content']['points']['max_value'] . '
                                       </div>
                                   </div>
                               </article>
                        ';

                        }

                    }

                    $output .= '</section>';

                }

            }

            return $output;

        }

        /**
         * Get grade description
         *
         * @param float $grade Grade of tarif
         *
         * @return mixed
         */
        public function get_grade_description($grade) {

            if ($grade) {

                check_float($grade, 'grade');

                foreach ($this->grade_description['ranges'] AS $key => $number) {

                    if ($grade < $number) {

                        //@TODO getter function should not change any data, this code should be moved in future
                        if (in_array($this->grade_description['descriptions'][$key], $this->grade_text_smaller)) {
                            $this->set_grade_text_class(self::SMALLER_GRADE_CLASS);
                        }

                        return $this->grade_description['descriptions'][$key];
                    }

                }

            }

        }


        /**
         * Gets the calculation parameter ID.
         *
         * @return string
         */
        public function get_calculation_parameter_id() {
            return $this->calculation_parameter_id;
        }

        /**
         * Sets the calculation parameter ID.
         *
         * @param string $calculation_parameter_id The calculation parameter ID.
         * @return void
         */
        public function set_calculation_parameter_id($calculation_parameter_id) {
            $this->calculation_parameter_id = $calculation_parameter_id;
        }

        /**
         * Getter for grade_text_class
         *
         * @return string
         */
        public function get_grade_text_class()
        {
            return $this->grade_text_class;
        }

        /**
         * Setter for grade_text_class
         *
         * @param string $grade_text_class
         */
        public function set_grade_text_class($grade_text_class)
        {
            check_string($grade_text_class, 'grade_text_class', true);
            $this->grade_text_class = $grade_text_class;
        }
    }
