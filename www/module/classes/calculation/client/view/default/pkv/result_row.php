<?php
    $tariff = $this->tariff;
    $secondary_tariff = $this->secondary_tariff;
    $overall_rating = $this->rating_overview()->overview($tariff->get_feedback_provider_id());

    $promo_css = ($this->promo_tariff) ? 'promo':  '';
    $action_promo_banner_css = ($this->promo_tariff || $tariff->has_special_action_running()) ? 'action-promo-banner' : '';
?>
<div class="c24-result-row <?php echo $promo_css . ' ' . $action_promo_banner_css;  ?>" data-tab-parent>
    <div class="row-header">

        <?php if ($this->promo_tariff): ?>
            <div class="promo_ribbon">

                <p class="title"><?php $this->output($this->tariff_promotion_title, false); ?></p>

                <?php if ($this->tariff_promotion_text) { ?>
                <span class="c24-tooltip" data-direction="up" data-trigger="click">
                    <div class="info_circle"></div>
                    <span class="c24-tooltip-content">
                        <div class="c24-tooltip-arrow up"></div>
                        <div class="c24-tooltip-close"></div>
                        <?php $this->output($this->tariff_promotion_text, false); ?>
                    </span>
                </span>
                <?php } ?>

            </div>
        <?php endif; ?>

        <?php if($tariff->has_special_action_running()): ?>
             <?php include 'module/Application/view/common/special_action.phtml'; ?>
        <?php endif; ?>
    </div>
    <div class="row-content">

        <div class="row-column column_checkbox">

            <?php
                $this->output('
                <div class="c24-er-element c24-content-row ui-checkbox c24-content-row-info " id="checkbox_compare_' . $this->tariff_variation_key . $this->promo_tariff . '_container" style="">
                    <div class="c24-checkbox c24-content-row-block">
                        <div class="c24-fe-cb bg c24-content-row-info-content">
                            <input type="hidden" name="checkbox_compare_' . $this->tariff_variation_key . $this->promo_tariff . '" value="no">
                            <input type="checkbox" class="compare_checkbox" name="checkbox_compare_' . $this->tariff_variation_key . $this->promo_tariff . '" tabindex="12" class="" id="checkbox_compare_' . $this->tariff_variation_key . $this->promo_tariff . '" value="' . $this->tariff_variation_key . '" >
                            <label class="c24-cb-text" for="checkbox_compare_' . $this->tariff_variation_key . $this->promo_tariff . '">&nbsp;</label>
                        </div>
                    </div>
                </div>', false);

            ?>

            &nbsp;
        </div>

        <?php echo $this->helper->tariff_price($tariff, $secondary_tariff, $this->backdating); ?>

        <div class="row-column column_provider">

            <img src="<?php $this->output($tariff->get_provider_logo(), false); ?>"
                 alt="<?php $this->output($tariff->get_provider_comparename()); ?>" class="tariff_provider_logo">

            <p class="tariff_name"><?php $this->output($tariff->get_tariff_name(), false); ?></p>

        </div>

        <div class="row-column column_tariff_grade">
                <?php $this->output($this->helper->compare_note($tariff), false); ?>
        </div>

        <div class="row-column column_tariff_features">
            <?php include 'module/Application/view/application/helper/tariff_features.phtml'; ?>
        </div>

        <?php $this->output($this->request_offer_button, false); ?>
    </div>
    <div class="row-footer">

        <div class="row-column column_testfeedback">
            <div class="column_tab">
                <?php if ($this->test_reports()->has_reports($tariff->get_feedback_provider_id())) { ?>
                    <div class="tab_trigger" data-tab="testfeedback">Testberichte</div>
                <?php } else { ?>
                    <span class="disabled">Testberichte</span>
                <?php } ?>
            </div>
        </div>

        <div class="row-column column_customerfeedback">
            <div class="column_tab">
                <?php if (isset($overall_rating) && $overall_rating->total_ratings >= 10): ?>
                    <a href="javascript:void(0);" class="tab_trigger" data-tab="customerfeedback">
                        <?php $this->output($overall_rating->total_ratings);?> Kundenbewertungen
                        <?php echo $this->stars()->render($overall_rating->avg_stars); ?>
                    </a>
                <?php else: ?>
                    <span class="disabled">Keine Bewertungen</span>
                    <div class="stars star0"></div>
                <?php endif; ?>
            </div>
        </div>

        <div class="row-column column_tariffdetails">
            <div class="column_tab">
                <div class="tab_trigger" data-tab="tariffdetails">Tarifleistungen</div>
            </div>
        </div>

        <div class="tab_content tab_testfeedback">
            <div class="close_tab_holder">
                <div data-tab-close class="close_tab"></div>
            </div>

            <h3>Die neusten Testberichte für die <?php echo $tariff->get_provider_name() ?></h3>

            <?php echo $this->test_reports()->render_reports($tariff->get_feedback_provider_id()); ?>
        </div>

        <div class="tab_content tab_customerfeedback">
            <div class="close_tab_holder">
                <div data-tab-close class="close_tab"></div>
            </div>
            <?php echo $this->rating_overview()->render_diagram($tariff->get_feedback_provider_id()); ?>
            <?php echo $this->customer_reviews()->render($tariff->get_feedback_provider_id()); ?>
        </div>
        <div class="tab_content tab_tariffdetails">
            <div class="close_tab_holder">
                <div data-tab-close class="close_tab"></div>
            </div>
            <?php $this->output($this->tariffdetails_html, false); ?>
            <a data-compare-link="<?php echo $this->compare_link; ?>" class="tariffdetails-compareLink">Alle Leistungen im Detailvergleich »</a>
        </div>
    </div>
</div>