<div id="scroll_header"></div>

<div id="result_sidebar">
    <div id="result_filter_sidebar" class="c24-cnt-ele">
        <form method="get" enctype="application/x-www-form-urlencoded" id="resultform" action="<?php $this->output($this->form->get_url()); ?>" data-ajax="false" autocomplete="off">
            <?php echo $this->form->get_hidden_fields(); ?>

            <div class="tablet-filtergroup">
                <h3>Versicherungsschutz anpassen</h3>

                <?php

                    echo $this->form->generate_zend_text_field(
                        'c24api_insure_sum',
                        'Versicherungssumme',
                        '<h3 class="iBox24Title">Höhe der Versicherungssumme</h3>
                         <p>Wählen Sie die Summe, die im Todesfall ausbezahlt wird.</p>',
                        [
                            'unit' => '€',
                            'size' => '12',
                            'condition_hints' => [
                                'constant' => '<h3 class="iBox24Title">Welche Höhe soll ich wählen?</h3>
                                                                <p>Wählen Sie eine Summe, die ausreichend hoch ist, um die Hinterbliebenen abzusichern.</p>
                                                                <h3 class="iBox24Tipp">Tipp:</h3>
                                                                <p>Stiftung Warentest empfiehlt eine Absicherung in Höhe Ihres drei- bis fünffachen Bruttojahreseinkommens.</p>',
                                'falling' => '<h3 class="iBox24Title">Welche Höhe soll ich wählen?</h3>
                                                                <p>Wählen Sie eine Summe, die ausreichend hoch ist, damit die Hinterbliebenen den Kredit inklusive aller Raten und Zinsen zurückbezahlen können.</p>
                                                                <h3 class="iBox24Tipp">Tipp:</h3>
                                                                <p>Verbraucherschützer empfehlen eine zusätzliche Familienabsicherung in Höhe Ihres zweifachen Bruttojahreseinkommens.</p>'
                            ]
                        ]
                    );

                    echo $this->form->generate_zend_text_field(
                        'c24api_insure_period',
                        'Laufzeit',
                        '',
                        [
                            'unit' => 'Jahre',
                            'condition_hints' => [
                                'constant' => '<h3 class="iBox24Title">Welche Laufzeit soll ich wählen?</h3>
                                                <p>Wählen Sie den Zeitraum ausreichend lang, um Ihre Hinterbliebenen abzusichern. Bei einer Familienabsicherung sollte der Vertrag z.B. so lange laufen, bis alle Kinder selbst für sich sorgen können.</p>
                                                <h3 class="iBox24Tipp">Tipp:</h3>
                                                <p>Wählen Sie im Zweifel eine längere Laufzeit. Sie können den Vertrag zum Ende eines Zahlungszeitraums (z.B. monatlich) kündigen oder beitragsfrei stellen. Eine Verlängerung des Vertrags ist hingegen meist nicht möglich.</p>',
                                'falling'  => '<h3 class="iBox24Title">Welche Laufzeit soll ich wählen?</h3>
                                                <p>Wählen Sie den Zeitraum ausreichend lang, um die vollständige Restzahlung des Kredits zu jedem Zeitpunkt der Kreditlaufzeit abzusichern.</p>
                                                <h3 class="iBox24Tipp">Tipp:</h3>
                                                <p>Wählen Sie im Zweifel eine längere Laufzeit. Sie können den Vertrag Vertrag zum Ende eines Zahlungszeitraums (z.B. monatlich) kündigen oder beitragsfrei stellen. Eine Verlängerung des Vertrags ist nicht möglich.</p>'
                            ]
                        ]
                    );

                ?>
                <div class="border-dotted">&nbsp;</div>
            </div>
            <div class="tablet-filtergroup">
                <h3>Zahlbetrag optimieren</h3>
                <?php echo $this->form->generate_zend_select_field(
                                'c24api_paymentperiod',
                                'Zahlungsweise',
                                '<h3 class="iBox24Title">Zahlungsweise</h3>
                                 <p>Sie können zwischen monatlicher, vierteljährlicher, halbjährlicher und jährlicher
                                    Zahlungsweise wählen. Bei jährlicher Zahlweise gibt es teilweise Rabatte auf den Beitrag.</p>'
                            )

                ?>

                <p class="c24-label">Auch Tarife anzeigen mit ...</p>
                    <?php
                        echo $this->form->generate_zend_checkbox_field(
                                'c24api_increasing_contribution',
                                'jährlich ansteigenden Beiträgen',
                                'yes',
                                '<h3 class="iBox24Title">Tarife mit jährlich steigenden Beiträgen</h3>
                                 <p>Der Betrag wird hier entsprechend dem tatsächlichen Risiko kalkuliert. Der Tarifbeitrag zu
                                 Beginn ist niedrig, steigt aber mit zunehmendem Alter (und dem damit verbundenen höheren Risiko).</p>'
                        );

                        echo $this->form->generate_zend_checkbox_field(
                                'c24api_children_discount',
                                'Rabatt für „Kinder im gleichen Haushalt“',
                                'yes',
                                '<h3 class="iBox24Title">Tarife mit Kinderrabatt im Haushalt</h3>
                                 <p>Versicherer geben teilweise Rabatte, falls Kinder unter 18 Jahren in Ihrem Haushalt
                                 (identischer Wohnsitz) wohnen.</p>'
                        );
                    ?>

                    <?php echo $this->form->generate_zend_checkbox_field(
                                    'c24api_constant_contribution',
                                    'jährlich konstanten Beiträgen',
                                    'yes',
                                    '<h3 class="iBox24Title">Tarife mit konstantem Beitrag</h3>
                                    <p>Bei einem konstanten Beitrag wird über die gesamte Versicherungsdauer der selbe
                                    Tarifbeitrag kalkuliert. Dieser ergibt sich durch eine Mischkalkulation aus den
                                    verschiedenen Risiken der einzelnen Jahre.</p>'
                    );
                    ?>

                <div class="border-dotted">&nbsp;</div>
            </div>

            <div class="tablet-filtergroup">
                <div id="tarif-extras">
                    <h3>Zusatzleistungen</h3>

                    <?php
                        echo $this->form->generate_zend_checkbox_field(
                                'c24api_insure_sum_increase_allowed',
                                'Versicherungssumme nachträglich erhöhen',
                                'yes',
                                '<h3 class="iBox24Title">Versicherungssumme nachträglich erhöhen</h3>
                                 <p>In manchen Fällen, wie z.B. einer Hochzeit oder der Geburt eines Kindes, kann es nützlich
                                  sein die Versicherungssumme zu erhöhen. Mit dieser Leistung kann die Erhöhung dann ohne weitere
                                  Gesundheitsprüfung erfolgen.</p>'
                            );

                        echo $this->form->generate_zend_checkbox_field(
                                'c24api_runtime_increase_allowed',
                                'Laufzeit nachträglich verlängern',
                                'yes',
                                '<h3 class="iBox24Title">Laufzeit nachträglich verlängern</h3>
                                 <p>In der Regel ist die Vertragsverlängerung nur nach einer Gesundheitsprüfung möglich.
                                  Mit dieser Leistung bekommen Sie die Möglichkeit Ihren Vertrag ohne Gesundheitsprüfung
                                  zu verlängern.</p>'
                            );

                    ?>
                </div>

                <?php if($this->backdating->is_available()):?>
                    <div class="border-dotted">&nbsp;</div>

                    <div class="backdatingInput">
                        <h3>Sparpotential</h3>

                        <?php echo $this->form->generate_zend_checkbox_field(
                            'c24api_allow_backdating',
                            'Versicherungsbeginn rückdatieren',
                            'yes'
                            );
                        ?>

                        <div class="c24-tooltip backdatingInput-tooltip" data-trigger="click" data-direction="right" data-direction-overwrite='{"tabletapp" : "left"}'>
                            <div class="backdatingInput-tooltipLink">Warum zahlen Sie weniger?</div>
                            <div class="c24-tooltip-content">
                                <div class="c24-tooltip-arrow up"></div>
                                <div class="c24-tooltip-close"></div>
                                <h3>Versicherungsbeginn rückdatieren</h3>
                                <p>
                                    Bei der Kalkulation des Beitrags hat das Eintrittsalter der versicherten Person einen großen Einfluss.
                                    Je jünger die Person, desto weniger Beitrag muss bezahlt werden.
                                </p>
                                <p>
                                    Durch den früheren Versicherungsbeginn sinkt das Eintrittsalter der versicherten Person und der Beitrag fällt.
                                </p>
                                <p>
                                    Ihr aktueller <b>Versicherungsbeginn</b> wäre der
                                    <b><?php echo $this->backdating->get_insure_date()->format('d.m.Y'); ?></b>
                                </p>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
                <a id="trigger_calculation" href="#" class="c24-button">Neu berechnen</a>
            </div>

        </form>

    </div>

    <div id="result_badges" class="c24-cnt-ele">
        <a data-fancybox href="#customer_king">
            <img src="/assets/images/styleguide/kunde-ist-koenig_164x104.png" alt="Best-zins garantie Logo">
        </a>
        <a data-fancybox href="#best_zins">
            <img src="/assets/images/styleguide/best_preis_240x104.png" alt="Best-zins garantie Logo">
        </a>
        <div style="display:none">
            <div id="best_zins" class="best_zins">
                <img src="/assets/images/styleguide/best_preis_240x104.png" alt="Best-zins garantie Logo" class="siegel">
                <h1>Die CHECK24-Best-Preis-Garantie</h1>
                <p class="bold">
                    Günstiger geht es nicht
                </p>
                <p>
                    Wir möchten Ihnen immer den günstigsten Beitrag für Ihre Risikolebensversicherung anbieten.
                    Und wir sind davon überzeugt, Ihnen diesen mit unseren Angeboten bieten zu können.
                    Daher bieten wir Ihnen gerne unsere CHECK24-Best-Preis-Garantie an:
                </p>
                <p>
                    Sollten Sie nach Abschluss einer Risikolebensversicherung über CHECK24 bei einem anderen Vermittler
                    tatsächlich einen günstigeren Preis erhalten, erstatten wir Ihnen die Beitragsdifferenz des ersten
                    Vertragsjahres, maximal jedoch 250 Euro.
                </p>
                <p><i>Unsere Garantiebedingungen:</i></p>
                <ul class="best_zins-list">
                    <li class="checkmark green_checkmark">
                        Das günstigere Angebot muss verbindlich und absolut identisch mit dem von uns vermittelten Vertrag sein.
                    </li>
                    <li class="checkmark green_checkmark">
                        Das Konkurrenzangebot wurde nicht später als 30 Tage nach Abschluss des von uns vermittelten Vertrags erstellt.
                    </li>
                    <li class="checkmark green_checkmark">
                        Ausgenommen von der Garantie sind Gruppenverträge und Sonderkonditionen.
                    </li>
                    <li class="checkmark green_checkmark">
                        Gültig für Versicherungssummen von 10.000 bis 500.000 Euro und einer Laufzeit von 5 bis 30 Jahren.
                    </li>
                </ul>
                <p>
                    Wenn Sie ein günstigeres Angebot außerhalb des Risikolebensversicherungsvergleiches von CHECK24.de
                    verbindlich angeboten bekommen haben, dann senden Sie bitte den vollständigen Antrag des Versicherers
                    an die unten stehende Anschrift. Bitte vergessen Sie nicht, Ihre Bankverbindung anzugeben, damit wir
                    Ihnen den Differenzbetrag überweisen können. Wir werden Ihre Unterlagen prüfen und uns dann so
                    schnell wie möglich bei Ihnen melden.
                </p>
                <p class="best_zins-imprint">
                    CHECK24<br>
                    Vergleichsportal für Versicherungsprodukte GmbH<br>
                    Risiko & Vorsorge – Best-Preis Garantie<br>
                    80251 München
                </p>
                <div style="clear:both"></div>
            </div>
        </div>
        <div id="customer_king" style="display:none;max-width: 500px;min-width:300px;font-size: 12px;">
            <h3>Wir machen Sie zum König – garantiert!</h3>
            <p><b>Transparenz:</b><p>
            <ul>
                <li>- Keine versteckten Kosten</li>
                <li>- Keine ungewünschten Leistungen vorbelegt</li>
                <li>- Tarifleistungen transparent dargestellt</li>
            </ul>
            <p><b>Sicherheit:</b><p>
            <ul>
                <li>- Sicherste Datenübertragung & Verschlüsselung</li>
                <li>- Nur interne Datenverwendung</li>
            </ul>

            <p><b>Service:</b><p><img src="/assets/images/form/ui/pkv/kundekonig.png" alt="Best-zins garantie Logo" style="float: right">
            <ul>
                <li>- Kompetente Risikoberater</li>
                <li>- Top-Erreichbarkeit</li>
                <li>- Kurze Antwortzeiten</li>
            </ul>
        </div>
    </div>

    <div id="result_benefits" class="c24-cnt-ele">
        <h2>Check24 Vorteile</h2>
        <ul class="c24-list">
            <li>Kostenlose Beratung</li>
            <li>Exzellenter Service</li>
            <li>Best-Preis Garantie</li>
            <li>10 Mio. zufriedene Kunden</li>
        </ul>
    </div>
      <div id="result_contact" class="c24-cnt-ele">
        <div class="phone">&nbsp;</div>
        <p>Kostenlose Beratung</p>
        <p class="c24-web">
            <b>0800 - 755 455 415</b>
        </p>
        <p>Mo. bis So. 8:00 - 20:00 Uhr</p>
    </div>
