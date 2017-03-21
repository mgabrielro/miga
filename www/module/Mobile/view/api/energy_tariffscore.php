<div class="c24-tariffscore">

    <strong>AGB Bewertung des Tarifs <?php $this->output($this->tariff->get_tariff_name()); ?></strong>
    <div class="c24-space10"><!-- --></div>

    <table width="100%">

        <tr>
            <td width="30%">Laufzeit:</td>
            <td width="40%"><?php $this->output($this->tariff->get_tariff_contractperiod()) ?></td>
            <td width="30%"><?php $this->output($this->tariffscore->get_contractend_score()) ?> Punkte von 5</td>
        </tr>

        <tr>
            <td>Kündigungsfrist:</td>
            <td><?php $this->output($this->tariff->get_tariff_cancellationperiod()) ?></td>
            <td><?php $this->output($this->tariffscore->get_cancelation_score()) ?> Punkte von 5</td>
        </tr>

        <tr>
            <td>Preigarantie Dauer:</td>
            <td><?php

                if ($this->tariff->get_priceguarantee_date() !== NULL) {
                    $this->output('bis ' . date('d.m.Y', strtotime($this->tariff->get_priceguarantee_date())));
                } else if ($this->tariff->get_priceguarantee_months() > 0) {

                    if ($this->tariff->get_priceguarantee_months() == 1) {
                        $this->output('1 Monat');
                    } else {
                        $this->output($this->tariff->get_priceguarantee_months() . ' Monate');
                    }

                } else {
                    $this->output('keine');
                }

            ?></td>

            <td><?php $this->output($this->tariffscore->get_pg_score()) ?> Punkte von 5</td>
        </tr>

        <tr>
            <td>Preisgarantie Art:</td>
            <td><?php $this->output($this->tariff->get_priceguarantee_label()) ?></td>
            <td><?php $this->output($this->tariffscore->get_pg_type_score()) ?> Punkte von 5</td>
        </tr>

        <tr>
            <td>Zahlweise:</td>
            <td><?php $this->output($this->tariff->get_paymentperiod_label()) ?></td>
            <td><?php $this->output($this->tariffscore->get_paymentperiod_score()) ?> Punkte von 5</td>
        </tr>

        <tr>
            <td>Kaution</td>
            <td><?php $this->output($this->tariff->get_price_deposit() > 0 ? 'Ja' : 'Nein') ?></td>
            <td><?php $this->output($this->tariffscore->get_deposit_score()) ?> Punkte von 5</td>
        </tr>

        <tr>
            <td>Pakettarif</td>
            <td><?php $this->output($this->tariff->get_price_package() == 'yes' ? 'Ja' : 'Nein') ?></td>
            <td><?php $this->output($this->tariffscore->get_package_score()) ?> Punkte von 5</td>
        </tr>

    </table>

    <div class="c24-space10"><!-- --></div>

    <strong>

        <?php
            $this->output($this->tariffscore->get_score_sum());
        ?>

        von 35 möglichen Punkten

    </strong>

</div>