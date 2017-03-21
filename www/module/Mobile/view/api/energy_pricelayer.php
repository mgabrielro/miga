<?php

    $html = '<table width="' . $this->width . '" class="c24EnergyPriceLayer">';

    $html .= '<tr>';
    $html .= '<td colspan="2"><strong>Informationen zum Preis für ' . $this->calculation_parameter->get_zipcode() . ' ' . $this->calculation_parameter->get_city() . ': Berechnung für ' . number_format($this->calculation_parameter->get_totalconsumption(), 0, ',', '.') . ' kWh / Jahr</strong></td>';
    $html .= '</tr>';

    $html .= '<tr>';
    $html .= '<td colspan="2"><div class="space10"><!-- --></div></td>';
    $html .= '</tr>';

    $html .= '<tr>';
    $html .= '<td width="47%"><strong>Jahreskosten ohne Bonus:</strong></td>';
    $html .= '<td width="53%"><strong>' . number_format($this->tariff->get_price_regularprice() / 100, 2, ',', '.') . ' € / Jahr</strong></td>';
    $html .= '</tr>';

    $html .= '<tr>';
    $html .= '<td colspan="2"><div class="space10"><!-- --></div></td>';
    $html .= '</tr>';

    $price_infos = $this->tariff->get_price_infos();

    if ($this->tariff->get_price_package() == 'yes') {

        $html .= '<tr>';
        $html .= '<td>Paketpreis:</td>';
        $html .= '<td>' . number_format($price_infos[0]['basicprice'] / 100, 2, ',', '.') . ' € / Jahr</td>';
        $html .= '</tr>';

        if ($price_infos[0]['to'] < $this->calculation_parameter->get_totalconsumption()) {

            $html .= '<tr>';
            $html .= '<td>Mehrverbrauchspreis:</td>';
            $html .= '<td>' . number_format(($this->calculation_parameter->get_totalconsumption() - $price_infos[0]['to']) * $price_infos[0]['unitfee'] / 100, 2, ',', '.') . ' € / Jahr</td>';
            $html .= '</tr>';

        }

        if ($this->tariff->get_price_refund_price() > 0) {

            $html .= '<tr>';
            $html .= '<td>' . $this->escape($this->tariff->get_price_refund_label()) . ':</td>';
            $html .= '<td>-' . number_format($this->tariff->get_price_refund_price() / 100, 2, ',', '.') . ' € / Jahr</td>';
            $html .= '</tr>';

        }

    } else {

        $html .= '<tr>';
        $html .= '<td>Arbeitspreis:</td>';
        $html .= '<td>' . number_format($this->tariff->get_price_unitprice() / 100, 2, ',', '.') . ' € / Jahr</td>';
        $html .= '</tr>';

        $html .= '<tr>';
        $html .= '<td>Grundpreis:</td>';
        $html .= '<td>' . number_format($price_infos[0]['basicprice'] / 100, 2, ',', '.') . ' € / Jahr</td>';
        $html .= '</tr>';

    }

    if ($this->tariff->get_tariff_product_id() == 2 && $this->tariff->get_price_heatingpower_price() > 0) {

        $html .= '<tr>';
        $html .= '<td>Leistungspreis:</td>';
        $html .= '<td>' . number_format($this->tariff->get_price_heatingpower_price() / 100, 2, ',', '.') . '  € / Jahr</td>';
        $html .= '</tr>';

    }

    // Bonus information

    $bonus = $this->tariff->get_bonus();

    for ($i = 0, $i_max = count($bonus); $i < $i_max; ++$i) {

        if ($bonus[$i]['calculation'] != 'yes') {
            continue;
        }

        $label = $bonus[$i]['label'];
        $payment = 'jährlich';

        if ($bonus[$i]['newcustomer'] == 'yes') {
            $payment = 'einmalig';
        }

        $html .= '<tr>';
        $html .= '<td>' . $this->escape($label) . ':</td>';

        switch ($bonus[$i]['unit_id']) {

            case 1 /* ct/kWh auf AP */ :
            case 15 /* ct/kWh auf AP (HT) */ :
            case 17 /* ct/kWh auf AP (NT) */ :

                $html .= '<td>' . number_format($bonus[$i]['cent'] / 100, 2, ',', '.') . ' € ' . $payment . '</td>';
                $html .= '</tr>';

                break;

            case 6 /* € einmalig */ :

                $html .= '<td>' . number_format($bonus[$i]['cent'] / 100, 2, ',', '.') . ' € einmalig</td>';
                $html .= '</tr>';

                break;

            case 2 /* € Jahr */ :
            case 12 /* € Jahr */ :

                $html .= '<td>' . number_format($bonus[$i]['cent'] / 100, 2, ',', '.') . ' € jährlich</td>';
                $html .= '</tr>';

                break;

            case 3 /* kWh/Jahr */ :

                $html .= '<td>' . number_format($bonus[$i]['cent'] / 100, 2, ',', '.') . ' € (' . number_format($bonus[$i]['value'], 0, ',', '.') . ' kWh) pro Jahr</td>';
                $html .= '</tr>';

                break;

            case 4 /* % auf Rechnungsbetrag */ :
            case 10 /* % auf Grundpreis */ :
            case 8 /* % */ :
            case 23 /* % auf Vorauszahlungsbetrag */ :

                $html .= '<td>' . number_format($bonus[$i]['cent'] / 100, 2, ',', '.') . ' € (' . number_format($bonus[$i]['value'], 1, ',', '.') . ' %) ' . $payment . '</td>';
                $html .= '</tr>';

                break;

            case 5 /* % auf AP */ :

                $html .= '<td>' . number_format($bonus[$i]['cent'] / 100, 2, ',', '.') . ' € (' . number_format($bonus[$i]['value'], 1, ',', '.') . ' %) ' . $payment . '</td>';
                $html .= '</tr>';

                break;

            case 7 /* kWh einmalig */ :

                $html .= '<td>' . number_format($bonus[$i]['cent'] / 100, 2, ',', '.') . ' € (' . number_format($bonus[$i]['value'], 0, ',', '.') . ' kWh) einmalig</td>';
                $html .= '</tr>';

                break;

            case 500000 /* €/Monat */ :

                $html .= '<td>' . number_format($bonus[$i]['value'], 2, ',', '.') . ' € pro Monat</td>';
                $html .= '</tr>';

                break;

            case 500001 /* ct/kWh */ :

                $html .= '<td>' . number_format($bonus[$i]['cent'] / 100, 2, ',', '.') . ' € ' . $payment . '</td>';
                $html .= '</tr>';

                break;

        }

    }

    if ($this->tariff->get_priceguarantee_costs() > 0) {

        $html .= '<tr>';
        $html .= '<td>Kosten Preisgarantie:</td>';
        $html .= '<td>' . number_format($this->tariff->get_priceguarantee_costs() / 100, 2, ',', '.') . ' € / Jahr</td>';
        $html .= '</tr>';

    }

    // Dotted line

    $html .= '<tr>';
    $html .= '<td colspan="2"><div class="space10"><!-- --></div></td>';
    $html .= '</tr>';

    $html .= '<tr>';
    $html .= '<td colspan="2" class="c24DottedLine"><!-- --></td>';
    $html .= '</tr>';

    $html .= '<tr>';
    $html .= '<td colspan="2"><div class="space10"><!-- --></div></td>';
    $html .= '</tr>';

    // Year cost

    $html .= '<tr>';
    $html .= '<td><strong>Bruttopreis inkl. Bonus im ersten Jahr:</strong></td>';
    $html .= '<td><strong>' . number_format($this->tariff->get_price_price_with_bonus() / 100, 2, ',', '.') . ' € / Jahr</strong></td>';
    $html .= '</tr>';

    if ($this->tariff->get_paymentperiod_period() != 'year') {

        $html .= '<tr>';
        $html .= '<td colspan="2"><div class="space10"><!-- --></div></td>';
        $html .= '</tr>';

        if ($this->tariff->get_paymentperiod_period() == 'month_dependent') {

            $html .= '<tr>';
            $html .= '<td><strong>Geschätzter Abschlag:</strong></td>';
            $html .= '<td><strong>monatsabhängig (zwischen ' . number_format($this->tariff->get_paymentperiod_lower_size() / 100, 2, ',', '.') . ' und ' . number_format($this->tariff->get_paymentperiod_upper_size() / 100, 2, ',', '.') . ' Euro / Monat)</strong></td>';
            $html .= '</tr>';

        } else {

            $html .= '<tr>';
            $html .= '<td><strong>Geschätzter Abschlag:</strong></td>';
            $html .= '<td><strong>' . number_format($this->tariff->get_paymentperiod_size() / 100, 2, ',', '.') . ' € / ' . $this->tariff->get_paymentperiod_label() . '</strong> (Jahreskosten geteilt durch ' . $this->tariff->get_paymentperiod_count() . ')</td>';
            $html .= '</tr>';

        }

    }

    $bonus = $this->tariff->get_bonus();

    for ($i = 0, $i_max = count($bonus); $i < $i_max; ++$i) {

        if ($bonus[$i]['calculation'] == 'yes') {
            continue;
        }

        $label = $bonus[$i]['label'];
        $additional = $bonus[$i]['additional'];

        $html .= '<tr>';
        $html .= '<td colspan="2"><div class="space10"><!-- --></div></td>';
        $html .= '</tr>';

        $html .= '<tr>';
        $html .= '<td valign="top"><strong>' . $label . ':</strong></td>';
        $html .= '<td><strong>' . number_format($bonus[$i]['cent'] / 100, 2, ',', '.') . ' €</strong> ' . $additional . '</td>';
        $html .= '</tr>';

    }

    $price_infos = $this->tariff->get_price_infos();

    if ($this->tariff->get_price_package() == 'yes') {

        $html .= '<tr>';
        $html .= '<td colspan="2"><div class="space10"><!-- --></div></td>';
        $html .= '</tr>';

        $html .= '<tr>';
        $html .= '<td class="c24CostInfoSmall"><strong>Paketpreis brutto</strong> (netto):</td>';
        $html .= '<td class="c24CostInfoSmall"><strong>' . number_format($price_infos[0]['basicprice'] / 100, 2, ',', '.') . '</strong> (' . number_format($price_infos[0]['basicprice'] / 100 / 1.19, 2, ',', '.') . ') <strong>€ / Jahr</strong></td>';
        $html .= '</tr>';

        $html .= '<tr>';
        $html .= '<td class="c24CostInfoSmall"><strong>Mehrverbrauchspreis brutto</strong> (netto):</td>';
        $html .= '<td class="c24CostInfoSmall"><strong>' . number_format($price_infos[0]['unitfee'], 2, ',', '.') . '</strong> (' . number_format($price_infos[0]['unitfee'] / 1.19, 2, ',', '.') . ') <strong>Ct. / kWh</strong></td>';
        $html .= '</tr>';

        if ($this->tariff->get_price_refund() > 0) {

            $html .= '<tr>';
            $html .= '<td class="c24CostInfoSmall"><strong>' . $this->escape($this->tariff->get_price_refund_label()) . '</strong> (netto):</td>';
            $html .= '<td class="c24CostInfoSmall"><strong>' . number_format($this->tariff->get_price_refund(), 2, ',', '.') . '</strong> (' . number_format($this->tariff->get_price_refund() / 1.19, 2, ',', '.') . ') <strong>Ct. / kWh</strong></td>';
            $html .= '</tr>';

        }

    } else {

        if (count($price_infos) == 1) {

            $html .= '<tr>';
            $html .= '<td colspan="2"><div class="space10"><!-- --></div></td>';
            $html .= '</tr>';

            $html .= '<tr>';
            $html .= '<td class="c24CostInfoSmall"><strong>Arbeitspreis brutto</strong> (netto):</td>';
            $html .= '<td class="c24CostInfoSmall"><strong>' . number_format($price_infos[0]['unitfee'], 2, ',', '.') . '</strong> (' . number_format($price_infos[0]['unitfee'] / 1.19, 2, ',', '.') . ') <strong>Ct. / kWh</strong></td>';
            $html .= '</tr>';

            $html .= '<tr>';
            $html .= '<td class="c24CostInfoSmall"><strong>Grundpreis brutto</strong> (netto):</td>';
            $html .= '<td class="c24CostInfoSmall"><strong>' . number_format($price_infos[0]['basicprice'] / 100, 2, ',', '.') . '</strong> (' . number_format($price_infos[0]['basicprice'] / 100 / 1.19, 2, ',', '.') . ') <strong>€ / Jahr</strong></td>';
            $html .= '</tr>';

        } else {

            for ($i = 0, $i_max = count($price_infos); $i < $i_max; ++$i) {

                $html .= '<tr>';
                $html .= '<td colspan="2"><div class="space10"><!-- --></div></td>';
                $html .= '</tr>';

                $html .= '<tr>';
                $html .= '<td colspan="2" class="c24CostInfoSmall">Verbrauch von ' . number_format($price_infos[$i]['from'], 0, ',', '.') . ' kWh bis ' . number_format($price_infos[$i]['to'], 0, ',', '.') . ' kWh:</td>';
                $html .= '</tr>';

                $html .= '<tr>';

                if (isset($price_infos[$i]['timezone']) && $price_infos[$i]['timezone'] == 'primary') {
                    $html .= '<td class="c24CostInfoSmall"><strong>Arbeitspreis Hauptzeit brutto</strong> (netto):</td>';
                } else if (isset($price_infos[$i]['timezone']) && $price_infos[$i]['timezone'] == 'secondary') {
                    $html .= '<td class="c24CostInfoSmall"><strong>Arbeitspreis Nebenzeit brutto</strong> (netto):</td>';
                } else {
                    $html .= '<td class="c24CostInfoSmall"><strong>Arbeitspreis brutto</strong> (netto):</td>';
                }

                $html .= '<td class="c24CostInfoSmall"><strong>' . number_format($price_infos[$i]['unitfee'], 2, ',', '.') . '</strong> (' . number_format($price_infos[$i]['unitfee'] / 1.19, 2, ',', '.') . ') <strong>Ct. / kWh</strong></td>';
                $html .= '</tr>';

                if ($price_infos[$i]['basicprice'] !== NULL) {

                    $html .= '<tr>';
                    $html .= '<td class="c24CostInfoSmall"><strong>Grundpreis brutto</strong> (netto):</td>';
                    $html .= '<td class="c24CostInfoSmall"><strong>' . number_format($price_infos[$i]['basicprice'] / 100, 2, ',', '.') . '</strong> (' . number_format($price_infos[$i]['basicprice'] / 100 / 1.19, 2, ',', '.') . ') <strong>€ / Jahr</strong></td>';
                    $html .= '</tr>';

                }

            }

        }

        if ($this->tariff->get_tariff_product_id() == 2 && $this->tariff->get_price_heatingpower_price() > 0) {

            $heatingpower_infos = $this->tariff->get_price_heatingpower_infos();

            if (count($heatingpower_infos) == 1) {

                if ($heatingpower_infos[0]['basicprice'] > 0) {

                    $html .= '<tr>';
                    $html .= '<td colspan="2"><div class="space10"><!-- --></div></td>';
                    $html .= '</tr>';

                    $html .= '<tr>';
                    $html .= '<td class="c24CostInfoSmall"><strong>Fixer Leistungspreis brutto</strong> (netto):</td>';
                    $html .= '<td class="c24CostInfoSmall"><strong>' . number_format($heatingpower_infos[0]['basicprice'] / 100, 2, ',', '.') . '</strong> (' . number_format($heatingpower_infos[0]['basicprice'] / 100 / 1.19, 2, ',', '.') . ') <strong>€ / Jahr</strong></td>';
                    $html .= '</tr>';

                }

                if ($heatingpower_infos[0]['unitfee'] > 0) {

                    $html .= '<tr>';
                    $html .= '<td class="c24CostInfoSmall"><strong>Leistungspreis brutto</strong> (netto):</td>';
                    $html .= '<td class="c24CostInfoSmall"><strong>' . number_format($heatingpower_infos[0]['unitfee'] / 100, 2, ',', '.') . '</strong> (' . number_format($heatingpower_infos[0]['unitfee'] / 100 / 1.19, 2, ',', '.') . ') <strong>€ / KW / Jahr</strong></td>';
                    $html .= '</tr>';

                }

            } else {

                for ($i = 0, $i_max = count($heatingpower_infos); $i < $i_max; ++$i) {

                    $html .= '<tr>';
                    $html .= '<td colspan="2"><div class="space10"><!-- --></div></td>';
                    $html .= '</tr>';

                    $html .= '<tr>';
                    $html .= '<td colspan="2" class="c24CostInfoSmall">Verbrauch von ' . number_format($heatingpower_infos[$i]['from'], 0, ',', '.') . ' KW bis ' . number_format($heatingpower_infos[$i]['to'], 0, ',', '.') . ' KW:</td>';
                    $html .= '</tr>';

                    if ($heatingpower_infos[$i]['basicprice'] > 0) {

                        $html .= '<tr>';
                        $html .= '<td class="c24CostInfoSmall"><strong>Fixer Leistungspreis brutto</strong> (netto):</td>';
                        $html .= '<td class="c24CostInfoSmall"><strong>' . number_format($heatingpower_infos[$i]['basicprice'] / 100, 2, ',', '.') . '</strong> (' . number_format($heatingpower_infos[$i]['basicprice'] / 100 / 1.19, 2, ',', '.') . ') <strong>€ / Jahr</strong></td>';
                        $html .= '</tr>';

                    }

                    if ($heatingpower_infos[$i]['unitfee'] > 0) {

                        $html .= '<tr>';
                        $html .= '<td class="c24CostInfoSmall"><strong>Leistungspreis brutto</strong> (netto):</td>';
                        $html .= '<td class="c24CostInfoSmall"><strong>' . number_format($heatingpower_infos[$i]['unitfee'] / 100, 2, ',', '.') . '</strong> (' . number_format($heatingpower_infos[$i]['unitfee'] / 100 / 1.19, 2, ',', '.') . ') <strong>€ / KW / Jahr</strong></td>';
                        $html .= '</tr>';

                    }

                }

            }

        }

    }

    $html .= '<tr>';
    $html .= '<td colspan="2"><div class="space10"><!-- --></div></td>';
    $html .= '</tr>';

    $html .= '<tr>';
    $html .= '<td colspan="2">Tarifversion ' . $this->escape($this->tariff->get_tariff_version_id()) . ', gültig seit ' . date('d.m.Y', strtotime($this->tariff->get_tariff_validfrom())) . '. <strong>Bruttopreise</strong> beinhalten alle Steuern und Abgaben. <strong>Nettopreise</strong> sind zzgl. MwSt.</td>';
    $html .= '</tr>';

    $html .= '<tr>';
    $html .= '<td colspan="2"><div class="space10"><!-- --></div></td>';
    $html .= '</tr>';

    $html .= '<tr>';
    $html .= '<td colspan="2">ACHTUNG: Alle Berechnungen beziehen sich auf das erste Vertragsjahr. <strong>Neukundenboni</strong> werden mit der nächsten Jahresrechnung verrechnet oder ausgezahlt. <strong style="white-space: nowrap;">CHECK24 Boni</strong> oder <strong>Willkommensboni</strong> werden kurzfristig nach Lieferbeginn ausgezahlt.</td>';
    $html .= '</tr>';

    if ($this->tariff->get_tariff_extrainfos() != '') {

        $html .= '<tr>';
        $html .= '<td colspan="2"><div class="space10"><!-- --></div></td>';
        $html .= '</tr>';
        $html .= '<tr>';
        $html .= '<td colspan="2"><strong class="c24BigFontSize">' . $this->escape($this->tariff->get_tariff_extrainfos()) . '</strong></td>';
        $html .= '</tr>';

    }

    $html .= '</table>';
    $this->output($html, false);

?>
