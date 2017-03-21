<?php
/* @var $this \shared\classes\calculation\client\view */

$promotion = $this->tariff->is_promo_tariff(true);

$tariff_link = ($this->tariff_detail_link ? $this->tariff_detail_link : '');
$tariff_grade_helper = new \classes\calculation\client\controller\helper\generate_tariffgrade_pkv($this->tariff);
$tariff_grade_helper->set_calculation_parameter_id($this->calculationparameter->get_id());

$grade_text = $tariff_grade_helper->get_grade_description($this->tariff->get_tariff_features()['global']['content']['grade']);
$grade_text_class = $tariff_grade_helper->get_grade_text_class();

$promotion_class = ($promotion) ? 'c24-promo-div': '';
$overview = NULL;

$is_child = ($this->parameter->get_insured_person() === 'child');
$is_servant_child = ($this->parameter->get_insured_person() === 'child' && $this->parameter->get_parent_servant_or_servant_candidate() === 'yes');
$is_employee = ($this->parameter->get_profession() === 'employee');

if (strpos($this->subscription_url, '?') !== false) {
    $uri = str_replace('?','%s?',$this->subscription_url);
    $uri .= '&promotion_type=' . $this->tariff->get_promotion_type();
    $uri .= '&is_gold_grade=' . $this->tariff->is_gold_grade();
} else {
    $uri = $this->subscription_url . '%s';
    $uri .= '?promotion_type=' . $this->tariff->get_promotion_type();
    $uri .= '&is_gold_grade=' . $this->tariff->is_gold_grade();
}

//Hidden Fields are uses for api calls to get tariff details
?>
<input type="hidden" id="insured_person" value="<?php echo $this->parameter->get_insured_person()?>" >
<input type="hidden" id="profession" value="<?php echo $this->parameter->get_profession(); ?>">
<input type="hidden" id="provider_id" value="<?php echo $this->tariff->get_provider_id(); ?>">
<input type="hidden" id="tracking_id" value="<?php echo $this->get_client()->get_tracking_id(); ?>">
<input type="hidden" id="mode_id" value="<?php echo $this->get_client()->get_mode_id(); ?>">
<input type="hidden" id="tariff_id" value="<?php echo $this->tariff->get_tariff_id(); ?>">
<div id="blocker" class="blocker">
    <i id="blocker-icon" class="fa fa-spinner fa-spin fa-5x"></i>
</div>
<?php if (count($this->tariff_history) > 2) : ?>
    <div class="c24-tariff-history">
        <h1>Nochmals anzeigen</h1>
        <table>
            <tr>
                <td>
                    <div class="left_arrow">
                        <i class="fa fa-caret-left"></i>
                    </div>
                </td>
                <td class="tariff_logos">
                    <div style="height: 40px;width: 100%;position: relative;">
                        <?php
                            foreach ($this->tariff_history AS $tariff) {
                                $this->output('<a href="' . $tariff['link'] . '" data-ajax="false"> <div class="tariff_logo"> <img src="' . $tariff['logo'] . '"> </div> </a>', FALSE);
                            }
                        ?>
                    </div>
                </td>
                <td>
                    <div class="right_arrow">
                        <i class="fa fa-caret-right"></i>
                    </div>
                </td>
            </tr>
        </table>
    </div>

<?php endif; ?>

