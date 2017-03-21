<?php

    namespace classes\calculation\mclient\controller\helper;
    use \shared\classes\calculation\client\view\helper\base;

    /**
     * Generate Tariffdetails for PKV
     * Used by PKV result_row and step_login
     *
     * @author Igor Duspara <igor.duspara@check24.de>
     */
    class generate_tariffdetails_pkv extends generate_tariffdetails {

        protected $template            = 'tariffdetails_pkv.tpl';
        private $parameter = NULL;

        /**
         * Constructor
         *
         * @param object $tariff        PKV Tariff
         * @param object $parameter     PKV Parameter
         *
         * @return void
         */
        public function __construct($tariff, $parameter) {

            parent::__construct($tariff);
            $this->parameter = $parameter;

        }

        /**
         * Generate output
         *
         * @return string
         */
        protected function create_output() {

            $mapping_icon_yes_no = [
                'yes' => 'green_checkmark',
                'no'  => 'red_checkmark'
            ];

            $data_arr = [
                'Allgemeine Leistungen' => [
                    'Finanzielle Stabilität' => [
                        'tooltip' => '<h3>Finanzielle Stabilität des Versicherers</h3>
                                        Es gibt eine große Anzahl an Anbietern auf dem Versicherungsmarkt. Eine kurze
                                        Übersicht der finanziellen Lage des ausgewählten Versicherers kann Ihnen bei der
                                        Tarifauswahl helfen.
                                        <br>
                                        <br>
                                        <h3>Marktanteil des Versicherers</h3>
                                        Wir haben die Marktanteile der verschiedenen Versicherer im Bereich
                                        Risikolebensversicherungen analysiert. Hier sehen Sie wie gut sich die
                                        verschiedenen Anbieter auf dem Markt positionieren.
                                        <br>
                                        <br>
                                        <h3>Beschwerdequote</h3>
                                        Eine niedrige Beschwerdequote besagt, dass der Versicherer selten
                                        die Leistung verweigert. Andersherum zeigt eine hohe Beschwerdequote, dass es öfters
                                        mal Auseinandersetzungen zwischen Anbieter und Kunde geben kann.',
                        'icon'  => '',
                        'txt'   => '',
                        'info'  => ''
                    ],
                    'Leistung im Todesfall' => [
                        'tooltip' => '<h3>Leistung bei Todesfall</h3>
                                        Auszahlung der vereinbarten Versicherungssumme im Todesfall der versicherten Person.',
                        'icon'  => '',
                        'txt'   => number_format($this->parameter->get_data()['insure_sum'], 0, NULL, '.') . ' €',
                        'info'  => ''
                    ],
                    'Sofortiger Versicherungsschutz' => [
                        'tooltip' => '<h3>Sofortiger Versicherungsschutz ab Antragseingang</h3>
                                        Vom Antrag bis zum Vertragsabschluss bedarf es einer kurzen Bearbeitungszeit.
                                        Bis dahin liefert Ihnen die Versicherung einen sofortigen Versicherungsschutz.',
                        'icon'  => 'green_checkmark',
                        'txt'   => '',
                        'info'  => ''
                    ]
                ],
                'Informationen zum Beitrag' => [
                    'Stabilität des Beitrags' => [
                        'tooltip' => '<h3>Stabilität des Beitrags (in den letzten 10 Jahren)</h3>
                                        Wenn Sie bei einem Versicherungsunternehmen einen Lebensversicherungsvertrag führen,
                                        erhalten Sie erwirtschaftete Überschüsse in Form von Beitragsreduzierung. Hier sehen
                                        Sie welche Versicherer Überschussbeteiligungen mit einbeziehen und wie stabil diese sind.',
                        'icon'  => ($this->tariff->get_stable_profit_participation_last_ten_years_comment() != '') ? '' : 'green_checkmark',
                        'txt'   => $this->tariff->get_stable_profit_participation_last_ten_years_comment(),
                        'info'  => ''
                    ],
                    'Beitragsverlauf' => [
                        'tooltip' => '<h3>Beitragsverlauf</h3>
                                        Der Beitragsverlauf kann konstant oder wechselnd sein. Bei wechselndem Beitrag
                                        wird hier entsprechend dem tatsächlichem Risiko kalkuliert. Der Tarifbeitrag ist
                                        zu Beginn niedrig, steigt aber mit zunehmendem Alter (und dem damit verbundenem
                                        höheren Risiko).',
                        'icon'  => '',
                        'txt'   => '',
                        'info'  => ''
                    ]
                ],
                'Risikoprüfung und Tarifvoraussetzungen' => [
                    'Annahmequote' => [
                        'tooltip' => '<h3>Annahmequote</h3>
                                        Eine hohe Annahmequote besagt, dass der Versicherer nur wenig Anträge ablehnt.
                                        Andersrum zeigt eine schlechte Annahmequote, dass der Versicherer strenger auf z.B.
                                        gesundheitliche Risiken reagiert.',
                        'icon'  => '',
                        'txt'   => '',
                        'info'  => ''
                    ],
                    'Gesundheitsprüfung' => [
                        'tooltip' => '<h3>Gesundheitsprüfung</h3>
                                        Die Gesundheitsprüfung verläuft je nach Tarifauswahl unterschiedlich. Einige
                                        Versicherer verlangen, dass die Gesundheitsprüfung z.B. ab einer gewissen
                                        Versicherungssumme durch einen Hausarzt erfolgt.',
                        'icon'  => 'orange_checkmark',
                        'txt'   => '',
                        'info'  => ''
                    ],

                    'Wichtige Voraussetzungen' => [
                        'tooltip' => '<h3>Wichtige Voraussetzungen für den Tarif</h3>
                                          Viele Versicherer stellen für einige ihrer Tarife gewisse Voraussetzungen,
                                          die vom Kunden erfüllt werden müssen.',
                        'icon'  => '',
                        'txt'   => '-',
                        'info'  => ''
                    ]
                ]
            ];

            $mapping = [
                'no' => ['icon' => 'red_checkmark', 'txt' => 'nicht gewährleiset'],
                'low' => ['icon' => 'orange_checkmark', 'txt' => 'unsicher'],
                'very_good' => ['icon' => 'green_checkmark', 'txt' => 'hoch'],
                'excellent' => ['icon' => 'green_checkmark', 'txt' => 'sehr hoch'],

            ];


            $data_arr['Allgemeine Leistungen']['Finanzielle Stabilität']['txt'] = $mapping[$this->tariff->get_insurer_financial_stability()]['txt'];

            $mapping = [
                'no'                  => ['icon' => 'red_checkmark',    'txt' => 'Kein vorläufiger Versicherungsschutz'],
                'receipt_at_check24'  => ['icon' => 'orange_checkmark', 'txt' => $this->tariff->get_preliminary_insurance_cover_comment()],
                'receipt_at_insurers' => ['icon' => 'green_checkmark',  'txt' => $this->tariff->get_preliminary_insurance_cover_comment()]

            ];

            $data_arr['Allgemeine Leistungen']['Sofortiger Versicherungsschutz']['icon'] = $mapping[$this->tariff->get_preliminary_insurance_cover()]['icon'];
            $data_arr['Allgemeine Leistungen']['Sofortiger Versicherungsschutz']['info'] = $mapping[$this->tariff->get_preliminary_insurance_cover()]['txt'];


            $mapping = [
                'constant'                       => 'konstant',
                'low_start_contribution'         => 'niedriger Startbeitrag',
                'yearly_changeable_contribution' => 'jährlich wechselnde Beiträge '
            ];

            $data_arr['Informationen zum Beitrag']['Beitragsverlauf']['txt'] = $mapping[$this->tariff->get_contribution_history_of_run_time()];

            $mapping = [
                'low'      => ['icon' => 'red_checkmark',    'txt' => 'niedrig'],
                'average'  => ['icon' => 'orange_checkmark', 'txt' => 'durchschnittlich'],
                'high'     => ['icon' => 'green_checkmark',  'txt' => 'hoch']

            ];

            $txt = ($this->tariff->get_acceptance_rate_by_insurer()) ? $mapping[$this->tariff->get_acceptance_rate_by_insurer()]['txt'] : '';

            $data_arr['Risikoprüfung und Tarifvoraussetzungen']['Annahmequote']['txt'] = $txt;

            $mapping = [
                'yes'        => 'Selbstauskunft durch Kunde',
                'no'         => '',
            ];
            $mapping2 = [
                'no'                 => ', nein',
                'yes'                => ', ja',
                'family_doctor'      => ', zusätzliche Gesundheitsprüfung durch Hausarzt ',
                'by_medical_service' => ', zusätzliche Gesundheitsprüfung durch medizinischen Dienst '
            ];

            $data_arr['Risikoprüfung und Tarifvoraussetzungen']['Gesundheitsprüfung']['info'] = $mapping[$this->tariff->get_health_issues_self_disclosure_by_customer()];

            if ($this->tariff->get_additional_health_examination_by_doctor() != 'no') {
                $data_arr['Risikoprüfung und Tarifvoraussetzungen']['Gesundheitsprüfung']['info'] .= $mapping2[$this->tariff->get_additional_health_examination_by_doctor()]
                    . $this->tariff->get_additional_health_examination_by_doctor_comment();
            } else {
                $data_arr['Risikoprüfung und Tarifvoraussetzungen']['Gesundheitsprüfung']['info'] .= ' ' . $this->tariff->get_additional_health_examination_by_doctor_comment();
            }

            if ($this->parameter->get_data()['smoker'] == 'no') {
                $data_arr['Risikoprüfung und Tarifvoraussetzungen']['Wichtige Voraussetzungen']['txt'] = 'Nichtraucher';
                $data_arr['Risikoprüfung und Tarifvoraussetzungen']['Wichtige Voraussetzungen']['info'] = '<p>' . $this->tariff->get_non_smoker_comment() . '</p>';
            } else if ($this->parameter->get_data()['smoker'] == 'yes'){
                $data_arr['Risikoprüfung und Tarifvoraussetzungen']['Wichtige Voraussetzungen']['txt'] = '-';
            }

            if ($this->tariff->get_tariff_id() == '178' || $this->tariff->get_tariff_id() == '180') {
                $data_arr['Risikoprüfung und Tarifvoraussetzungen']['Wichtige Voraussetzungen']['txt'] .= '<br>Hobbys<br>BMI';
            }

            if ($this->tariff->get_tariff_id() == '205'
                || $this->tariff->get_tariff_id() == '204'
                || $this->tariff->get_tariff_id() == '206'
                || $this->tariff->get_tariff_id() == '207'
                || $this->tariff->get_tariff_id() == '208') {
                $data_arr['Risikoprüfung und Tarifvoraussetzungen']['Wichtige Voraussetzungen']['txt'] .= ', Gemeinsamer Haushalt';
            }

            if ($this->tariff->get_special_tariff_conditions() != '') {
                $data_arr['Risikoprüfung und Tarifvoraussetzungen']['Wichtige Voraussetzungen']['info'] .= nl2p($this->tariff->get_special_tariff_conditions());
            }

            $html = '';

            foreach ($data_arr AS $key => $value) {

                $html .= '<div class="c24-tariffdetails-block"><h1>' . $key . '</h1>';

                foreach ($value AS $title => $data) {

                    $icon = (isset($data['icon']) && $data['icon'] != '') ? '<div class="checkmark ' . $data['icon'] . '"></div>' : '';;
                    $info = (isset($data['info']) && $data['info'] != '') ? '<div class="info"><i class="fa fa-info-circle"></i> <p>'
                        . $data['info'] . '</p></div>' : '';;
                    $tooltip = (isset($data['tooltip']) && $data['tooltip'] != '') ? $data['tooltip'] : '';
                    $txt = (isset($data['txt']) && $data['txt'] != '') ? $data['txt'] : '';;

                    $html .= '<div class="c24-content-row-info c24-tariffdetails-info" style="">
                                <div class="c24-content-row-block">
                                    <div class="c24-content-row-info-content c24-header-info-content">
                                        <h2>' . $title . '</h2>
                                    </div>
                                    <div class="value">' . $icon . $txt . '</div>
                                    <div class="c24-content-row-info-icon js-c24-info-icon">
                                        <div class="c24-info-icon">?</div>
                                    </div>
                                    <div class="c24-content-row-info-subcontent"></div>
                                    ' . $info . '
                                </div>
                                <div class="c24-content-row-block-infobox clearfix" style="display: none;">
                                    <div class="c24-content-row-info-text">
                                        <div class="c24-content-row-info-text-content">
                                ' . $tooltip . '
                                </div>
                                    </div>
                                </div>
                            </div>';

                }

                $html .= '</div>';

            }

            return $html;

        }

    }
