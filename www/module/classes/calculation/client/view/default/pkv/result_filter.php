<div class="c24-content">

    <div class="c24-content-box c24-result-filter c24-result-filter-top">

        <form method="get" enctype="application/x-www-form-urlencoded" id="resultform" action="<?php $this->output($this->form->get_url()); ?>" data-ajax="false" autocomplete="off">

            <div class="c24-form-element-group" style="position:relative;">

                <?php
                $this->output($this->form->get_hidden_fields(), false);
                ?>

                <h2>Zahlbetrag optimieren</h2>

                <?php

                $this->output(
                    $this->form->generate_zend_select_field(
                        'c24api_paymentperiod',
                        'Zahlungsweise',
                        'Sie können zwischen monatlicher, vierteljährlicher, halbjährlicher und jährlicher Zahlungsweise
                         wählen. Bei jährlicher Zahlweise gibt es teilweise Rabatte auf den Beitrag.')
                    , false);

                $this->output($this->form->generate_zend_tel_field(
                    'c24api_insure_sum',
                    'Versicherungssumme (in €)',
                    '<p>Wählen Sie die Summe, die im Todesfall ausbezahlt wird.</p>',
                    [
                        'hint' => '<p id="insure_sum_constant_tooltip" style="display: none">
                                        Stiftung Warentest empfiehlt eine Absicherung in Höhe Ihres drei- bis fünffachen Bruttojahreseinkommens.
                                    </p>
                                    <p id="insure_sum_falling_tooltip" style="display: none">
                                        Die Summe sollte der Höhe des Kredits entsprechen. Verbraucherschützer empfehlen eine zusätzliche
                                        Familienabsicherung in Höhe Ihres zweifachen Bruttojahreseinkommens.
                                    </p>'
                    ]
                ), false);

                $this->output($this->form->generate_zend_tel_field(
                    'c24api_insure_period',
                    'Laufzeit',
                    '',
                    [
                        'unit' => 'Jahre',
                        'condition_hints' => [
                            'constant' => '<h3 class="iBox24Title">Welche Laufzeit soll ich wählen?</h3>
                                           <p>Wählen Sie den Zeitraum ausreichend lang, um die Hinterbliebenen abzusichern. Bei Familienabsicherung z.B. so lang bis alle Kinder selbst für sich sorgen können.</p>
                                           <h3 class="iBox24Tipp">Tipp:</h3>
                                           <p>Wählen Sie im Zweifel eine längere Laufzeit. Sie können den Vertrag monatlich kündigen oder beitragsfrei stellen. Eine Verlängerung des bestehenden Vertrags ist meist nicht möglich.</p>',
                            'falling' => '<h3 class="iBox24Title">Welche Laufzeit soll ich wählen?</h3>
                                          <p>Wählen Sie den Zeitraum ausreichend lang, um die vollständige Restzahlung des Kredits zu jedem Zeitpunkt der Kreditlaufzeit abzusichern.</p>
                                          <h3 class="iBox24Tipp">Tipp:</h3>
                                          <p>Wählen Sie im Zweifel eine längere Laufzeit. Sie können den Vertrag monatlich kündigen oder beitragsfrei stellen. Eine Verlängerung des bestehenden Vertrags ist meist nicht möglich.</p>'
                        ],
                        'maxlength' => '2'
                    ]
                ), false);

                ?>

                <p style="margin-bottom: 1em;">Auch Tarife anzeigen mit ...</p>
                <div class="filter_constant">
                    <?php
                    $this->output(
                        $this->form->generate_zend_checkbox_field(
                            'c24api_increasing_contribution',
                            'jährlich ansteigenden Beiträgen',
                            'yes',
                            'Der Betrag wird hier entsprechend dem tatsächlichen Risiko kalkuliert. Der Tarifbeitrag zu
                            Beginn ist niedrig, steigt aber mit zunehmendem Alter (und dem damit verbundenen höheren
                            Risiko).')
                        , false);

                    $this->output(
                        $this->form->generate_zend_checkbox_field(
                            'c24api_children_discount',
                            'Rabatt für „Kinder im gleichen Haushalt“',
                            'yes',
                            'Versicherer geben teilweise Rabatte, falls Kinder unter 18 Jahren in Ihrem Haushalt
                            (identischer Wohnsitz) wohnen.')
                        , false);

                    ?>
                </div>

                <div class="filter_falling">
                    <?php
                    $this->output(
                        $this->form->generate_zend_checkbox_field(
                            'c24api_constant_contribution',
                            'jährlich konstanten Beiträgen',
                            'yes',
                            'Bei einem konstanten Beitrag wird über die gesamte Versicherungsdauer derselbe Tarifbeitrag
                            kalkuliert. Dieser ergibt sich durch eine Mischkalkulation aus den verschiedenen Risiken
                            der einzelnen Jahre.')
                        , false);
                    ?>
                </div>

                <div class="filter_constant">

                    <h2>Zusatzleistungen</h2>

                    <?php
                    $this->output(
                        $this->form->generate_zend_checkbox_field(
                            'c24api_insure_sum_increase_allowed',
                            'Versicherungssumme nachträglich erhöhen',
                            'yes',
                            'In manchen Fällen, wie z.B. einer Hochzeit oder der Geburt eines Kindes, kann es nützlich sein
                        die Versicherungssumme zu erhöhen. Mit dieser Leistung kann die Erhöhung dann ohne weitere
                        Gesundheitsprüfung erfolgen.')
                        , false);

                    $this->output(
                        $this->form->generate_zend_checkbox_field(
                            'c24api_runtime_increase_allowed',
                            'Laufzeit nachträglich verlängern“',
                            'yes',
                            'In der Regel ist die Vertragsverlängerung nur nach einer Gesundheitsprüfung möglich. Mit
                        dieser Leistung bekommen Sie die Möglichkeit Ihren Vertrag ohne Gesundheitsprüfung zu
                        verlängern.')
                        , false);

                    ?>
                </div>

                <div id="js-c24-result-filter-buttons-container">
                    <div id="js-c24-result-filter-buttons">
                        <div id="c24-result-filter-padder">
                            <?php
                            $this->output('<a class="c24-button-plain-blue c24-button-online" href="#" onClick="javascript: $(\'#resultform\').submit();" style="display: inline-block;">neu berechnen</a>', false);
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<div data-role="popup" id="popupFilterConfirmation" data-overlay-theme="c24" data-theme="c24" data-dismissible="false" style="max-width:400px;">
    <div data-role="header" data-theme="c24">
    <h1>Filtereinstellungen</h1>
</div>
    <div role="main" class="ui-content">
        <h3 class="ui-title">Möchten Sie die Filtereinstellungen übernehmen?</h3>
        <a href="#" class="ui-btn ui-corner-all ui-btn-inline ui-btn-c24" id="confirm_filter_btn" >Ja</a>
        <a href="#" class="ui-btn ui-corner-all ui-btn-inline ui-btn-c24" id="discard_filter_btn" data-transition="flow">Nein</a>
    </div>
</div>