<div class="c24_tariff-overview <?php $this->output($promotion_class, false);?>">

    <div class="row">
        <?php if ($promotion) :
            $promotion_title = $this->tariff->get_tariff_promotion_bin($this->calculationparameter->get_profession());
            ?>

            <div class="c24-promo-banner c24-clearfix">
                <div class="c24-result-promo-tip">
                    <?php ($promotion_title) ? $this->output($promotion_title, false) : ''; ?>
                </div>
            </div>

        <?php endif; ?>

        <div class="c24-result-top-row c24-clearfix">
            <?php if ($this->is_employee && !$this->is_child): ?>
                <div class="c24-tariff-overview-left">
            <?php else: ?>
                <div class="c24-tariff-overview-left bottom-not-employee">
            <?php endif; ?>
               <?php echo $this->render('default/pv/tariffinformation.phtml'); ?>
            </div>
        </div>
    <!-- show the tariff special action -->
    <?php include_once 'module/Mobile/view/common/special_action.phtml'; ?>

    <div class="c24-wrapper-button">

    <div class="c24-tariff-detail-subscription_offer">
        <?php
        $this->output(
            '<a class="c24-button-plain-blue c24-button-online full_button" data-ajax="false" href="' . $this->escape(sprintf($uri,'offer')) . '">Angebot anfordern</a>',
            false);
        ?>
    </div>
        <div class="c24-form-transfer-text">
            <img src="/massets/images/styleguide/check_green_12.png">
            <span class="c24-form-transfer-text">Kostenfrei & unverbindlich Angebot anfordern</span>
        </div>

        <div class="c24-tariff-detail-subscription_expert">
            <?php
            $this->output(
                '<a class="c24-button-plain-grey c24-button-online full_button" data-ajax="false" href="' . $this->escape(sprintf($uri,'expert')) . '">Beratung anfordern</a>',
                false
            );
            ?>
        </div>

        <div class="c24-form-transfer-text">
            <img src="/massets/images/styleguide/check_green_12.png">
            <span class="c24-form-transfer-text">Kostenfrei & unverbindlich vom PKV-Experten <br/>zurückrufen lassen</span>
        </div>
    </div>
    <div id="fragment-1">

        <div class="tariff-information tariff-box">
            <h2>
                Tarifüberblick
            </h2>
            <div class="tariff-row-hidden">
                <h3 class="c24-content-headline">Das Wichtigste zur <?php echo $this->tariff->get_provider_name() . " Krankenversicherung" ?></h3>
                <ul class="step_overview_important_list c24-stripes">

                    <?php if($this->tariff->get_med_reimbursement() > 0 || $this->tariff->get_med_direct_medical_consultation() > 0) : ?>
                        <li>
                            <img src="/massets/images/styleguide/pkv-dialog-icons-01.png" alt="Ambulante Leistungen" />
                            <ul>
                                <li ><?php
                                        if ($this->tariff->get_med_reimbursement()) {
                                            echo number_format($this->tariff->get_med_reimbursement(), 0, '.', ',') . " % Erstattung ambulanter ärztlicher Leistungen";
                                        }
                                    ?>
                                </li>
                                <li>
                                    <?php
                                        if ($this->tariff->get_med_direct_medical_consultation()) {
                                            echo number_format($this->tariff->get_med_direct_medical_consultation(), 0, '.', ',') . " % bei direkter Facharzt-Behandlung";
                                        }
                                    ?>
                                </li>
                            </ul>
                        </li>
                    <?php endif; ?>

                    <?php if($this->tariff->get_hospitalization_accommodation() || $this->tariff->get_treatment_attending_doctor()) : ?>
                        <li>
                            <img src="/massets/images/styleguide/pkv-dialog-icons-02.png" alt="Stationäre Leistungen" />
                            <ul>
                                <?php
                                    if ($this->tariff->get_hospitalization_accommodation())  {

                                        $room_content = '<li>';

                                        if ($this->tariff->get_hospitalization_accommodation()=='shared_room') {
                                            $room_content .= 'Mehrbettzimmer';
                                        } elseif ($this->tariff->get_hospitalization_accommodation() == 'twin_room') {
                                            $room_content .= '2-Bett-Zimmer';
                                        } elseif ($this->tariff->get_hospitalization_accommodation() == 'single_room') {
                                            $room_content .= '1-Bett-Zimmer';
                                        }

                                        $room_content .= '</li>';
                                        echo $room_content;

                                    }

                                    if ($this->tariff->get_treatment_attending_doctor()) {

                                        $doctor_content = '<li>';

                                        if ($this->tariff->get_treatment_attending_doctor()=='head_doctor') {
                                            $doctor_content .= 'Chefarzt';
                                        } elseif ($this->tariff->get_treatment_attending_doctor() == 'general_practitioner') {
                                            $doctor_content .= 'Stationsarzt';
                                        }

                                        $doctor_content .= '</li>';
                                        echo $doctor_content;
                                    }
                                ?>
                            </ul>
                        </li>
                    <?php endif; ?>

                    <?php if($this->tariff->get_dental_treatment() > 0 || $this->tariff->get_dental_dentures() > 0 ) : ?>
                        <li>
                            <img src="/massets/images/styleguide/pkv-dialog-icons-03.png" alt="Zahnersatz Leistungen" />
                            <ul>
                                <li>
                                    <?php
                                        if ($this->tariff->get_dental_treatment() > 0) {
                                            echo number_format($this->tariff->get_dental_treatment(), 0, '.', ',') . " % Erstattung bei Zahnbehandlung ";
                                        }

                                         if ($this->tariff->get_dental_treatment_limit_1y() > 0) {
                                            echo "(max. " . $this->currencyformat($this->tariff->get_dental_treatment_limit_1y(), NULL, 0) . " im 1. Jahr)";
                                         }
                                    ?>
                                </li>

                                <li>
                                    <?php
                                        if ($this->tariff->get_dental_dentures() > 0) {
                                            echo number_format($this->tariff->get_dental_dentures(), 0, '.', ',') . " % bei Zahnersatz ";
                                        }

                                        if ($this->tariff->get_dental_dentures_limit_1y() > 0) {
                                            echo "(max. " . $this->currencyformat($this->tariff->get_dental_dentures_limit_1y(), NULL, 0) . " im 1. Jahr)";
                                        }
                                    ?>
                                </li>
                            </ul>
                        </li>
                    <?php endif; ?>

                    <?php if(!$this->is_servant && !$this->is_servant_child && $this->tariff->get_provision_costsharing()) : ?>
                        <li>
                            <img src="/massets/images/styleguide/pkv-dialog-icons-05.png" alt="Selbstbeteiligung" />
                            <ul>
                                <?php
                                    if ($this->tariff->get_provision_costsharing_sector() == 'outpatient') {
                                        $costsharing_sector = "ambulante Leistungen";
                                    } elseif ($this->tariff->get_provision_costsharing_sector() == 'outpatient_dental') {
                                        $costsharing_sector = "ambulante Leistungen und Zahnleistungen";
                                    } elseif ($this->tariff->get_provision_costsharing_sector() == 'outpatient_inpatient') {
                                        $costsharing_sector = "ambulante und stationäre Leistungen";
                                    } elseif ($this->tariff->get_provision_costsharing_sector() == 'outpatient_inpatient_dental') {
                                        $costsharing_sector = "ambulante und stationäre Leistungen und Zahnleistungen";
                                    } else {
                                        $costsharing_sector = "";
                                    }
                                ?>
                                <li>
                                    <?php
                                        if ($this->is_child) {

                                            if (!$this->is_servant_child) {
                                                echo $this->currencyformat($this->tariff->get_provision_children_costsharing_amount(), NULL, 0) . " Selbstbeteiligung";
                                            }

                                        } else {

                                            if ($this->tariff->get_provision_costsharing() == 'no') {

                                                echo $this->currencyformat($this->tariff->get_provision_costsharing_limit(), NULL, 0) . " Selbstbeteiligung";

                                                if($this->tariff->get_provision_costsharing_limit() > 0) {
                                                    echo " für " . $costsharing_sector;
                                                }

                                            } elseif ($this->tariff->get_provision_costsharing() == 'yes') {

                                                echo number_format($this->tariff->get_provision_costsharing_percentage()) . " % Selbstbeteiligung";

                                                if ($this->tariff->get_provision_costsharing_percentage() > 0) {
                                                    echo " für " . $costsharing_sector . ", bis max. " . $this->currencyformat($this->tariff->get_provision_costsharing_limit(), NULL, 0);
                                                }

                                            }

                                        }
                                    ?>
                                </li>
                            </ul>
                        </li>
                    <?php endif; ?>

                    <?php if(!$this->is_student && !$this->is_unemployed && !$this->is_servant && !$this->is_child && $this->calculationparameter->get_pdhospital_payout_amount_value() > 0) : ?>
                        <li>
                            <img src="/massets/images/styleguide/pkv-dialog-icons-04.png" alt="Krankentagegeld" />
                            <ul>
                                <li>
                                    <?php echo $this->currencyformat($this->calculationparameter->get_pdhospital_payout_amount_value(), NULL, 0) . " Krankentagegeld " . $this->calculationparameter->get_pdhospital_payout_start_german() ?>
                                </li>
                            </ul>
                        </li>
                    <?php endif; ?>

                    <li>
                        <img src="/massets/images/styleguide/pkv-dialog-icons-06.png" alt="Versicherer" />
                        <ul>
                            <li>
                                <?php
                                    $grade = $this->tariff->get_provider_evaluation_organization_certainty();

                                    if ($grade != ""){

                                        if ($grade=="excellent"){
                                            echo "Hervorragende Unternehmenssicherheit";
                                        } elseif ($grade == "very_good") {
                                            echo "Sehr gute Unternehmenssicherheit";
                                        } elseif ($grade == "good") {
                                            echo "Gute Unternehmenssicherheit";
                                        } elseif ($grade == "satisfy") {
                                            echo "Befriedigende Unternehmenssicherheit";
                                        } elseif ($grade == "sufficient") {
                                            echo "Ausreichende Unternehmenssicherheit";
                                        } elseif ($grade == "insufficient") {
                                            echo "Mangelhafte Unternehmenssicherheit";
                                        }

                                    }
                                ?>
                            </li>
                            <li>
                                <?php
                                    $grade=$this->tariff->get_provider_evaluation_contribution_stability();

                                    if($grade!="") {

                                        if($grade=="excellent") {
                                            echo "Hervorragende Beitragsstabilität";
                                        } elseif($grade=="very_good") {
                                            echo "Sehr gute Beitragsstabilität";
                                        } elseif($grade=="good") {
                                            echo "Gute Beitragsstabilität";
                                        } elseif($grade=="satisfy") {
                                            echo "Befriedigende Beitragsstabilität";
                                        } elseif($grade=="sufficient") {
                                            echo "Ausreichende Beitragsstabilität";
                                        } elseif($grade=="insufficient") {
                                            echo "Mangelhafte Beitragsstabilität";
                                        }

                                    }
                                ?>
                            </li>
                            <li>
                                <?php
                                    $grade = $this->tariff->get_provider_evaluation_customer_focus();

                                    if ($grade != "") {

                                        if ($grade == "excellent") {
                                            echo "Hervorragende Kundenorientierung";
                                        } elseif ($grade == "very_good") {
                                            echo "Sehr gute Kundenorientierung";
                                        } elseif ($grade == "good") {
                                            echo "Gute Kundenorientierung";
                                        } elseif ($grade == "satisfy") {
                                            echo "Befriedigende Kundenorientierung";
                                        } elseif ($grade == "sufficient") {
                                            echo "Ausreichende Kundenorientierung";
                                        } elseif ($grade == "insufficient") {
                                            echo "Mangelhafte Kundenorientierung";
                                        }

                                    }
                                ?>
                            </li>
                        </ul>
                    </li>

                </ul>
            </div>
            <div class="toggle-view" id="tarrif-information">
                <span>schließen</span>
                <span style="display: none">mehr</span>
                <div class="tariff_details_arrow_up"></div>
            </div>
        </div>
        <div class="tariff-box tariff_feature">
            <h2>
                Tarifdetails
            </h2>
            <div class="tariff-row-hidden">
                <div class="tariff_feature_headline"> 
                    Die Leistungen der <?php echo $this->tariff->get_provider_name()?> Krankenversicherung im Detail:
                </div>
                <div class="tariff_features_content">
                    <div class="tariff_feature_part">
                        <div class="tariff_feature_row_head"></div>
                        <div class="tariff_feature_row_content">
                            <div class="column_content_left"></div>
                            <div class="column_content_right"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="toggle-view" id="tariff_feature">
                <span style="display: none">schließen</span>
                <span>mehr</span>
                <div class="tariff_details_arrow_down"></div>
            </div>
        </div>
        <div class="tariff-node tariff-box">

            <div class="tariff-node-child">
                <h2>
                    CHECK24 Tarifnote
                </h2>
            </div>
            <?php if ($this->tariff->is_gold_grade()): ?>
                <div class="grade golden c24-tooltip-trigger">
            <?php else: ?>
                <div class="grade c24-tooltip-trigger">
            <?php endif; ?>
                    <span class="gradeNumber">
                        <?php $this->output(number_format($this->tariff->get_tariff_features()['global']['content']['grade'], 1, ',', NULL), false);?>
                    </span>
                    <span class="tarifflabel">Tarifnote</span>
                    <span class="gradeText <?php echo $grade_text_class; ?>">
                        <?php
                        if($this->tariff->is_gold_grade()) {
                            echo 'Testsieger';
                        } else {
                            echo $grade_text;
                        }
                        ?>
                    </span>
                </div>

            <div class="tariff-row-hidden">
                <span>
                    Unsere PKV-Experten haben für diese Tarifnote folgende Eigenschaften bewertet:
                </span>
                <div class="tariff_grade_table">
                    <ul class="tariff_grade_table_row tariff_grade_table_header_ul">
                        <li class="tariff_grade_table_header column_first">Leistungen</li>
                        <li class="tariff_grade_table_header column_second">Note</li>
                    </ul>
                    <div id="tariff_grade_table_body">
                    </div>
                </div>
            </div>

            <div class="toggle-view" id="tariff_node">
                <span style="display: none">schließen</span>
                <span>mehr</span>
                <div class="tariff_details_arrow_down"></div>
            </div>

        </div>

        <div class="tariff-details tariff-box last-child">
            <h2 class="tariff-details_view_headline">
                Beitragsdetails
            </h2>
            <div class="tariff-row-hidden">
                <div class="tariff_details_block">
                    <div class="tariff_details_headlines">
                        <h3>Der Beitrag setzt sich aus folgenden Bausteinen zusammen</h3>
                    </div>
                    <div class="tariff_details_details">
                        <ul class="cost_details_header">
                            <li>Gesamtbeitrag pro Monat*</li>
                            <li id="tariff_detail_total" class="amount"></li>
                        </ul>
                    </div>
                </div>
                <div id="employee_block" class="tariff_details_block">
                    <div class="tariff_details_headlines">
                        <h3>Ihr Arbeitgeber übernimmt einen Teil des Gesamtbeitrags</h3>
                    </div>
                    <div class="tariff_details_parts">
                    </div>
                </div>
                <div class="tariff_details_block">
                    <div class="tariff_details_headlines">
                        <h3 id="saving_row_headline">Ihr Sparpotenzial</h3>
                    </div>
                    <div class="tariff_details_saving">
                        <ul class="saving_row">
                            <li class="saving">Sie sparen gegenüber der gesetzl. Krankenversicherung jedes Jahr***</li>
                            <li id="saving_amount" class="saving"></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="toggle-view" id="tariff_details">
                <span style="display: none">schließen</span>
                <span>mehr</span>
                <div class="tariff_details_arrow_down"></div>
            </div>
        </div>

        <div class="tariff-box compare-tariff last-child">
            <a href="#" id="tariff-compare-link" data-tariff-version-id="<?php echo $this->tariff->get_tariff_version_id();?>">
                Diesen Tarif mit anderen vergleichen
            </a>
        </div>
    </div>

    <div class="c24-wrapper-button">

    <div class="c24-tariff-detail-subscription_offer">
        <?php
        $this->output(
            '<a class="c24-button-plain-blue c24-button-online full_button" data-ajax="false" href="' . $this->escape(sprintf($uri,'offer')) . '">Angebot anfordern</a>',
            false);
        ?>
    </div>
        <div class="c24-form-transfer-text">
            <img src="/massets/images/styleguide/check_green_12.png">
            <span class="c24-form-transfer-text">Kostenfrei & unverbindlich Angebot anfordern</span>
        </div>
        <div class="c24-tariff-detail-subscription_expert">
            <?php
            $this->output(
                '<a class="c24-button-plain-grey c24-button-online full_button" data-ajax="false" href="' . $this->escape(sprintf($uri,'expert')) . '">Beratung anfordern</a>',
                false);
            ?>
        </div>

        <div class="c24-form-transfer-text">
            <img src="/massets/images/styleguide/check_green_12.png">
            <span class="c24-form-transfer-text">Kostenfrei & unverbindlich vom PKV-Experten <br/>zurückrufen lassen</span>
        </div>
        <div class="tel_footer">
            <div class="tel_headline">
                Haben Sie Fragen?
            </div>
            <div class="tel_number">
                <img src="/massets/images/telefon.png" />
                <a class="tel_number_click" href="tel:08924241272">089 -24 24 12 72</a>
            </div>
            <div class="tel_reachable">
                Mo. bis So. 8:00 - 20:00
            </div>
            <div class="back_to_top">
                <img src="/massets/images/layout/dropdown_arrow.png" />
                <p>zum Seitenanfang</p>
            </div>
        </div>
    </div>
</div>

