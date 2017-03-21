<?php

namespace classes\calculation\client\controller\pkv;

/**
 * Controller for the pkv compare page
 *
 * @author Robert Eichholtz <robert.eichholtz@check24.de>
 */
class compare extends \classes\calculation\client\controller\pv\compare
{
    /**
     * Get product id
     *
     * @return integer
     */
    public function get_product_id() {
        return 11;
    }

    /**
     * comparison sections block
     *
     * @var array
     */
    protected $sections =
    [
        '' => [
            [
                'title'  => 'CHECK24 Tarifnote',
                'help'   => 'Die Tarifnote hilft Ihnen bei der Auswahl eines Tarifes. Zur Berechnung der Note werden die wichtigsten Leistungen eines Tarifes bewertet.',
                'type'   => 'tariff_note'
            ],
            [
                'title'  => 'Kundenbewertung',
                'help'   => 'Alle Kunden, die über CHECK24 ihre Risikolebensversicherung abgeschlossen haben, können Ihren gewählten Versicherer vier Wochen nach Versicherungsbeginn bewerten.',
                'type'   => 'customer_feedback'
            ],
        ],
        'Informationen zum Versicherer' =>
        [
            [
                'title'  => 'Finanzielle Stabilität des Versicherers',
                'help'   => 'Es gibt eine große Anzahl an Anbietern auf dem Versicherungsmarkt. Eine kurze Übersicht
                             der finanziellen Lage des ausgewählten Versicherers kann Ihnen bei der Tarifauswahl helfen.',
                'type'   => 'icon_text',
                'method' => 'get_insurer_financial_stability',
                'mapping'=> [
                    'excellent'      => 'Sehr gut',
                    'very_good'      => 'Gut',
                    'low'            => 'Gering',
                    'no'             => 'Keine',
                    'excellent_icon' => 'OK',
                    'very_good_icon' => 'OK',
                    'low_icon'       => 'NotOK',
                    'no_icon'        => 'NotOK'
                ]
            ],
            [
                'title' => 'Marktanteil des Versicherers',
                'help'  => 'Wir haben die Marktanteile der verschiedenen Versicherer im Bereich
                            Risikolebensversicherungen analysiert. Hier sehen Sie wie gut sich die verschiedenen
                            Anbieter auf dem Markt positionieren.',
                'type'  => 'text',
                'method' => 'get_insurer_market_share',
                'mapping'=> [
                    'market_leader_pkv' => 'Marktführer Risikoleben',
                    'top_three_pkv'     => 'Top 3 Risikoleben',
                    'top_ten_pkv'       => 'Top 10 Risikoleben',
                    'no_information'    => 'keine Information vorhanden'
                ]
            ],
            [
                'title' => 'Beschwerdequote',
                'help'  => 'Eine niedrige Beschwerdequote besagt, dass der Versicherer selten die Leistung verweigert.
                            Anderseits zeigt eine hohe Beschwerdequote, dass es Auseinandersetzungen zwischen Anbieter
                            und Kunde geben kann.',
                'type'  => 'text',
                'method' => 'get_complaints_rate',
                'mapping'=> [
                    'very_low'    => 'Sehr niedrig',
                    'low'         => 'Niedrig',
                    'normal'      => 'Normal',
                    'high'        => 'Hoch',
                    'very_high'   => 'Sehr hoch'
                ]
            ]
        ],
        'Leistungsdetails' =>
        [
            [
                'title' => 'Leistung bei Todesfall',
                'help'  => 'Auszahlung der vereinbarten Versicherungssumme im Todesfall der versicherten Person.',
                'type'  => 'text',
                'method' => 'get_performance_in_case_of_death',
                'mapping'=> [
                    'death'             => 'Auszahlung im Todesfall',
                    'death_by_accident' => 'Auszahlung nur bei Tod durch Unfall'
                ]
            ],
            [
                'title' => 'Leistung bei Tod im Ausland',
                'help'  => 'Die meisten Versicherer zahlen auch wenn der Ernstfall im Ausland eintritt.
                            Viele Versicherer setzen jedoch bei einem längeren Auslandsaufenthalt besondere Regelungen
                            an. Hier sehen Sie, welche Versicherung wann zahlen.',
                'type'  => 'icon',
                'icon_default' => 'yes',
                'method' => 'get_performance_in_case_of_death_abroad'
            ],
            [
                'title' => 'Sofortiger Versicherungsschutz',
                'help'  => 'Vom Antrag bis zum Vertragsabschluss bedarf es einer kurzen Bearbeitungszeit.
                            Bis dahin liefert Ihnen die Versicherung einen sofortigen Versicherungsschutz.',
                'type'  => 'text',
                'method' => 'get_preliminary_insurance_cover',
                'mapping'=> [
                    'no'                  => 'nein',
                    'receipt_at_check24'  => 'ab Antragseingang bei Check24',
                    'receipt_at_insurers' => 'ab Antragseingang bei Versicherer'
                ]
            ],
            [
                'title' => 'Verlauf der Versicherungssumme',
                'help'  => 'Es gibt konstante und fallende Versicherungssummen. Eine konstante Versicherungssumme dient
                            der Familienabsicherung, während eine fallende Versicherungssumme zur Kreditabsicherung
                            gedacht ist.',
                'type'  => 'icon_text',
                'method' => 'get_insured_sum_history',
                'mapping'=> [
                    'constant_over_run_time' => 'konstant über Laufzeit',
                    'linear_over_run_time' => 'linear abfallend über Laufzeit',
                    'after_tilgungsverlauf_sloping' => 'nach Tilgungsverlauf abfallend'
                ]
            ]
        ],
        'Wichtige Tarifvoraussetzungen' =>
        [
            [
                'title' => 'Besondere Tarifvoraussetzungen',
                'help'  => 'Viele Versicherer setzten für einige ihre Tarife gewisse Voraussetzungen,
                            die vom Kunden erfüllt werden müssen.',
                'type'  => 'text',
                'method' => 'get_special_tariff_conditions'
            ],
            [
                'title' => 'Voraussetzungen „Staatsangehörigkeit“',
                'help'  => 'Wenn Sie einen Antrag stellen, müssen Sie Ihre Staatsangehörigkeit angeben. In fast allen
                            Fällen reicht eine EU-Staatsangehörigkeit aus, um eine Risikolebensversicherung abzuschließen.',
                'type'  => 'text',
                'method' => 'get_nationality'
            ],
            [
                'title' => 'Voraussetzungen „Wohnsitz“',
                'help'  => 'Wenn Sie einen Antrag stellen, müssen Sie Ihren Wohnsitz angeben. In einigen Fällen reicht
                            es aus, wenn Sie Ihren Wohnsitz innerhalb der EU haben. Viele Versicherer verlangen jedoch,
                            dass sich Ihr Erstwohnsitz in Deutschland (oder Österreich) befindet.',
                'type'  => 'text',
                'method' => 'get_residence'
            ],
            [
                'title' => 'Nichtraucherdefinition',
                'help'  => 'Für die Mehrheit der Versicherer bezieht sich die Raucherfrage auf die letzten 12 Monate.
                            Bei einigen Tarifen wird die Nichtraucherdefinition jedoch auf 3 oder sogar 10 Jahre erweitert.
                            Für Raucher werden höhere Beiträge berechnet und gewisse Tarife können nur Nichtraucher
                            abschließen (Siehe „Besondere Tarifvoraussetzungen“).',
                'type'  => 'text',
                'method' => 'get_non_smoker_comment'
            ]
        ],
        'Beitragsdetails' =>
        [
            [
                'title' => 'Überschussbeteiligung/maximal möglicher Zahlbeitrag',
                'help'  => 'In den meisten Angeboten wird ein Brutto- und ein Netto-Prämie ausgewiesen. Dieser
                            Unterschied kommt zustande, da der Versicherer die Kunden an den erwirtschafteten
                            Überschüssen beteiligt. Die Netto-Prämie ist der derzeit gültige Zahlbeitrag für Ihre
                            Risikolebensversicherung. Die Brutto-Prämie ist der maximal mögliche Beitrag, wenn die
                            Überschussbeteiligung reduziert werden muss.
                            <br><br>
                            Damit Ihre Prämie auch in vielen Jahren noch bezahlbar bleibt, ist es wichtig, ein
                            finanzstarkes Unternehmen zu wählen, das Ihnen auch in Zukunft noch hohe Überschüsse
                            gutschreiben kann.',
                'type'  => 'percent',
                'method' => 'get_profit_participation_maximum_of_contribution'
            ],
            [
                'title' => 'Stabile Überschussbeteiligung in den letzten 10 Jahren?',
                'help'  => 'Wenn Sie bei einem Versicherungsunternehmen einen Lebensversicherungsvertrag führen,
                            erhalten Sie erwirtschaftete Überschüsse in Form von Beitragsreduzierung. Hier sehen
                            Sie welche Versicherer Überschussbeteiligungen mit einbeziehen und wie stabil diese sind.',
                'type'  => 'icon',
                'method' => 'get_stable_profit_participation_last_ten_years'
            ],
            [
                'title' => 'Beitragsverlauf über Laufzeit',
                'help'  => 'Der Beitragsverlauf kann konstant oder wechselnd sein. Bei wechselndem Beitrag wird
                            hier entsprechend dem tatsächlichem Risiko kalkuliert. Der Tarifbeitrag ist zu Beginn
                            niedrig, steigt aber mit zunehmendem Alter (und dem damit verbundenem höheren Risiko).',
                'type'  => 'text',
                'method' => 'get_contribution_history_of_run_time',
                'mapping'=> [
                    'constant'                       => 'konstant',
                    'low_start_contribution'         => 'niedriger Startbeitrag',
                    'yearly_changeable_contribution' => 'jährlich wechselnder Beitrag'
                ]
            ]
        ],
        'Zusatzleistungen' =>
        [
            [
                'title' => 'Dynamik',
                'help'  => 'Eine Risikolebensversicherung wird allgemein über einen längeren Zeitraum abgeschlossen.
                            Um zu verhindern, dass die Inflation während der Laufzeit den Versicherungsschutz auffrisst,
                            kann ein regelmäßiger Anstieg der Versicherungssumme vereinbart werden.',
                'type'  => 'dynamic_range',
                'no_dynamic' => 'keine Dynamik möglich'
            ],
            [
                'title' => 'Erhöhungsoption',
                'help'  => 'Manche Tarife bieten die Möglichkeit, bei gewissen Ereignissen (z.B. Hochzeit, Geburt oder
                            Immobilienerwerb) die Versicherungssumme zu erhöhen.',
                'type'  => 'text',
                'method' => 'get_increase_option',
                'mapping'=> [
                    'no'    => 'nein',
                    'included_in_contribution'  => 'ja, im Beitrag enthalten',
                    'possible_against_surcharge'  => 'ja, gegen Aufpreis möglich'
                ]
            ],
            [
                'title' => 'Easy Start Option',
                'help'  => 'Mit der Easy-Start-Option ist es möglich, die Risikolebensversicherung auch mit einer
                            Beitragsstaffel abzuschließen, um individuelle Kundenbedürfnisse zu berücksichtigen.',
                'type'  => 'icon',
                'method' => 'get_easy_start_option'
            ],
            [
                'title' => 'Verlängerungsoption',
                'help'  => 'Manche Versicherungen bieten die Möglichkeit den Versicherungsschutz nach dem
                            Vertragsabschluss noch einmal zu verlängern. So können Sie unvorhergesehene Ereignisse
                            eventuell nachträglich abdecken.',
                'type'  => 'text',
                'method' => 'get_extension_option',
                'mapping'=> [
                    'no'    => 'nein',
                    'included_in_contribution'  => 'ja, im Beitrag enthalten',
                    'possible_against_surcharge'  => 'ja, gegen Aufpreis möglich'
                ]
            ],
            [
                'title' => 'Vorgezogene Todesfallleistung',
                'help'  => 'Bei manchen Lebensversicherern können Sie (meist gegen Aufpreis) eine sogenannte „vorgezogene
                            Todesfallleistung“ vereinbaren. Das bedeutet, dass die Versicherungssumme vorzeitig, noch zu
                            Lebzeiten ausbezahlt wird, z.B. wenn eine schwere Krankheit mit einer kurzen verbleibenden
                            Lebenserwartung (oft 12 Monate) diagnostiziert wird.',
                'type'  => 'text',
                'method' => 'get_early_death_benefit',
                'mapping'=> [
                    'no'    => 'nein',
                    'included_in_contribution'  => 'ja, im Beitrag enthalten',
                    'possible_against_surcharge'  => 'ja, gegen Aufpreis möglich'
                ]
            ],
            [
                'title' => 'Zusatzoption: Übernahme der Beiträge bei Erwerbsunfähigkeit',
                'help'  => 'Im Fall einer Erwerbsunfähigkeit (und dem damit verbundenen schwankendem Einkommen) wird die
                            Hauptversicherung (Risikolebensversicherung) beitragsfrei gestellt, d.h. die Versicherung zahlt die
                            Beiträge über die Laufzeit hinweg weiter und Ihre Risikolebensversicherung wird nicht gefährdet.',
                'type'  => 'text',
                'method' => 'get_takeover_contributions_to_disability',
                'mapping'=> [
                    'no'    => 'nein',
                    'included_in_contribution'  => 'ja, im Beitrag enthalten',
                    'possible_against_surcharge'  => 'ja, gegen Aufpreis möglich'
                ]
            ],
            [
                'title' => 'Zusatzoption: Übernahme der Beiträge bei Berufsunfähigkeit',
                'help'  => 'Im Fall einer Berufsunfähigkeit (und dem damit verbundenen schwankendem Einkommen)  wird die
                            Hauptversicherung (Risikolebensversicherung) beitragsfrei gestellt, d.h. die Versicherung zahlt die
                            Beiträge über die Laufzeit hinweg weiter und Ihre Risikolebensversicherung wird nicht gefährdet.',
                'type'  => 'text',
                'method' => 'get_takeover_contributions_on_occupational_disability',
                'mapping'=> [
                    'no'    => 'nein',
                    'included_in_contribution'  => 'ja, im Beitrag enthalten',
                    'possible_against_surcharge'  => 'ja, gegen Aufpreis möglich'
                ]
            ]
        ],
        'Informationen zur Risikoprüfung durch Versicherer' =>
        [
            [
                'title' => 'Annahmequote durch Versicherer',
                'help'  => 'Eine hohe Annahmequote besagt, dass der Versicherer nur wenig Anträge ablehnt.
                            Anderseits zeigt eine schlechte Annahmequote, dass der Versicherer strenger auf z.B.
                            gesundheitliche Risiken reagiert.',
                'type'  => 'text',
                'method' => 'get_acceptance_rate_by_insurer',
                'mapping'=> [
                    'low'      => 'niedrig',
                    'average'  => 'durchschnittlich',
                    'high'     => 'hoch'
                ]
            ],
            [
                'title' => 'Gesundheitsfragen (Selbstauskunft)',
                'help'  => 'Um einen Antrag für eine Risikolebensversicherung zu stellen, ist die Beantwortung von
                            Gesundheitsfragen notwendig. Die Anzahl der Gesundheitsfragen variiert je nach
                            Versicherungsgesellschaft.',
                'type'  => 'text',
                'method' => 'get_health_issues_self_disclosure_by_customer',
                'mapping'=> [
                    'yes'     => 'notwendig',
                    'no'      => 'nicht notwendig'
                ]
            ],
            [
                'title'  => 'Zusätzliche Gesundheitsprüfung',
                'help'   => 'Die Gesundheitsprüfung verläuft je nach Tarifauswahl unterschiedlich. Einige Versicherer
                            verlangen, dass die Gesundheitsprüfung z.B. ab einer gewissen Versicherungssumme durch einen
                            Hausarzt erfolgt.',
                'type'   => 'additional_medical_examination',
                'mapping'=> [
                    'no'                  => 'nein',
                    'yes'                 => 'ja',
                    'family_doctor'       => 'ja, durch Hausarzt',
                    'by_medical_service'  => 'ja, durch medizinischen Dienst'
                ]
            ],
            [
                'title'  => 'Kostenübernahme der Gesundheitsprüfung',
                'help'   => 'Einige Versicherer übernehmen für geforderte Untersuchungen gänzlich oder teilweise die Kosten.',
                'type'   => 'icon',
                'method' => 'get_reimbursement_of_health_examination'
            ],
            [
                'title'  => 'Zeitraum auf den sich die Gesundheitsprüfung bezieht',
                'help'   => 'Die Gesundheitsfragen beziehen sich je nach Tarif auf einen unterschiedlich langen Zeitraum.',
                'type'   => 'text',
                'method' => 'get_health_examination_period'
            ],
            [
                'title'  => 'Nachmeldepflicht Gefahrenerhöhung',
                'help'   => 'Einige Versicherer wollen Informiert werden, wenn sich der Ihr Gesundheitsstatus seit der
                             Risikoprüfung verändert hat (z.B. Änderung des Raucherstatus).',
                'type'   => 'text',
                'method' => 'get_increase_of_risk'
            ],
            [
                'title'  => 'Tarifwechsel Nichtrauchertarif',
                'help'   => 'Bei manchen Versicherern gibt es die Möglichkeit, nachträglich einen Nichtrauchertarif
                             anzufragen, z.B. wenn die Nichtraucherdefinition (siehe oben) verspätet erfüllt wird.',
                'type'   => 'icon_text',
                'method' => 'get_tariff_to_non_smoking_tariff',
                'mapping'=> [
                    'no'                             => 'nein',
                    'remedical_examination'          => 'ja, erneute Gesundheitsprüfung',
                    'without_remedical_examination'  => 'ja, ohne neue Gesundheitsprüfung'
                ]
            ],
            [
                'title'  => 'Motorradfahrer (regulärer Straßenverkehr)',
                'help_title' => 'Freizeitrisiken',
                'help'   => 'Je nach Tarif können unterschiedliche Freizeitrisiken zu Aufschlägen bzw. zum Ausschluss der
                             Versicherung führen. Hier sehen Sie, welche gefährlichen Hobbys welchen Einfluss auf den
                             Beitrag haben.',
                'type'   => 'leisure_risks',
                'key'    => 'get_motorcyclist_regular_road',
                'default' => 'Risikoaufschlag'
            ],
            [
                'title'  => 'Bergsport',
                'help_title' => 'Freizeitrisiken',
                'help'   => 'Je nach Tarif können unterschiedliche Freizeitrisiken zu Aufschlägen bzw. zum Ausschluss der
                             Versicherung führen. Hier sehen Sie, welche gefährlichen Hobbys welchen Einfluss auf den
                             Beitrag haben.',
                'type'   => 'leisure_risks',
                'key'    => 'get_mountain_sport',
                'default' => 'Risikoaufschlag'
            ],
            [
                'title'  => 'Flugsport',
                'help_title' => 'Freizeitrisiken',
                'help'   => 'Je nach Tarif können unterschiedliche Freizeitrisiken zu Aufschlägen bzw. zum Ausschluss der
                             Versicherung führen. Hier sehen Sie, welche gefährlichen Hobbys welchen Einfluss auf den
                             Beitrag haben.',
                'type'   => 'leisure_risks',
                'key'    => 'get_air_sport',
                'default' => 'Risikoaufschlag'
            ],
            [
                'title'  => 'Tauchsport',
                'help_title' => 'Freizeitrisiken',
                'help'   => 'Je nach Tarif können unterschiedliche Freizeitrisiken zu Aufschlägen bzw. zum Ausschluss der
                             Versicherung führen. Hier sehen Sie, welche gefährlichen Hobbys welchen Einfluss auf den
                             Beitrag haben.',
                'type'   => 'leisure_risks',
                'key'    => 'get_diving_sport',
                'default' => 'Risikoaufschlag'
            ]
        ],
        'Vertragsinformationen' =>
        [
            'description' => 'Hier können Sie sich zu jedem Tarif die Bedingungen herunterladen.',
            [
                'title' => 'Bedingungen',
                'help'  => 'In den Versicherungsbedingungen werden alle relevanten Informationen über den
                            Versicherungstarif detailliert ausgeführt, unter anderem die genauen Leistungen der
                            gewählten Versicherung und die versicherten Bereiche. Die Versicherungsbedingungen der
                            einzelnen Tarife können hier im PDF-Format heruntergeladen werden.',
                'type'  => 'attachments',
                'method' => 'get_tariff_attachments'
            ],
            [
                'title' => 'Mindestauftragslaufzeit / Kündigungsmöglichkeit des Versicherungsvertrags',
                'help'  => '',
                'type'  => 'text',
                'method' => 'get_contract_cancellation'
            ],
            [
                'title' => 'Widerspruchsfrist nach Vertragsannahme',
                'help'  => 'Nach Eingang der Versicherungspolice haben Sie einen gesetzlichen Anspruch die
                            Versicherung innerhalb von 30 Tagen zu widerrufen- Manche Anbieter bieten Ihnen eine
                            längere Widerspruchsfrist an.',
                'type'  => 'text',
                'method' => 'get_objection_of_a_contract'
            ]
        ]
    ];
}