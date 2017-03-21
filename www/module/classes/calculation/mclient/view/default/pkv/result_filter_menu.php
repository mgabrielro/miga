<div class="c24-content">

    <div class="c24-result-filter c24-result-filter-left">

        <form method="get" enctype="application/x-www-form-urlencoded" id="resultform" action="<?php $this->output($this->form->get_url()); ?>" autocomplete="off">

            <?php
                $this->output($this->form->get_hidden_fields(), false);
            ?>

            <div class="c24-result-filter-headline">Filter und Neuberechnung</div>

            <div class="c24-result-filter-inner c24-clearfix">

                <table class="c24-result-filter-table">

                    <tbody>

                        <tr>
                            <th colspan="3">Tarife neu berechnen</th>
                        </tr>

                        <tr>
                            <td class="c24-result-filter-cell1 c24-result-filter-line">
                                <?php
                                     $this->output($this->form->generate_label('c24api_zipcode', 'PLZ', array('for' => 'c24api_zipcode')), false);
                                ?>
                            </td>
                            <td class="c24-result-filter-cell2 c24-result-filter-line">
                                <?php
                                    $this->output($this->form->generate_tel_field('c24api_zipcode', array('size' => 5, 'maxlength' => 5, 'id' => 'c24api_zipcode', 'style' => 'width: 113px;')), false);
                                ?>
                            </td>
                            <td class="c24-result-filter-cell3 c24-result-filter-line">
                                <?php
                                    $this->output($this->generate_helpclick('Postleitzahl', 'Die Postleitzahl, an der in Zukunft der Strom bezogen werden soll.'), false);
                                ?>
                            </td>
                        </tr>

                    </tbody>

                    <tbody id="c24api_city_container" style="<?php $this->output(count($this->form->get_options('c24api_city')) > 2 ? '' : 'display: none', true); ?>">

                        <tr>
                            <td class="c24-result-filter-cell1">
                                <?php
                                     $this->output($this->form->generate_label('c24api_city', 'Ort', array('for' => 'c24api_city', 'id' => 'c24api_city_label')), false);
                                ?>
                            </td>
                            <td class="c24-result-filter-cell2">
                                <?php
                                    $this->output($this->form->generate_select_field('c24api_city', array('id' => 'c24api_city', 'style' => 'width: 119px;')), false);
                                ?>
                            </td>
                            <td class="c24-result-filter-cell3"><!-- --></td>
                        </tr>

                    </tbody>

                    <tbody>

                        <tr>
                            <td class="c24-result-filter-cell1">
                                <?php
                                    $this->output($this->form->generate_label('c24api_totalconsumption', 'Verbrauch', array('for' => 'c24api_totalconsumption')), false);
                                ?>
                            </td>
                            <td class="c24-result-filter-cell2">
                                <?php
                                    $this->output($this->form->generate_number_field('c24api_totalconsumption', array('id' => 'c24api_totalconsumption', 'style' => 'width: 113px;')), false);
                                ?>
                            </td>
                            <td class="c24-result-filter-cell3">
                                <?php
                                    $this->output($this->generate_helpclick('Stromverbrauch', 'Wie viel Strom Sie im Jahr verbrauchen. Verwenden Sie dazu einfach Ihre letzte Jahresrechnung Ihres bisherigen Stromanbieters. Sollten Sie Ihren persönlichen Stromverbrauch nicht kennen, können Sie sich an die angezeigten Richtwerte halten:<br /><br />Single ca. 2.000 kWh/Jahr<br />Paar ca. 3.500 kWh/Jahr<br />Familie ca. 5.000 kWh/Jahr<br />Familie Einfamilienhaus ca. 8.000 kWh/Jahr', false), false);
                                ?>
                            </td>
                        </tr>

                    </tbody>

                    <tbody>

                        <tr>
                            <td class="c24-result-filter-cell1">
                                <?php
                                    $this->output($this->form->generate_label('c24api_contractperiod', 'Laufzeit', array('for' => 'c24api_contractperiod')), false);
                                ?>
                            </td>
                            <td class="c24-result-filter-cell2">
                                <?php
                                    $this->output($this->form->generate_select_field('c24api_contractperiod', array('id' => 'c24api_contractperiod', 'style' => 'width: 119px;')), false);
                                ?>
                            </td>
                            <td class="c24-result-filter-cell3">
                                <?php
                                    $this->output($this->generate_helpclick('Vertragslaufzeit', 'Es werden nur Tarife mit der maximalen gewünschten Vertragslaufzeit angezeigt. Je kürzer die Vertragslaufzeit, desto höher ist Ihre Flexibilität, wenn Sie zukünftig erneut wechseln wollen.<br />Verbraucherverbände raten zu einer maximalen Vertragslaufzeit von einem Jahr.', false), false);
                                ?>
                            </td>
                        </tr>

                        <tr>

                            <td class="c24-result-filter-cell1">
                                <?php
                                    $this->output($this->form->generate_label('c24api_paymentperiod', 'Zahlweise', array('for' => 'c24api_paymentperiod')), false);
                                ?>
                            </td>

                            <td class="c24-result-filter-cell2">
                                <?php
                                    $this->output($this->form->generate_select_field('c24api_paymentperiod', array('style' => 'width: 119px;', 'id' => 'c24api_paymentperiod')), false);
                                ?>
                            </td>

                            <td class="c24-result-filter-cell3">
                                <?php
                                    $this->output($this->generate_helpclick('Zahlweise/Abschlagszahlung', 'Alle Stromanbieter fordern Abschlagszahlungen. Je mehr Sie voraus bezahlen (bis zu einer Jahresrechnung), desto günstiger ist der Tarif.<br /><strong>Falle einer Insolvenz des Anbieters ist ihre Vorauszahlung in der Regel verloren.</strong>', false), false);
                                ?>
                            </td>

                        </tr>

                        <tr>

                            <td class="c24-result-filter-cell1">

                                <?php
                                    $this->output($this->form->generate_label('c24api_customertype', 'Nutzung', array('for' => 'c24api_customertype_private')), false);
                                ?>

                            </td>

                            <td class="c24-result-filter-cell2">

                                <?php

                                    $this->output($this->form->generate_radio_field('c24api_customertype', 'private', array('id' => 'c24api_customertype_private')), false);
                                    $this->output('&nbsp;<label for="c24api_customertype_private">privat</label><br />', false);
                                    $this->output($this->form->generate_radio_field('c24api_customertype', 'business', array('id' => 'c24api_customertype_business')), false);
                                    $this->output('&nbsp;<label for="c24api_customertype_business">gewerblich</label>', false);

                                ?>

                            </td>

                            <td class="c24-result-filter-cell3">

                                <?php
                                    $this->output($this->generate_helpclick('Nutzung', 'Nutzen Sie den Strom privat oder als Firma? Als Firma wechseln Sie bitte zu gewerblich.'), false);
                                ?>

                            </td>

                        </tr>

                    </tbody>

                </table>

                <table class="c24-result-filter-table">

                    <tbody>

                        <tr>

                            <td class="c24-result-filter-cell4 c24-result-filter-line">

                                <?php
                                    $this->output($this->form->generate_checkbox_field('c24api_packages', 'yes', array('id' => 'c24api_packages_yes')), false);
                                ?>

                            </td>

                            <td class="c24-result-filter-cell5 c24-result-filter-line">

                                <?php
                                    $this->output($this->form->generate_label('c24api_packages', 'kWh-Pakete und Tarife mit Mehr-/ Minderverbrauchs- aufschlag anzeigen', array('for' => 'c24api_packages_yes'), false), false);
                                ?>

                            </td>

                            <td class="c24-result-filter-cell6 c24-result-filter-line">

                                <?php
                                    $this->output($this->generate_helpclick('kWh-Pakete und Tarife mit Mehr-/Minderverbrauchsaufschlag anzeigen', 'Bei Pakettarifen kaufen Sie eine feste Energiemenge. Sollte Ihr Verbrauch während der Vertragslaufzeit geringer sein, verfallen nicht genutzte Mengen. Mehrverbrauch wird in Rechnung gestellt - in der Regel zu einem höheren Preis als ortsüblich. Bei Tarifen mit Mehr-/Minderverbrauchsaufschlag werden beim Über- bzw. Unterschreiten bestimmter Verbrauchsgrenzen Preisaufschläge fällig. <strong>Sie sollten einen solchen Tarif nur wählen, wenn Sie Ihren Stromverbrauch gut einschätzen können und dieser relativ stabil ist.</strong>', false), false);
                                ?>

                            </td>

                        </tr>

                        <tr>

                            <td class="c24-result-filter-cell4">

                                <?php
                                    $this->output($this->form->generate_checkbox_field('c24api_considerdiscounts', 'yes', array('id' => 'c24api_considerdiscounts_yes')), false);
                                ?>

                            </td>
                            <td class="c24-result-filter-cell5">

                                <?php
                                    $this->output($this->form->generate_label('c24api_considerdiscounts', 'Neukundenbonus berücksichtigen', array('for' => 'c24api_considerdiscounts_yes')), false);
                                ?>

                            </td>
                            <td class="c24-result-filter-cell6">

                                <?php
                                    $this->output($this->generate_helpclick('Neukundenbonus berücksichtigen', 'Viele Anbieter geben im ersten Jahr einen einmaligen Bonus. Wenn Sie dieses Feld nicht abwählen, wird der Neukundenbonus von den Kosten des ersten Jahres abgezogen, da es sich um einen geldwerten Vorteil handelt. Wählen Sie dieses Feld ab, werden einmalige Boni nicht berücksichtigt.'), false);
                                ?>

                            </td>

                        </tr>

                        <tr>

                            <td class="c24-result-filter-cell4">

                                <?php
                                    $this->output($this->form->generate_checkbox_field('c24api_considerdeposit', 'yes', array('id' => 'c24api_considerdeposit_yes')), false);
                                ?>

                            </td>

                            <td class="c24-result-filter-cell5">

                                <?php
                                     $this->output($this->form->generate_label('c24api_considerdeposit', 'Tarife mit Kaution anzeigen', array('for' => 'c24api_considerdeposit_yes')), false);
                                ?>

                            </td>

                            <td class="c24-result-filter-cell6">

                                <?php
                                     $this->output($this->generate_helpclick('Tarife mit Kaution anzeigen', 'Manche Anbieter verlangen zum Vertragsabschluss eine Kaution. Diese wird erst mit Vertragsbeendigung zurückerstattet. Die Kaution ersetzt häufig die Bonitätsprüfung. Im Gegensatz zum Mietvertrag wird die Kaution jedoch nicht verzinst. Daher wird die Kaution auch Sonderabschlag genannt.<br /><strong>Im Falle einer Insolvenz des Anbieters ist die Kaution in der Regel verloren.</strong>', false), false);
                                ?>

                            </td>

                        </tr>

                        <tr>

                            <td class="c24-result-filter-cell4">

                                <?php
                                    $this->output($this->form->generate_checkbox_field('c24api_priceguarantee', 'yes', array('id' => 'c24api_priceguarantee_yes')), false);
                                ?>

                            </td>

                            <td class="c24-result-filter-cell5">

                                <?php
                                    $this->output($this->form->generate_label('c24api_priceguarantee', 'Nur Tarife mit Preisgarantie', array('for' => 'c24api_priceguarantee_yes')), false);
                                ?>

                                <div id="c24api_priceguarantee" style="<?php if ($this->form->get_field_value('c24api_priceguarantee') != 'yes') { $this->output('display: none;'); } ?> padding: 5px 0 0 0;">
                                    <?php
                                        $this->output($this->form->generate_select_field('c24api_priceguarantee_months'), false);
                                    ?>
                                </div>

                            </td>

                            <td class="c24-result-filter-cell6">

                                <?php
                                    $this->output($this->generate_helpclick('Nur Tarife mit Preisgarantie/Preisfixierung', 'Wenn Sie diese Option wählen, garantiert Ihnen der Anbieter zumindest alle Preisbestandteile mit Ausnahme von Steuern und Abgaben. Damit können Sie sich gegen steigende Preise absichern. Die Preisgarantie (beste Garantie) umschließt alle Preisbestandteile, die Preisfixierung umschließt alle Preisbestanteile mit Ausnahme jeglicher Steuern und Abgaben.'), false);
                                ?>

                            </td>

                        </tr>

                        <tr>

                            <td class="c24-result-filter-cell4">

                                <?php
                                    $this->output($this->form->generate_checkbox_field('c24api_eco', 'yes', array('id' => 'c24api_eco_yes', 'onclick' => '$(this).is(\':checked\') == true ? $(\'#eco_type\').show() : $(\'#eco_type\').hide();')), false);
                                ?>

                            </td>

                            <td class="c24-result-filter-cell5">

                                <?php
                                    $this->output($this->form->generate_label('c24api_eco', 'Nur <span class="c24TextEco">Ökostrom</span>-Tarife', array('for' => 'c24api_eco_yes'), false), false);
                                    $this->output(' ' . $this->generate_help('Es werden nur Ökostrom-Tarife angezeigt. Bei diesen Tarifen wird der Strom aus erneuerbaren Energiequellen bzw. Kraft-Wärme-Kopplung produziert oder der Stromlieferant verpflichtet sich, für den CO2-Ausstoß entsprechende Ausgleichsmaßnahmen durchzuführen (Klima-Tarife).', 'Es werden nur Ökostrom-Tarife angezeigt. Bei diesen Tarifen wird der Strom aus erneuerbaren Energiequellen bzw. Kraft-Wärme-Kopplung produziert oder der Stromlieferant verpflichtet sich, für den CO2-Ausstoß entsprechende Ausgleichsmaßnahmen durchzuführen (Klima-Tarife).', $this->get_style('image_eco'), $this->get_style('image_eco_width'), $this->get_style('image_eco_height'), 'c24LayerText'), false);

                                ?>

                                <div id="eco_type" style="padding: 5px 0 0; <?php if ($this->form->get_field_value('c24api_eco') != 'yes') { $this->output('display: none;'); } ?>">

                                    <?php

                                        $this->output($this->form->generate_radio_field('c24api_eco_type', 'normal', array('id' => 'c24api_eco_type_normal')), false);
                                        $this->output('&nbsp;<label for="c24api_eco_type_normal">Basis</label>', false);
                                        $this->output(' ' . $this->form->generate_radio_field('c24api_eco_type', 'sustainable', array('id' => 'c24api_eco_type_sustainable')), false);
                                        $this->output('&nbsp;<label for="c24api_eco_type_sustainable">nachhaltig</label>', false);

                                        $this->output(' ' . $this->generate_helpclick('Nachhaltiger Ökostrom', 'Es werden nur Stromtarife angezeigt, die mit dem OK-Power-Label oder Grüner Strom Label ausgezeichnet sind oder deren Anbieter nachweisen kann, dass er in signifikantem Umfang in lokale Ökostromproduktion investiert.'), false);

                                    ?>

                                </div>

                            </td>

                            <td class="c24-result-filter-cell6">

                                <?php
                                    $this->output($this->generate_helpclick('Nur Ökostrom-Tarife', 'Es werden nur Ökostrom-Tarife angezeigt. Bei diesen Tarifen wird der Strom aus erneuerbaren Energiequellen bzw. Kraft-Wärme-Kopplung produziert oder der Stromlieferant verpflichtet sich, für den CO2-Ausstoß entsprechende Ausgleichsmaßnahmen durchzuführen (Klima-Tarife).'), false);
                                ?>

                            </td>

                        </tr>

                        <tr>

                            <td colspan="3">
                                <a id="c24-more-options" class="<?php $this->output($this->form->get_field_value('c24_show_more_options') == 'yes' ? 'c24-more-options-close': '') ?>">weitere Kriterien</a>
                            </td>

                        </tr>

                    </tbody>

                </table>

                <div id="c24-more-options-container" style="<?php $this->output($this->form->get_field_value('c24_show_more_options') == 'no' ? 'display: none;': '') ?>" class="c24-result-filter-table">

                    <table>

                        <tbody>

                            <tr>
                                <td class="c24-result-filter-cell8">
                                    <?php
                                        $this->output($this->form->generate_label('c24api_cancellationperiod', 'Kündigungsfrist', array('for' => 'c24api_cancellationperiod')), false);
                                    ?>
                                </td>
                                <td class="c24-result-filter-cell8">
                                    <?php
                                        $this->output($this->form->generate_select_field('c24api_cancellationperiod', array('id' => 'c24api_cancellationperiod', 'style' => 'width: 109px;')), false);
                                    ?>
                                </td>
                            </tr>

                            <tr>

                                <td class="c24-result-filter-cell8" style="font-size: 85%;">
                                    <?php
                                        $this->output($this->form->generate_label('c24api_maxtariffs', 'Tarife pro Anbieter', array('for' => 'c24api_maxtariffs')), false);
                                    ?>
                                </td>

                                <td class="c24-result-filter-cell8">
                                    <?php
                                        $this->output($this->form->generate_select_field('c24api_maxtariffs', array('id' => 'c24api_maxtariffs', 'style' => 'width: 109px;')), false);
                                    ?>
                                </td>

                            </tr>

                        </tbody>

                    </table>

                    <table>

                        <tbody>

                            <tr>

                                <td class="c24-result-filter-cell4">
                                    <?php
                                        $this->output($this->form->generate_checkbox_field('c24api_guidelinematch', 'yes', array('id' => 'c24api_guidelinematch_yes')), false);
                                    ?>
                                </td>

                                <td class="c24-result-filter-cell5">
                                    <?php
                                        $this->output($this->form->generate_label('c24api_guidelinematch', 'Nur Tarife anzeigen, die den CHECK24-Richtlinien zum Verbraucherschutz entsprechen', array('for' => 'c24api_guidelinematch_yes')), false);
                                    ?>
                                </td>

                                <td class="c24-result-filter-cell6">
                                    <?php
                                        $this->output($this->generate_helpclick('Verbraucherschutz-Richtlinien von CHECK24', 'Einzelne Tarife erfüllen die Ansprüche an den Verbraucherschutz nicht, die CHECK24 als notwendig ansieht. Wenn diese Option aktiviert ist, werden Ihnen derartige Angebote in der Ergebnisliste nicht angezeigt.'), false);
                                    ?>
                                </td>

                            </tr>

                            <tr>

                                <td class="c24-result-filter-cell4">
                                    <?php
                                        $this->output($this->form->generate_checkbox_field('c24api_secondarytime_active', 'yes', array('id' => 'c24api_secondarytime_active_yes')), false);
                                    ?>
                                </td>

                                <td class="c24-result-filter-cell5">

                                    <?php
                                        $this->output($this->form->generate_label('c24api_secondarytime_active', 'Schwachlast / Doppeltarifzähler', array('for' => 'c24api_secondarytime_active_yes')), false);
                                    ?>

                                    <div id="c24api_secondarytime" style="<?php if ($this->form->get_field_value('c24api_secondarytime_active') != 'yes') { $this->output('display: none;'); } ?> padding: 5px 0 0 0;">
                                        <?php
                                            $this->output($this->form->generate_select_field('c24api_secondarytime', array('style' => 'width: 109px;')), false);
                                        ?>
                                    </div>

                                </td>

                                <td class="c24-result-filter-cell6">
                                    <?php
                                        $this->output($this->generate_helpclick('Schwachlast / Doppeltarifzähler', 'Es werden nur Tarife von Anbietern angezeigt, die auch Doppeltarifzähler beliefern.'), false);
                                    ?>
                                </td>

                            </tr>

                        </tbody>

                    </table>

                </div>

                <?php
                    if ($this->form->field_exists('c24api_reference_provider_hash') && $this->form->field_exists('c24api_reference_tariffversion_key')) {
                ?>

                <table class="c24-result-filter-table">

                    <tr>
                        <th colspan="2" class="c24-result-filter-cell7">Ihr Vergleichstarif</th>
                    </tr>

                    <tr>
                        <td colspan="2" class="c24-result-filter-cell7 c24-result-filter-line">
                            <?php
                                $this->output($this->form->generate_select_field('c24api_reference_provider_hash', array('id' => 'c24api_reference_provider_hash')), false);
                            ?>
                        </td>
                    </tr>

                    <tr>
                        <td colspan="2" class="c24-result-filter-cell7">
                            <?php
                                $this->output($this->form->generate_select_field('c24api_reference_tariffversion_key', array('id' => 'c24api_reference_tariffversion_key')), false);
                            ?>
                        </td>

                    </tr>

                    <tr>
                        <td class="c24-result-filter-cell8">
                            Preis pro Jahr
                        </td>

                        <td class="c24-result-filter-cell9">

                            <?php

                                if (isset($this->json_referencetariff)) {

                                    $price = '';
                                    $pricelayer = '';

                                    if (isset($this->json_referencetariff['tariff_detail'][$this->form->get_field_value('c24api_reference_tariffversion_key')])) {
                                        $price = $this->json_referencetariff['tariff_detail'][$this->form->get_field_value('c24api_reference_tariffversion_key')]['price_euro_german'];
                                        $pricelayer = $this->json_referencetariff['tariff_detail'][$this->form->get_field_value('c24api_reference_tariffversion_key')]['pricelayer'];
                                    }

                                    $this->output('<div id="c24api_reference_price_container">', false);
                                    $this->output('<span class="c24Price" id="c24api_reference_price"><span class="value">' . $this->escape($price) . '</span>&nbsp;<img src="' . $this->escape($this->get_style('image_info')) . '" width="' . $this->escape($this->get_style('image_info_width')) . '" height="' . $this->escape($this->get_style('image_info_height')) . '" alt="Informationen zum Preis"/></span>', false);

                                    $this->output('<div id="c24api_reference_pricelayer" style="display: none;">' . $pricelayer . '</div>', false);

                                    $this->output('<script type="text/javascript"><!-- /* <![CDATA[ */

                                    $(document).ready(function() {
                                        $(\'#c24api_reference_price\').c24tooltip({contentId: \'c24api_reference_pricelayer\', extraClass: \'c24-content\', cache: false});
                                    });

                                    /* ]]> */ --></script>', false);

                                    $this->output('</div><div class="c24-waiting-loader" id="c24_reference_waiting"><!-- --></div>', false);

                                }

                            ?>

                        </td>
                    </tr>

                </table>

                <?php

                }

                ?>

                <?php
                    $this->output('<input type="submit" class="c24-button" id="c24Recalculate" name="c24_calculate" value="neu berechnen &raquo;"/>', false);
                    $this->output('<div id="c24SubmitLoader" style="display: none; text-align: center;"><img src="' . $this->escape($this->get_style('image_loader')) . '" height="' . $this->escape($this->get_style('image_loader_height')) . '" width="' . $this->escape($this->get_style('image_loader_width')) . '" alt="Bitte warten..." title="Bitte warten..." /></div>', false);
                ?>

            </div>

        </form>

    </div>

</div>

<?php $this->output($this->render('energy_city_select.php'), false); ?>
<script type="text/javascript">
    /* <![CDATA[ */

    var reference_tariff = <?php if(isset($this->json_referencetariff)) { $this->output(json_encode($this->json_referencetariff), false); } else { $this->output('{}'); } ?>;

    get_cities = function(zipcode) {

        if (/^([\d]{4,5})$/.test(zipcode) == false) {

            var info = $('#c24api_city_container');
            var select = $('#c24api_city');

            info.hide();

            select.children().remove();
            return;

        }

        $.ajax({
            url: '<?php $this->output($this->ajax_cities_link, false); ?>',
            dataType: 'jsonp',
            data: {
                zipcode: zipcode
            },
            success: function(data, textStatus, jqXHR) {
                handle_city(data);
            }

        });

    }

    handle_city = function(response) {

        var info = $('#c24api_city_container');
        var select = $('#c24api_city');

        if (response != null && response.status == 200) {

            var data = response.data;
            var count = 0;

            $.each(data, function(val, text) {
                count++;
            });

            if (count > 0) {

                var selected = '';

                if (count > 1) {
                    selected = 'selected="selected"';
                }

                select.children().remove();
                select.append(
                    $('<option ' + selected + '></option>').val('').html('Bitte wählen Sie.')
                );

                selected = '';

                $.each(data, function(val, text) {

                    if (count == 1) {
                        selected = 'selected="selected"';
                    }

                    select.append(
                        $('<option ' + selected + '></option>').val(val).html(text)
                    );

                });

                if (count > 1) {
                    info.show();
                }
            }

        } else {
            // reset
            info.hide();
        }

    }

    var request_cities = null;

    $(document).ready(function() {

        $('#c24api_priceguarantee_yes').click(function() {

            if ($(this).is(':checked')) {
                $('#c24api_priceguarantee').show();
            } else {
                $('#c24api_priceguarantee').hide();
            }

        });

        $('#c24api_secondarytime_active_yes').click(function() {

            if ($(this).is(':checked')) {
                $('#c24api_secondarytime').show();
            } else {
                $('#c24api_secondarytime').hide();
            }

        });

        $('#c24Recalculate').click(function() {

            $(this).hide();
            $('#c24SubmitLoader').show();

            $('#resultform').submit();

            return false;

        });

        $('#c24-more-options').click(function() {

            var $container = $('#c24-more-options-container');
            var $field = $('#c24_show_more_options');

            if ($container.is(':hidden') == true) {

                $(this).addClass('c24-more-options-close');

                $container.show();
                $field.val('yes');

            } else {

                $(this).removeClass('c24-more-options-close');

                $container.hide();
                $field.val('no');
            }

        });

        $('#c24api_zipcode').keyup(function() {

            clearTimeout(request_cities);

            var zipcode = $(this).val();

            request_cities = setTimeout(function() {
                get_cities(zipcode);
            }, 100);

        });

        $('#c24api_reference_provider_hash').change(function() {

            $('#c24api_reference_price_container').hide();
            var select = $('#c24api_reference_tariffversion_key');
            var data = {};
            var selected = '';

            if (reference_tariff['provider_tariff'][$(this).val()]) {
                data = reference_tariff['provider_tariff'][$(this).val()];
            }

            var count = 0;

            $.each(data, function(val, text) {
                count++;
            });

            select.children().remove();

            if (count > 1 || count == 0) {
                selected = 'selected="selected"'
            }

            select.append(
                $('<option ' + selected + '></option>').val('').html('Bitte wählen Sie.')
            );

            selected = '';

            $.each(data, function(val, text) {

                if (count == 1) {
                    selected = 'selected="selected"';
                }

                select.append(
                    $('<option ' + selected + '></option>').val(val).html(text)
                );

            });

            if (count == 1) {
                load_pricelayer(select.val());
            }

        });

        $('#c24api_reference_tariffversion_key').change(function() {

            if ($(this).val() != '') {

                var provider_value = $('#c24api_reference_provider_hash').val();

                if (reference_tariff['tariff_detail'][$(this).val()]) {

                    var price = $('#c24api_reference_price');
                    var pricelayer = $('#c24api_reference_pricelayer');

                    price.children('.value').html(reference_tariff['tariff_detail'][$(this).val()]['price_euro_german']);
                    pricelayer.html(reference_tariff['tariff_detail'][$(this).val()]['pricelayer']);

                    $('#c24api_reference_price_container').show();

                } else {
                    load_pricelayer($(this).val());
                }

            } else {
                $('#c24api_reference_price_container').hide();
            }

        });

        load_pricelayer = function(tariffversion_key) {

            var container = $('#c24api_reference_price_container');
            var waiting = $('#c24_reference_waiting');

            container.hide();
            waiting.show();

            $.ajax({
                url: '<?php $this->output($this->ajax_reference_tariff_link, false); ?>',
                dataType: 'jsonp',
                data: {
                    c24api_product_id: 1,
                    c24api_calculationparameter_id: '<?php isset($this->calculationparameter_id) ? $this->output($this->calculationparameter_id, false) : ''; ?>',
                    c24api_tariffversion_key:
                    tariffversion_key
                },
                success: function(data, textStatus, jqXHR) {

                    if (data.status != 200) {
                        alert('Leider ist ein Fehler aufgetreten. Bitte probieren Sie es zu einem späteren Zeitpunkt erneut.');
                        return;
                    }

                    var price = $('#c24api_reference_price');
                    var pricelayer = $('#c24api_reference_pricelayer');

                    price.children('.value').html(data.data.price_euro_german);
                    pricelayer.html(data.data.pricelayer);

                    var tariffversion_key = $('#c24api_reference_tariffversion_key').val();

                    add_reference_tariff(tariffversion_key, data.data.price_euro_german, data.data.pricelayer);

                    waiting.hide();
                    container.show();

                }
            });

        }

        $('#c24api_totalconsumption').change(function() {

            if ($(this).val() >= 100000) {

                if (confirm("Für einen jährlichen Stromverbrauch ab 100.000 kWh steht Ihnen unser Industriekundenvergleich zur Verfügung. Wollen Sie automatisch weitergeleitet werden?")) {
                    parent.location.href = 'http://www.check24.de/strom-gas/strom/industriekunden-stromvergleich/kontakt/?totalconsumption=' + $(this).val() + '&zipcode=' + $('#c24api_zipcode').val() + '#form';
                }

                return false;

            }

        });

    });



    add_reference_tariff = function(tariffversion_key, price_euro_german, pricelayer) {
        reference_tariff['tariff_detail'][tariffversion_key] = {price_euro_german: price_euro_german, pricelayer: pricelayer};
    }

    /* ]]> */

</script>
