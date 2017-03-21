<?php

/* @var \classes\calculation\client\model\parameter\pkv $params */
$params = $this->parameter;

?>
<div class="c24-filter-header-info clearfix">
    <h1>Aktuelle Filtereinstellungen</h1>
    <table>
        <?php if (!in_array($params->get_profession(), ['servant', 'servant_candidate'])) { ?>

        <tr>
            <td>Selbstbeteiligung</td>
            <td><?php if ($params->get_provision_costsharing_limit() != -1) { ?>
                    Max. <?php echo $this->currencyformat($params->get_provision_costsharing_limit(), NULL, 0) . ' pro Jahr'; } else { ?>
                    Ohne Beschränkung
                <?php } ?>
            </td>
        </tr>

        <?php } ?>


        <tr>
            <td>Krankenhaus</td>
            <td>
                <?php
                    echo $params->get_hospitalization_accommodation_german() .
                    $params->get_treatment_doctor();
                ?>
            </td>
        </tr>
        <tr>
            <td>Zahnleistung</td>
            <td><?php echo $params->get_dental_german(); ?></td>
        </tr>
        <tr>
            <td>Versicherungsbeginn</td>
            <td class="c24-filter-header-info-split-td"><?php echo $params->get_insure_date_german(); ?></td>
            <td class="c24-filter-header-info-split-td"><div class="change-filter-info clearfix"><a id="filter_tab_change" href="#change">ändern</a></div></td>
        </tr>
    </table>
</div>

<div data-role="tabs" id="tabs">
    <div data-role="navbar">
        <ul>
            <li>
                <a href="#result-container" id="result_tab" class="toggle_comparison_action" data-ajax="false">
                    <span id="result_count">
                        <?php $this->output(($this->result_count > 1) ? $this->result_count . ' Tarife' : 'Tarif', false); ?>
                    </span>
                </a>
            </li>
            <li>
                <a href="#result-container" class="compare-tariff-btn" id="compare_tab">Vergleichen</a>
            </li>
            <li>
                <a href="#filter-container" id="filter_tab" class="toggle_comparison_action" data-ajax="false">
                    <i class="fa fa-filter" style="font-size: 1.1em;"></i> Filter
                </a>
            </li>
        </ul>
    </div>

    <div id="result-container">
        <div class="result-top-menu">
            <ul>
                <li>
                    <a href="#" id="result-per-email-toggle" class="c24-filter-sort">
                    Ergebnis per E-Mail zusenden
                        <span class="arrow down"></span>
                    </a>
                </li>
                <li>
                    <a href="#" id="sort-menu-toggle" class="c24-filter-sort">
                    Sortiert nach</br>
                        <span id="sort-menu-toggle-label">Empfehlung + Preis</span>
                        <span class="arrow down"></span>
                    </a>
                </li>
            </ul>

            <div id="result-per-email-container">

                <form method="get" id="result-per-email-form" action="#">
                    <div class="c24-content-row-info-content c24-input-content">
                        <h2 id="result-per-email-headline">Jetzt Ergebnis per E-Mail verschicken</h2>
                        <label id="result-per-email-label" for="result-per-email-input" class="js-c24-block-label-top c24-label">E-Mail-Adresse</label>
                        <div class="ui-input-text ui-body-inherit ui-shadow-inset">
                            <input type="email" id="result-per-email-input" name="result-per-email-input" placeholder="E-Mail-Adresse" class="c24-form-text"/>
                        </div>
                    </div>
                    <div id="result-per-email-input-error">Bitte geben Sie Ihre E-Mail-Adresse an.</div>
                    <div id="result-per-email-send-complete"></div>
                    <a id="result-per-email-submit" class="c24-button-plain-blue c24-button-online ui-link" href="#">anfordern</a>
                </form>



            </div>

            <div id="sort-menu">
                <a class="sort-menu-row" data-sort-field="promotion" data-sort-dir="asc"><div class="c24-switch-panel-icon"></div> <span class="sort-menu-row-label">Empfehlung + Preis</span></a>
                <a class="sort-menu-row" data-sort-field="price" data-sort-dir="asc"><div class="c24-switch-panel-icon"></div> <span class="sort-menu-row-label">Niedrigster Preis zuerst</span></a>
                <a class="sort-menu-row" data-sort-field="tariffgrade" data-sort-dir="asc"><div class="c24-switch-panel-icon"></div> <span class="sort-menu-row-label">Beste Note zuerst</span></a>
                <a class="sort-menu-row" data-sort-field="provider" data-sort-dir="asc"><div class="c24-switch-panel-icon"></div> <span class="sort-menu-row-label">Anbieter A-Z</span></a>
                <a class="sort-menu-row" data-sort-field="provider" data-sort-dir="desc"><div class="c24-switch-panel-icon"></div> <span class="sort-menu-row-label">Anbieter Z-A</span></a>
            </div>
        </div>

        <div id="compare-hint" style="display: none;">
            <img src="/massets/images/icons/compare-arrow.png" /> Jetzt 2 Tarife auswählen
        </div>

        <div id="compare-menu" style="display:none;">
            <a id="compare-menu-close" class="compare-close toggle_comparison_action">&nbsp;</a>
            <a id="compare-menu-label">Bitte 2 Tarife auswählen</a>
        </div>

        <div id="result" class="ui-body-d ui-content" data-calculationparameter_id="<?php echo $params->get_id();?>">

            <?php
            if (isset($this->result_content)) {
                $this->output($this->result_content, false);
            }
            ?>
        </div>
    </div>

    <div id="filter-container">
        <?php
        $this->output($this->result_filter_content, false);
        ?>
    </div>
</div>
