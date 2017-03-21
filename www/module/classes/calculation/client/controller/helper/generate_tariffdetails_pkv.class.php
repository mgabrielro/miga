<?php

    namespace classes\calculation\client\controller\helper;
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
                'Leistung des Tarifs' => [
                    'Information zum Versicherer' => [
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
                        'txt'   => ''
                    ],
                    'Leistung im Todesfall' => [
                        'tooltip' => '<h3>Leistung bei Todesfall</h3>
                                    Auszahlung der vereinbarten Versicherungssumme im Todesfall der versicherten Person.',
                        'icon'  => 'green_checkmark',
                        'txt'   => number_format($this->parameter->get_data()['insure_sum'], 0, NULL, '.') . ' € Auszahlung an die begünstigte Person'
                    ],
                    'Sofortiger Versicherungsschutz' => [
                        'tooltip' => '<h3>Sofortiger Versicherungsschutz ab Antragseingang</h3>
                                    Vom Antrag bis zum Vertragsabschluss bedarf es einer kurzen Bearbeitungszeit.
                                    Bis dahin liefert Ihnen die Versicherung einen sofortigen Versicherungsschutz.',
                        'icon'  => '',
                        'txt'   => ''
                    ]
                ],
                'Informationen zum Beitrag' => [
                    'Stabilität des Beitrags (in den letzten 10 Jahren)' => [
                        'tooltip' => '<h3>Stabilität des Beitrags (in den letzten 10 Jahren)</h3>
                                    Wenn Sie bei einem Versicherungsunternehmen einen Lebensversicherungsvertrag führen,
                                    erhalten Sie erwirtschaftete Überschüsse in Form von Beitragsreduzierung. Hier sehen
                                    Sie welche Versicherer Überschussbeteiligungen mit einbeziehen und wie stabil diese sind.',
                        'icon'  => $mapping_icon_yes_no[$this->tariff->get_stable_profit_participation_last_ten_years()],
                        'txt'   => $this->tariff->get_stable_profit_participation_last_ten_years_comment()
                    ],
                    'Beitragsverlauf' => [
                        'tooltip' => '<h3>Beitragsverlauf</h3>
                                    Der Beitragsverlauf kann konstant oder wechselnd sein. Bei wechselndem Beitrag wird
                                    hier entsprechend dem tatsächlichem Risiko kalkuliert. Der Tarifbeitrag ist zu Beginn
                                    niedrig, steigt aber mit zunehmendem Alter (und dem damit verbundenem höheren Risiko).',
                        'icon'  => '',
                        'txt'   => ''
                    ]
                ],
                'Risikoprüfung und Tarifvoraussetzungen' => [
                    'Annahmequote' => [
                        'tooltip' => '<h3>Annahmequote</h3>
                                    Eine hohe Annahmequote besagt, dass der Versicherer nur wenig Anträge ablehnt.
                                    Andersrum zeigt eine schlechte Annahmequote, dass der Versicherer strenger auf z.B.
                                    gesundheitliche Risiken reagiert.',
                        'icon'  => '',
                        'txt'   => ''
                    ],
                    'Gesundheitsprüfung' => [
                        'tooltip' => '<h3>Gesundheitsprüfung</h3>
                                    die Gesundheitsprüfung verläuft je nach Tarifauswahl unterschiedlich. Einige
                                    Versicherer verlangen, dass die Gesundheitsprüfung z.B. ab einer gewissen
                                    Versicherungssumme durch einen Hausarzt erfolgt.',
                        'icon'  => '',
                        'txt'   => ''
                    ],

                    'Wichtige Voraussetzungen für den Tarif' => [
                        'tooltip' => '<h3>Wichtige Voraussetzungen für den Tarif</h3>
                                      Viele Versicherer stellen für einige ihrer Tarife gewisse Voraussetzungen,
                                      die vom Kunden erfüllt werden müssen.',
                        'icon'  => '',
                        'txt'   => '',
                    ]
                ]
            ];

            $mapping = [
                'no' => ['icon' => 'red_checkmark', 'txt' => 'Finanzielle Stabilität nicht gewährleiset'],
                'low' => ['icon' => 'orange_checkmark', 'txt' => 'Finanzielle Stabilität unsicher'],
                'very_good' => ['icon' => 'green_checkmark', 'txt' => 'Gute finanzielle Stabilität'],
                'excellent' => ['icon' => 'green_checkmark', 'txt' => 'Sehr hohe finanzielle Stabilität'],

            ];
            $insure_share_map = [
                'market_leader_pkv' => 'Marktführer Risikoleben',
                'top_three_pkv'     => 'Top 3 Risikoleben',
                'top_ten_pkv'       => 'Top 10 Risikoleben',
                'no_information'    => 'keine Information vorhanden'

            ];

            $data_arr['Leistung des Tarifs']['Information zum Versicherer']['icon'] = $mapping[$this->tariff->get_insurer_financial_stability()]['icon'];
            $data_arr['Leistung des Tarifs']['Information zum Versicherer']['txt'] = $mapping[$this->tariff->get_insurer_financial_stability()]['txt']
                . ', ' . $insure_share_map[$this->tariff->get_insurer_market_share()];

            $mapping = [
                'no'                  => ['icon' => 'red_checkmark',    'txt' => 'Kein vorläufigerer Versicherungsschutz'],
                'receipt_at_check24'  => ['icon' => 'orange_checkmark', 'txt' => $this->tariff->get_preliminary_insurance_cover_comment()],
                'receipt_at_insurers' => ['icon' => 'green_checkmark',  'txt' => $this->tariff->get_preliminary_insurance_cover_comment()]

            ];

            $data_arr['Leistung des Tarifs']['Sofortiger Versicherungsschutz']['icon'] = $mapping[$this->tariff->get_preliminary_insurance_cover()]['icon'];
            $data_arr['Leistung des Tarifs']['Sofortiger Versicherungsschutz']['txt'] = $mapping[$this->tariff->get_preliminary_insurance_cover()]['txt'];


            $mapping = [
                'constant'                       => ['icon' => '', 'txt' => 'Konstant'],
                'low_start_contribution'         => ['icon' => '', 'txt' => 'Niedriger Startbeitrag'],
                'yearly_changeable_contribution' => ['icon' => 'orange_checkmark', 'txt' => 'Jährlich wechselnde Beiträge']
            ];

            $data_arr['Informationen zum Beitrag']['Beitragsverlauf']['txt'] = $mapping[$this->tariff->get_contribution_history_of_run_time()]['txt'];
            $data_arr['Informationen zum Beitrag']['Beitragsverlauf']['icon'] = $mapping[$this->tariff->get_contribution_history_of_run_time()]['icon'];

            $mapping = [
                'low'      => ['icon' => 'red_checkmark',    'txt' => 'Niedrige Annahmequote'],
                'average'  => ['icon' => 'orange_checkmark', 'txt' => 'Durchschnittliche Annahmequote'],
                'high'     => ['icon' => 'green_checkmark',  'txt' => 'Hohe Annahmequote']

            ];

            $icon = ($this->tariff->get_acceptance_rate_by_insurer()) ? $mapping[$this->tariff->get_acceptance_rate_by_insurer()]['icon'] : '';
            $txt = ($this->tariff->get_acceptance_rate_by_insurer()) ? $mapping[$this->tariff->get_acceptance_rate_by_insurer()]['txt'] : '';

            $data_arr['Risikoprüfung und Tarifvoraussetzungen']['Annahmequote']['icon'] = $icon;
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

            $data_arr['Risikoprüfung und Tarifvoraussetzungen']['Gesundheitsprüfung']['txt'] = $mapping[$this->tariff->get_health_issues_self_disclosure_by_customer()];

            if ($this->tariff->get_additional_health_examination_by_doctor() != 'no') {
                $data_arr['Risikoprüfung und Tarifvoraussetzungen']['Gesundheitsprüfung']['txt'] .= $mapping2[$this->tariff->get_additional_health_examination_by_doctor()]
                    . $this->tariff->get_additional_health_examination_by_doctor_comment();
            } else {
                $data_arr['Risikoprüfung und Tarifvoraussetzungen']['Gesundheitsprüfung']['txt'] .= $this->tariff->get_additional_health_examination_by_doctor_comment();
            }

            if ($this->parameter->get_data()['smoker'] == 'no') {
                $data_arr['Risikoprüfung und Tarifvoraussetzungen']['Wichtige Voraussetzungen für den Tarif']['txt'] = '<p>' . $this->tariff->get_non_smoker_comment() . '</p>';
            }

            $data_arr['Risikoprüfung und Tarifvoraussetzungen']['Wichtige Voraussetzungen für den Tarif']['txt'] .= nl2p($this->tariff->get_special_tariff_conditions());

            $html = '';

            foreach ($data_arr AS $key => $value) {

                $html .= '
                <h3>' . $key . '</h3>
                <table class="tariffdetails">
                <tbody>
                ';

                foreach ($value AS $title => $data) {

                    $html .= '<tr>
                    <td class="col-name">' . $title . '</td>
                    <td class="col-info">
                        <span class="c24-tooltip" data-direction="right" data-trigger="click">
                            <div class="c24-er-info">
                                <div class="info_circle"></div>
                            </div>

                            <span class="c24-tooltip-content" style="top: -157px; left: -61px;">
                                <div class="c24-tooltip-arrow right" style="left: 123.5px;"></div>
                                <div class="c24-tooltip-close" style="display: none;"></div>
                                ' . $data['tooltip'] . '
                            </span>
                        </span>
                    </td>
                    <td class="col-value">';

                    if ($data['icon']) {
                        $html .= '<div class="checkmark ' . $data['icon'] . '"></div>';
                    }

                    $html .= '<span>' . $data['txt'] . '</span>
                    </td>
                </tr>';

                }

                $html .= '</tbody></table>';

            }



            $pdf = $this->tariff->get_tariff_attachments();
            $pdf_documents = [
                'terms'       => ['name' => 'Versicherungsbedingungen', 'tooltip' => 'In den Versicherungsbedingungen werden alle relevanten Informationen über den Versicherungstarif detailliert aufgeführt, unter anderem die genauen Leistungen der gewählten Versicherung und die versicherten Bereiche. Die Versicherungsbedingungen der einzelnen Tarife können hier im PDF-Format heruntergeladen werden.'],
                'terms_extra' => ['name' => 'Besondere Versicherungsbedingungen', 'tooltip' => 'In den Versicherungsbedingungen werden alle relevanten Informationen über den Versicherungstarif detailliert aufgeführt, unter anderem die genauen Leistungen der gewählten Versicherung und die versicherten Bereiche. Die Versicherungsbedingungen der einzelnen Tarife können hier im PDF-Format heruntergeladen werden.']
            ];

            $pdf_exists = false;
            $pdf_html = '';

            foreach ($pdf_documents AS $pdf_document_key => $pdf_document) {

                if ($pdf[$pdf_document_key]) {

                    $pdf_exists = true;

                    $pdf_html .= '<tr>
                            <td class="col-name">' . $pdf_document['name'] . '</td>
                            <td class="col-info">
                                <span class="c24-tooltip" data-direction="up" data-trigger="click">
                                    <div class="info_circle"></div>
                                    <span class="c24-tooltip-content" style="top: -157px; left: -61px;">
                                        <div class="c24-tooltip-arrow up" style="left: 123.5px;"></div>
                                        <div class="c24-tooltip-close" style="display: none;"></div>
                                        <h3>' . $pdf_document['name'] . '</h3>'. $pdf_document['tooltip'] . '
                                    </span>
                                </span>
                            </td>
                            <td class="col-value">
                                <span>
                                    <a href="' . $pdf[$pdf_document_key] . '?download=true' . '" data-href="ignore" title="speichern"><div class="pdf_icon"></div> speichern</a>
                                    <a href="' . $pdf[$pdf_document_key] . '" data-href="ignore" target="popup" onclick="window.open(this.href, \'popup\', \'width=990,height=700,scrollbars=yes,toolbar=no,status=no,resizable=yes,menubar=no,location=no,directories=no,top=10,left=10\');return false;" title="ansehen"><div class="pdf_icon"></div> ansehen</a>
                                </span>
                            </td>
                        </tr>';

                }

            }

            if($pdf_exists) {

                $html .= '<h3>Vertragsinformationen</h3>
                        <table class="tariffdetails">
                        <tbody>' . $pdf_html;
            }

            $html .= '</tbody>
                            </table>';

            return $html;

        }

    }
