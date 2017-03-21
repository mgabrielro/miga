<form method="get" enctype="application/x-www-form-urlencoded" id="resultform" action="<?php $this->output($this->form->get_url()); ?>" autocomplete="off" data-ajax="false">

    <div class="c24-form-element-group">

        <?php
            $this->output($this->form->get_hidden_fields(), false);
        ?>

        <div class="c24-form-error"
            <?php

    if ($this->form->has_error() == true) {
        $this->output('style="display: block"', false);
    }

            ?>>
            <div class="c24-form-error-icon">!</div>
            <div class="c24-form-error-message">
                Bitte beachten Sie die rot markierten Felder!
            </div>
        </div>

        <?php if ($this->form->has_error()): ?>
            <div id="error_flag"></div>
        <?php endif; ?>


            <?php

            $this->output(
                $this->form->generate_zend_icon_radio_list(
                    'c24api_insured_person',
                    'Wen möchten Sie versichern?',
                    array(),
                     '<p>Sie können sich selbst, aber auch Ihren Partner, Ihr Kind oder eine andere Person versichern.</p>'
                    , []
                    , !isset($this->is_input2)
                ),
                false
            );

            $this->output(
                $this->form->generate_zend_select_field(
                    'c24api_profession',
                    'Berufsstand',
                    '<p>Bitte wählen Sie den Berufsstand der zu versichernden Person.
                     Falls sich der Berufsstand bald ändert, wählen Sie bitte den zum Versicherungsbeginn gültigen Berufsstand aus.</p>

                     <strong>Wer kann sich versichern?</strong>
                     <p>Eine private Krankenversicherung können Angestellte mit einem regelmäßigen Jahresbruttogehalt über '
                        . $this->currencyformat($this->price_calc_params['insurance_limit'])
                        . ' (Stand: ' . $this->price_calc_params['year'] . ')
                     sowie Selbstständige, Freiberufler, Studenten, Beamte und Beamtenanwärter unabhängig von ihrem Einkommen abschließen.
                     Bei nicht Erwerbstätigen ist die Versicherbarkeit von der jeweiligen Situation abhängig. Kinder können
                     versichert werden, wenn der Elternteil mit dem höheren Einkommen privat krankenversichert ist oder (mindestens)
                     ein Elternteil Beamter/-anwärter(in) ist.</p>'
                    , []
                    , !isset($this->is_input2)

                )
                , false);

            $this->output(
                $this->form->generate_zend_select_field(
                    'c24api_children_age',
                    'Alter des Kindes',
                    '<p>Bitte geben Sie das Alter des Kindes zum gewünschten Versicherungsbeginn an.</p>'
                    , []
                    , !isset($this->is_input2)
                ),
                false);

            $this->output(
                $this->form->generate_zend_radio_list(
                    'c24api_parent_servant_or_servant_candidate',
                    'Ist ein Elternteil Beamter/-in (oder Anwärter)?',
                    array(),
                    '<p>Ist (mindestens) ein Elternteil Beamter/ -in, kann auch das Kind in einem günstigen Beihilfetarif versichert werden.</p>'
                    , []
                    , !isset($this->is_input2)
                ),
                false
            );

            $this->output(
                $this->form->generate_zend_select_field(
                    'c24api_contribution_carrier',
                    'Beihilfeträger',
                     '<p>Bitte wählen Sie den Beihilfeträger. I.d.R. ist dies der Bund oder das Bundesland.</p>',
                    [],
                    false)
                , false);

            $this->output(
                $this->form->generate_zend_select_field(
                    'c24api_contribution_rate',
                    'Beihilfesatz',
                    '<p>Bitte wählen Sie den Beihilfesatz. Der Beihilfesatz ist der Teil, der durch den
                     Beihilfeträger erstattet wird.</p>',
                    [],
                    false)
                , false);

           if($this->is_android_mobile_device && !isset($this->is_input2)):

                $this->output($this->form->generate_zend_date_android_field(
                    'c24api_birthdate',
                    'Geburtsdatum'
                ), false);

            endif;

            $max_date = new DateTime();
            $this->output($this->form->generate_zend_date_field(
                'c24api_birthdate',
                'Geburtsdatum',
                '<p>Bitte geben Sie das Geburtsdatum der zu versichernden Person ein. Die Beitragshöhe berechnet sich nach dem Alter.</p>',
                [
                    'max' => $max_date->format('Y-m-d'),
                    'placeholder' => 'TT.MM.JJJJ'
                ]
                , []
                , !isset($this->is_input2)
            ), false);

            if (!isset($this->is_input2)) {
                echo "<div><h1 id='form_header_insurend'>Wo sind die Eltern privat versichert?</h1></div>";
            }

            $this->output(
                $this->form->generate_zend_select_field(
                    'c24api_parent1_insured',
                    'Elternteil 1',
                    '<p>Nicht alle Versicherer versichern Kinder alleine; die Versicherung der Eltern nimmt aber immer auch die Kinder mit auf. Durch Ihre Angabe hier erweitern Sie daher die Auswahl möglicher Tarife.</p>'
                    , []
                    , !isset($this->is_input2)
                ),
                false);

            $this->output(
                $this->form->generate_zend_select_field(
                    'c24api_parent2_insured',
                    'Elternteil 2',
                    '<p>Nicht alle Versicherer versichern Kinder alleine; die Versicherung der Eltern nimmt aber immer auch die Kinder mit auf. Durch Ihre Angabe hier erweitern Sie daher die Auswahl möglicher Tarife.</p>'
                    , []
                    , !isset($this->is_input2)
                ),
                false);
             
            $this->output(
                $this->form->generate_zend_icon_radio_list(
                         'c24api_hospitalization_accommodation',
                         'Krankenhausleistungen (mind.)',
                          [],
                         '<div class="c24-checktipp-wrapper">
                            <span class="c24-checktipp-info">i</span><span class="c24-checktipp-header">CHECK24-Tipp:</span>
                            <p class="c24-checktipp-text"></p>
                          </div>
                          <p>Ohne eine gesonderte Vereinbarung ist im Krankenhaus wie in der gesetzlichen Versicherung ein Mehrbettzimmer Standard. Zahlreiche Tarife sehen aber die Unterbringung im Ein- oder Zweibettzimmer vor. Wichtiger als die Zimmerart sind die damit verbundenen Wahlleistungen, d.h. die Behandlung durch ausgewiesene Spezialisten bzw. den Chefarzt.</p>
                          '
                         , []
                         , isset($this->is_input2)
                         ),
                     false
                );

            /**
             * In 4th parameter set not class-attribute, rather this set value of description for show additional description
             */
            $this->output(
                 $this->form->generate_zend_radio_list(
                         'c24api_dental',
                         'Zahnleistungen',
                         [],
                         '<div class="c24-checktipp-wrapper">
                            <span class="c24-checktipp-info">i</span><span class="c24-checktipp-header">CHECK24-Tipp:</span>
                            <p class="c24-checktipp-text"></p>
                          </div>
                          <p>Zahnleistungen sind unterteilt in Leistungen für Zahnbehandlungen (z.B. Kunststoff-Füllungen) und Zahnersatz (z.B. Kronen, Brücken, Implantate). Die Erstattungsleistungen der Tarife lassen sich in drei Gruppen einteilen: </p>
                          <p><strong>Basis:</strong> Erstattung Zahnbehandlung unter 80% und Zahnersatz unter 60% </p>
                          <p><strong>Komfort:</strong> Erstattung Zahnbehandlung zu mind. 80% und Zahnersatz zu mind. 60%</p>
                          <p><strong>Premium:</strong> Erstattung Zahnbehandlung zu mind. 90% und Zahnersatz zu mind. 75%. Keine dauerhaften Summenbegrenzungen im Zahnbereich.</p>
                          '
                     , [ 'description' => [ 'basic' => 'Zahnbehandl. < 80%</br> Zahnersatz < 60%', 'comfort' => 'Zahnbehandl. > 80%</br>Zahnersatz > 60%' , 'premium' => 'Zahnbehandl. > 90%</br>Zahnersatz > 75%']]
                     , isset($this->is_input2)
                     ),
                     false
                );

            $description = array(
                'description' => array(
                    \classes\calculation\client\model\parameter\pkv::CHILDREN_COSTSHARING_AMOUNT_BASIC   => 'Sehr hohe </br>Beiträge',
                    \classes\calculation\client\model\parameter\pkv::CHILDREN_COSTSHARING_AMOUNT_COMFORT   => 'Ausgewogenes </br>Verhältnis',
                    \classes\calculation\client\model\parameter\pkv::CHILDREN_COSTSHARING_AMOUNT_PREMIUM  => 'Netto oft zu viel </br>gezahlt'
            ));

            $data = $this->form->get_data();

            if ($data['c24api_insured_person'] == \classes\calculation\client\model\parameter\pkv::INSURED_PERSON_CHILD &&
                $data['c24api_parent_servant_or_servant_candidate'] == 'no') {
                $description['description'][\classes\calculation\client\model\parameter\pkv::CHILDREN_COSTSHARING_AMOUNT_BASIC] = 'Geringe <br/>Selbstbeteiligung';
            }

            /**
             * In 4th parameter set not class-attribute, rather this set value of description for show additional description
             */
            $this->output(
                     $this->form->generate_zend_radio_list(
                         'c24api_provision_costsharing_limit',
                         'Selbstbeteiligung',
                         [],
                         '<div class="c24-checktipp-wrapper">
                            <span class="c24-checktipp-info">i</span><span class="c24-checktipp-header">CHECK24-Tipp:</span>
                            <p class="c24-checktipp-text"></p>
                         </div>
                         <p>Der monatliche Beitrag wird sehr viel günstiger, wenn der Versicherte Arztrechnungen bis zu einem bestimmten Betrag pro Jahr „als Selbstbeteiligung“ selbst zahlt. Angestellte sollten jedoch keine zu hohe Selbstbeteiligung wählen, da der Arbeitgeber die Hälfte des Beitrags, nicht aber die Selbstbeteiligung übernimmt.</p>',
                         $description,
                         isset($this->is_input2) && $this->form->get_state()->checkProvisionCostsharingLimitVisibility()
                     ),
                     false
            );

            ?>

        <div class="loading_spinner">
            <input type="submit" name="c24_calculate" id="c24-button-plain-blue"  value="jetzt vergleichen" class="c24-button-plain-blue" data-role="none" />
        </div>



        <?php if (!isset($this->is_input2)) : ?>

            <div class="c24-input1-info-text">
                Tarife entsprechend den CHECK24-Empfehlungen anzeigen.
            </div>

            <div class="c24-hr-with-text">
                <span>oder</span>
            </div>

            <input type="submit" name="c24_change_options"  value="Suche verfeinern" class="c24-button-plain-grey" data-role="none" />

            <div class="c24-input1-info-text">
                Passen Sie den Versicherungsumfang Ihrem persönlichen Bedarf an.
            </div>

        <?php endif; ?>

        <?php if($this->has_special_action): ?>
        <img class="c24-special-action-ribbon" src="/massets/images/action_ribbon_input1.svg" />
        <?php endif; ?>
    </div>

</form>