</div>
<div id="result_content">
    <?php $this->output($this->special_action_ribbon()->render_container(), false); ?>
    <div class="result_compare_link">
        <a data-compare-link="<?php echo $this->compare_link; ?>" class="c24-button">Hier ausgewählte Tarife vergleichen (max. 3)</a>
    </div>
    <div class="result_sort_bar">
        <ul>
            <li class="result_filter_price">
                <a class="result_sort_link" data-sort="price">
                    Beitrag
                    <div class="result_sort_arrows"></div>
                </a>
            </li>
            <li class="result_filter_provider">
                <a class="result_sort_link" data-sort="provider">
                    Tarif
                    <div class="result_sort_arrows"></div>
                </a>
            </li>
            <li class="result_filter_tariffgrade">
                <a class="result_sort_link"  data-sort="tariffgrade">
                    Note
                    <div class="result_sort_arrows"></div>
                </a>
            </li>
            <li>
                Weitere Informationen
            </li>
        </ul>
    </div>
    <?php
        if (isset($this->result_content)) {
            echo $this->result_content;
        }
    ?>
</div>

<?php echo $this->render('default/pkv/result_spinner.phtml') ?>

<script>
    $(document).ready(function () {

        <?php if(!isset($this->deviceoutput) || 'tabletapp' != $this->deviceoutput): ?>
            c24.check24.result.layout.init();
        <?php endif; ?>

        c24.check24.result.init_storages('resultform');
        c24.check24.result.init_storages('tariff_compare');

        c24.check24.result.load();
    });
</script>
