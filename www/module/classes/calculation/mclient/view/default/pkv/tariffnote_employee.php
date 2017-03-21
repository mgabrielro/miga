<div data-role="collapsibleset" data-corners="false" data-theme="a" data-content-theme="a" class="tarifffootnote">
    <div data-role="collapsible" class="listItemNoIcon" data-iconpos="right" data-collapsed-icon="carat-d" data-expanded-icon="carat-u">
        <h3>Fußnoten</h3>
        <div class="tariff-note-wrapper">

            <?php $stars = '*';  ?>

            <?php if($actual_page == 'tariff_detail_page'): ?>
                <p> <?php echo $stars; ?> Die Versicherungsunternehmen behalten es sich vor, bei schwerwiegenden Vorerkrankungen einen Risikoaufschlag zu erheben. Unsere PKV-Experten beraten Sie gerne und unterstützen Sie beim Ausfüllen des Gesundheitsfragebogens. </p>
                <?php $stars = '**'; ?>
            <?php endif; ?>

            <p> <?php echo $stars; ?> Ihr Anteil = Gesamtbeitrag pro Monat abzügl. Arbeitgeberanteil
                (der AG zahlt 50 % des Gesamtbeitrags, max. jedoch <?php echo $this->currencyformat($this->price_calc_params['long_term_care_monthly_amount']);?>
                für die Pflegepflichtversicherung und <?php echo $this->currencyformat($this->price_calc_params['employer_contribution_monthly_amount']); ?>
                für den restlichen Beitrag; Stand: <?php echo $this->price_calc_params['year']; ?>).</p>

            <?php $stars = ($actual_page == 'tariff_detail_page') ? '***' : '**'; ?>

            <p> <?php echo $stars; ?> Die Ersparnis berechnet sich aus dem Jahresbeitrag des Arbeitnehmers zur GKV und Pflegepflichtversicherung (PV - Berechnung s. Tabelle) abzügl. des Arbeitnehmeranteils zum PKV-Tarif („Ihr Anteil“, beinhaltet auch PV).</p>

            <table>
                <tr>
                    <th>Beitragsbemessungsgrenze</th>
                    <td></td>
                    <td><?php echo $this->currencyformat($this->price_calc_params['contribution_ceiling_yearly']);?></td>
                </tr>
                <tr>
                    <th>AN-Anteil an GKV mit durchschnittl. Beitragssatz (insg. <?php echo $this->numberformat($this->price_calc_params['statutory_health_insurance_average_percentage']);?> %)</th>
                    <td><?php echo $this->numberformat($this->price_calc_params['employee_contribution_percentage']); ?> %</td>
                    <td><?php echo $this->currencyformat($this->price_calc_params['employee_contribution_yearly_amount']); ?></td>
                </tr>
                <tr>
                    <th>AN-Anteil an PV</th>
                    <td><?php echo $this->numberformat($this->price_calc_params['long_term_care_percentage']); ?> %</td>
                    <td><?php echo $this->currencyformat($this->price_calc_params['contribution_ceiling_yearly'] * $this->price_calc_params['long_term_care_percentage']/100); ?></td>
                </tr>
                <tr>
                    <th>AN-Anteil gesamt</th>
                    <td></td>
                    <td><?php echo $this->currencyformat($this->price_calc_params['contribution_ceiling_yearly'] * ($this->price_calc_params['long_term_care_percentage'] + $this->price_calc_params['employee_contribution_percentage'])/100);?></td>
                </tr>
            </table>
            <p>
                (Betrachtung vor Steuern, Selbstbeteiligung und Beitragsrückerstattung; Stand: <?php echo $this->price_calc_params['year']; ?>)
            </p>
        </div>
    </div>
</div>