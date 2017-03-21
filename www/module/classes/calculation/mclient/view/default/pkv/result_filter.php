<div class="c24-content">

    <div class="c24-content-box c24-result-filter c24-result-filter-top">

        <form method="get" enctype="application/x-www-form-urlencoded" id="resultform" action="<?php $this->output($this->form->get_url()); ?>" data-ajax="false" autocomplete="off">

            <div class="c24-form-element-group" style="position:relative;">

                <?php
                $this->output($this->form->get_hidden_fields(), false);
                ?>

                <h2>Krankenhausleistungen (mind.)</h2>

                <?php

                $this->output(
                    $this->form->generate_zend_icon_radio_list(
                        'c24api_hospitalization_accommodation',
                        '',
                        [],
                        '<div class="c24-checktipp-wrapper">
                            <span class="c24-checktipp-info">i</span><span class="c24-checktipp-header">CHECK24-Tipp:</span>
                            <p class="c24-checktipp-text"></p>
                          </div>
                          <p>Ohne eine gesonderte Vereinbarung ist im Krankenhaus wie in der gesetzlichen Versicherung ein Mehrbettzimmer Standard. Zahlreiche Tarife sehen aber die Unterbringung im Ein- oder Zweibettzimmer vor. Wichtiger als die Zimmerart sind die damit verbundenen Wahlleistungen, d.h. die Behandlung durch ausgewiesene Spezialisten bzw. den Chefarzt.</p>
                          '
                        , []
                    ),
                    false
                );

                $this->output(
                    $this->form->generate_zend_checkbox_field(
                        'c24api_treatment_above_maximum_rate',
                        'Stationäre Leistung über Höchstsatz (3,5-fach)',
                        'yes',
                        'Ärzte rechnen ihre Behandlung auf Grundlage einer Gebührenordnung ab. Falls ein Arzt für eine Leistung mehr als das 3,5-Fache abrechnet als in der Gebührenordnung vorgesehen, geht er über den Höchstsatz hinaus. Oft verlangen Chefärzte oder Spezialisten solch hohe Honorare. Einige Versicherer erstatten die Kosten selbst dann.')
                    , false);
                ?>

                <hr/>

                <h2>Zahnleistungen</h2>

                <?php
                /**
                 * In 4th parameter set not class-attribute, rather this set value of description for show additional description
                 */
                $this->output(
                    $this->form->generate_zend_radio_list(
                        'c24api_dental',
                        '',
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
                    ),
                    false
                );

                $this->output(
                    $this->form->generate_zend_checkbox_field(
                        'c24api_dental_no_maximum_refund',
                        'Keine dauerhafte Begrenzung von Zahnleistungen',
                        'yes',
                        'Bei den meisten Tarifen ist die Erstattung von Zahnleistungen in den ersten Versicherungsjahren auf einen Maximalbetrag pro Jahr begrenzt. Bei Tarifen, die keine dauerhafte Begrenzung vorsehen, entfällt diese Höchstsumme nach einigen Jahren. Der Versicherer zahlt dann Zahnleistungen unbegrenzt, maximal jedoch bis zum vereinbarten Erstattungssatz, s. Basis-, Komfort und Premium-Leistungen.'
                    )
                    , false);
                ?>

                <hr/>

                <h2>Allgemeine Tarifbestimmungen</h2>

                <?php

                $this->output($this->form->generate_zend_select_field(
                    'c24api_provision_costsharing_limit',
                    'Selbstbeteiligung',
                    '<div class="c24-checktipp-wrapper">
                        <span class="c24-checktipp-info">i</span><span class="c24-checktipp-header">CHECK24-Tipp:</span>
                        <p class="c24-checktipp-text"></p>
                    </div>
                    <p>
                       Der monatliche Beitrag wird sehr viel günstiger, wenn der Versicherte Arztrechnungen bis zu einem bestimmten Betrag pro Jahr
                        „als Selbstbeteiligung“ selbst zahlt. Angestellte sollten jedoch keine zu hohe Selbstbeteiligung wählen, da der Arbeitgeber die Hälfte des Beitrags,
                         nicht aber die Selbstbeteiligung übernimmt.
                    </p>',
                    [],
                    $this->form->get_state()->checkProvisionCostsharingLimitVisibility()
                ), false);

                $this->output(
                    $this->form->generate_zend_checkbox_field(
                        'c24api_provision_contribution_reimbursement',
                        'Garantierte Beitragsrückerstattung',
                        'yes',
                        'Wenn Sie in einem Jahr keine Rechnungen bei der Versicherung einreichen, erhalten Sie einen Teil der Beiträge zurück. Wird die Rückerstattung in den Bedingungen garantiert, zahlt Ihnen die Versicherung den vereinbarten Beitrag auf jeden Fall zurück – unabhängig vom Geschäftsergebnis.'
                    )
                    , false);

                $this->output(
                    $this->form->generate_zend_checkbox_field(
                        'c24api_provision_healthy_lifestyle_bonus',
                        'Bonus für gesunden Lebensstil',
                        'yes',
                        'Manche Tarife belohnen einen gesunden Lebensstil. Wer etwa nicht raucht, regelmäßig zum Sport geht, ein Normalgewicht hält und Blutwerte im Normbereich hat, erhält einen Teil der Beiträge zurück.'
                    )
                    , false);

                $this->output($this->form->generate_zend_select_field(
                    'c24api_insure_date',
                    'Versicherungsbeginn',
                    '<p>
                        Wann soll Ihre private Krankenversicherung beginnen? Je nach Art der Vorversicherung muss unter Umständen eine Kündigungsfrist eingehalten werden. In manchen Fällen ist auch eine Rückdatierung des Vertrags möglich. Unsere Experten beraten Sie hierzu gerne.
                    </p>'
                ), false);
                ?>

                <hr/>

                <h2>Ambulante Leistungen</h2>

                <?php

                $this->output(
                    $this->form->generate_zend_checkbox_field(
                        'c24api_amed_non_med_practitioner_reimbursement',
                        'Heilpraktiker',
                        'yes',
                        'Heilpraktikerleistungen gehören zur Alternativmedizin. Hierzu zählen etwa Therapien der Homöopathie, Osteopathie oder Akkupunktur. Bei manchen Tarifen wird ein Teil der Kosten für solche Behandlungen übernommen.'
                    )
                    , false);

                $this->output(
                    $this->form->generate_zend_checkbox_field(
                        'c24api_direct_medical_consultation_benefit',
                        'Freie Arztwahl - direkte Facharzt-Behandlung',
                        'yes',
                        'Bei Tarifen mit freier Arztwahl erstattet der Versicherer die vollen Arztkosten, wenn Sie direkt einen Facharzt aufsuchen. Bei Hausarzt- oder Primärarzttarifen werden die vollen Kosten hingegen nur dann erstattet, wenn Sie zuerst zu Ihrem Hausarzt gehen und dieser Sie an einen Facharzt überweist. Einige Fachärzte sind von dieser Verpflichtung meist ausgenommen – etwa Augenärzte, Kinderärzte oder Gynäkologen.'
                    )
                    , false);

                $this->output(
                    $this->form->generate_zend_checkbox_field(
                        'c24api_med_above_statutory_maximum_rate',
                        'Arzthonorare über Höchstsatz (3,5-fach)',
                        'yes',
                        'Ärzte rechnen ihre Behandlung auf Grundlage einer Gebührenordnung ab. Falls ein Arzt für eine Leistung mehr als das 3,5-Fache abrechnet als in der Gebührenordnung vorgesehen, geht er über den Höchstsatz hinaus. Einige Versicherer erstatten die Kosten selbst dann.'
                    )
                    , false);

                ?>

                <?php if ($this->form->get_state()->checkPdhospitalVisibility()): ?>

                    <hr/>

                    <h2>Krankentagegeld</h2>
                <?php

                endif;

                $this->output($this->form->generate_zend_select_field(
                    'c24api_pdhospital_payout_amount_value',
                    '',
                    '<p>
                        Wer länger krank ist und nicht arbeiten kann, verliert seinen Lohn. Es gibt zwar eine gesetzliche Lohnfortzahlung für Arbeitnehmer,
                        doch diese läuft nach 42 Tagen aus. Selbstständige und Freiberufler sind vom ersten Tag an betroffen. Eine Krankentagegeld-Versicherung
                        kann den Einkommensverlust ausgleichen. Das Krankentagegeld sollte sich daher am Nettoeinkommen orientieren und auch die Sozialversicherungsbeiträge abdecken.
                        Der vereinbarte Tagessatz bezieht sich auf die gesamte Woche (Mo. bis So.).
                    </p>',
                    [],
                    $this->form->get_state()->checkPdhospitalVisibility()
                ), false);

                $this->output($this->form->generate_zend_select_field(
                    'c24api_pdhospital_payout_start',
                    '',
                    '<p>
                        Wer länger krank ist und nicht arbeiten kann, verliert seinen Lohn. Arbeitnehmer sind die ersten 42 Tage durch
                        die gesetzliche Lohnfortzahlung abgesichert. Sie sollten daher den 43. Krankheitstag wählen. Für Selbstständige
                        und Freiberufler gilt die gesetzliche Lohnfortzahlung jedoch nicht. Sie müssen abwägen: Versichern sie sich
                        ab dem ersten Krankheitstag, werden die Beiträge sehr teuer. Wählen sie einen späteren Zeitpunkt, sollten
                        sie genügend Ersparnisse aufbauen, um den Lohnausfall überbrücken zu können.
                    </p>',
                    [],
                    $this->form->get_state()->checkPdhospitalVisibility()
                ), false);
               
                if ($this->form->get_state()->checkCureAndRehabVisibility()): ?>

                    <hr/>

                    <h2>Kurleistungen</h2>

                <?php

                endif;

                $this->output(
                    $this->form->generate_zend_checkbox_field(
                        'c24api_cure_and_rehab',
                        'Kur- und Reha-Leistungen',
                        'yes',
                        '<p>
                             Die Beihilfe erstattet bei Kuren und Reha-Maßnahmen in der Regel nur einen Teil der Kosten. Für Unterkunft und Verpflegung müssen Sie meist selbst aufkommen. Bei manchen Tarifen wird jedoch ein Teil dieser Kosten übernommen.
                         </p>',
                        [],
                        $this->form->get_state()->checkCureAndRehabVisibility()
                    )
                    , false);

                ?>

                <div id="js-c24-result-filter-buttons-container">
                    <div id="js-c24-result-filter-buttons">
                        <div id="c24-result-filter-padder">
                            <?php
                                $this->output('<a class="c24-button-plain-blue c24-button-online" id="resultform_filter_submit_btn" href="#">neu berechnen</a>', false);
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

