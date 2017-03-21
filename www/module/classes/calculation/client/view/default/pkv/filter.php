<div id="input-container" class="c24-container-12">
    <form method="get" enctype="application/x-www-form-urlencoded" id="resultform" action="/pkv/vergleichsergebnis/" autocomplete="off" >
    <div class="c24-filter-container">
        <div class="c24-form-element-group">

            <?php $this->output($this->form->get_hidden_fields(), false); ?>

            <div class="div24Section">
                <?php echo $this->render('pkv/special_action_badge.phtml'); ?>

                <h2 id="c24-error-headline" class="c24-error-headline">Bitte beachten Sie die Fehlermeldungen in den unten rot markierten Bereichen.</h2>


                <h1>Gewünschte Absicherung</h1>

                <div class="c24-er-element js-c24-er-element">
                    <div class="c24-label-div"></div>
                    <div class="c24-form-ele-wrapper clearfix c24-content-row-info-content">
                        <div class="c24-fe-radio-div">
                            <div class="c24-insurance-radios-title">
                                <div style="width: 50%; height:20px;"><i class="fa fa-check c24-icon-green"></i> Ideal zur Familienabsicherung</div>
                                <div style="width: 50%; height:20px;"><i class="fa fa-check c24-icon-green"></i> Ideal zur Kreditabsicherung</div>
                            </div>
                        </div>
                    </div>
                </div>


                <?php

    $this->output(
            $this->form->generate_zend_radio_field(
                'c24api_protectiontype',
                'Art der Absicherung?',
                ['constant' => 'Konstant', 'falling' => 'Linear fallend'],
                '<h3 class="iBox24Title">Was soll ich auswählen?</h3>
                    <p>Sie können zwischen zwei Vertragsarten wählen:</p>
                    <p><strong>Konstant:</strong> Stirbt die Person, deren Tod versichert werden soll, während der Laufzeit, wird die
                        volle Versicherungssumme ausgezahlt.</p>
                    <p><strong>Linear fallend:</strong> Der ausgezahlte Betrag sinkt gleichmäßig über die Laufzeit. Stirbt die Person,
                    deren Tod versichert werden soll, z.B. nach 40 % der Laufzeit (bei einer Laufzeit von 10 Jahren etwa im 5. Jahr),
                    werden 60 % der Versicherungssumme ausgezahlt. Eignet sich vor allem zur Absicherung von Ratenkrediten.</p>
                    '
            ),
            false
        );


    $this->output($this->form->generate_zend_text_field(
        'c24api_insure_sum',
        'Höhe der Versicherungssumme',
        '',
        [
            'type' => 'tel', // tel is correct, because "number" is being formatted by browser automatically (thousands separator)
            'unit' => '€',
            'maxlength' => '9',
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
    ), false);


    $this->output($this->form->generate_zend_tel_field(
        'c24api_insure_period',
        'Laufzeit des Vertrages',
        '',
        [
            'type' => 'tel',
            'unit' => 'Jahre',
            'condition_hints' => [
                'constant' => '<h3 class="iBox24Title">Welche Laufzeit soll ich wählen?</h3>
                               <p>Wählen Sie den Zeitraum ausreichend lang, um Ihre Hinterbliebenen abzusichern. Bei einer Familienabsicherung sollte der Vertrag z.B. so lange laufen, bis alle Kinder selbst für sich sorgen können.</p>
                               <h3 class="iBox24Tipp">Tipp:</h3>
                               <p>Wählen Sie im Zweifel eine längere Laufzeit. Sie können den Vertrag zum Ende eines Zahlungszeitraums (z.B. monatlich) kündigen oder beitragsfrei stellen. Eine Verlängerung des Vertrags ist hingegen meist nicht möglich.</p>',
                'falling' => '<h3 class="iBox24Title">Welche Laufzeit soll ich wählen?</h3>
                               <p>Wählen Sie den Zeitraum ausreichend lang, um die vollständige Restzahlung des Kredits zu jedem Zeitpunkt der Kreditlaufzeit abzusichern.</p>
                               <h3 class="iBox24Tipp">Tipp:</h3>
                               <p>Wählen Sie im Zweifel eine längere Laufzeit. Sie können den Vertrag Vertrag zum Ende eines Zahlungszeitraums (z.B. monatlich) kündigen oder beitragsfrei stellen. Eine Verlängerung des Vertrags ist nicht möglich.</p>'
            ],
            'maxlength' => '2'
        ]
    ), false);

    ?>
            </div>
        </div>

        <div class="c24-form-element-group no-top-border">
            <div class="div24Section">
                <h1>Persönliche Angaben</h1>
                <?php

                $c24api_default_birthdate = '01.01.1970';
                $this->output($this->form->generate_zend_date_field(
                    'c24api_birthdate',
                    'Geburtsdatum',
                    '<h3 class="iBox24Title">Warum fragen wir nach dem Geburtsdatum?</h3>
                        <p>Geben Sie hier das Geburtsdatum der Person an, deren Tod versichert werden soll.
                        Das Alter benötigen wir, um den individuellen Beitrag zu berechnen.</p>',
                        [
                            'data-default-date' => $c24api_default_birthdate,
                            'placeholder' => 'TT.MM.JJJJ',
                            'maxlength' => '10'
                        ]
                ), false);


                $this->output($this->form->generate_zend_radio_field(
                    'c24api_smoker',
                    'Raucher (letzte 12 Monate)',
                    ['yes' => 'ja', 'no' => 'nein'],
                    '<h3 class="iBox24Title">Warum fragen wir nach dem Raucherstatus?</h3>
                        <p>Geben Sie an, ob die Person, deren Tod versichert werden soll, in den letzten zwölf Monaten geraucht hat.
                        Diese Angabe benötigen wir, um den individuellen Beitrag zu berechnen.</p>
                        <h3 class="iBox24Tipp">Tipp:</h3>
                        <p>Auch Gelegenheitsraucher müssen hier „Ja“ wählen. Jede Art von Nikotinkonsum
                        (z.B. Zigaretten, E-Zigaretten, Kautabak) in den letzten zwölf Monaten gilt für die Versicherung
                        als Rauchen. Beantworten Sie die Frage wahrheitsgemäß, um Ihren Versicherungsschutz nicht zu gefährden.</p>
                    '),
                    false);


            $this->output(
                $this->form->generate_zend_text_field(
                    'c24api_occupation_name',
                    'Ausgeübter Beruf',
                    '<h3 class="iBox24Title">Warum fragen wir nach dem Beruf?</h3>
                    <p>Der aktuell ausgeübte Beruf der Person, deren Tod versichert werden soll, ist wichtig für die Berechnung
                     Ihres individuellen Beitrags.</p>
                    <h3 class="iBox24Tipp">Tipp:</h3>
                    <p>Geben Sie die ersten Buchstaben der Berufsbezeichnung ein und treffen Sie dann eine Auswahl aus den vorgeschlagenen Berufen.</p>',
                    [
                        'data-type' => 'search',
                        'class' => 'js_autocomplete',
                        'autocomplete' => 'off',
                        'placeholder' => 'Beruf eintippen und auswählen',
                        'autocomplete_id' => 'occupation-result',
                    ]
                ),
                false
            );

            ?>
            </div>
        </div>

        <div class="c24-form-element-group no-top-border">
            <div class="div24Section last c24-flex">
                <div id="c24-special-action-ribbon-container" class="c24-flex-inner-div">
                    <?php $this->output($this->special_action_ribbon()->render_ribbon(), false); ?>
                </div>
                <div class="c24-bottom-button-container">
                    <input type="button" tabindex="<?php echo $this->form->get_auto_tabindex_counter(true); ?>" id="c24_form_submit" class="c24-button js-c24-form-submit" value="Ergebnisse anzeigen »" name="c24_form_submit">
                </div>
            </div>
        </div>
    </div>
</form>
</div>

<?php if($this->special_action->is_active()): ?>
    <div class="specialaction-disclaimer">* für ausgewählte Tarife im Vergleich</div>
<?php endif;?>

<?php echo $this->render('common/trust_box.phtml') ?>
<?php echo $this->render('default/pkv/result_spinner.phtml') ?>



<script type="text/javascript">

    // jQuery Mobile HACK
    // this bind is needed to reload the page on browser-back in mobile devices
    if (window.deviceoutput != "desktop") {
        $(window).bind("pageshow", function (event) {
            if (event.originalEvent.persisted) {
                document.location.reload();
            }
        });
    }

   $(document).ready(function(){

       $input1_js = new c24.check24.input1.load('?c24_controller=ajax%2Fjson&action=occupation_name');

       $("#c24api_protectiontype_constant").closest(".c24-form-ele-wrapper").click();

       /* Local and global COOKIE storage */
       var ignore_insure_sum = <?php echo isset($this->parameters['c24api_insure_sum']) ? 'true' : 'false' ?>;

       $input1_js.init_storages(ignore_insure_sum, 'resultform');

   });

</script>
