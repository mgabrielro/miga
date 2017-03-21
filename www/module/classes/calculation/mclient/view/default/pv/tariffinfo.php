<?php

$pos                  = $this->tariff->get_result_position();
$pro                  = $this->tariff->get_tariff_promotion();
$promotion            = $this->tariff->is_promo_tariff();
$promotion_reordered  = $this->tariff->is_promo_reordered_tariff();
$promotion_title      = $this->tariff->get_tariff_promotion_bin($this->parameter->get_profession());

if ($promotion) {
    $promo_class = 'c24-result-row-promo c24-promo-div';
} else if ($promotion_reordered) {
    $promo_class = 'c24-result-row-promo-reordered c24-promo-reordered-div';
} else {
    $promo_class = '';
}

$tariff_link                     = ($this->tariff_detail_link ? $this->tariff_detail_link : '');

$tariff_grade_helper             = new \classes\calculation\client\controller\helper\generate_tariffgrade_pkv($this->tariff);
$tariff_grade_helper->set_calculation_parameter_id($this->parameter->get_id());

$grade_text                      = $tariff_grade_helper->get_grade_description($this->tariff->get_tariff_grade_result());
$grade_text_class                = $tariff_grade_helper->get_grade_text_class();

$profession                      = $this->parameter->get_profession();
$insured_person                  = $this->parameter->get_insured_person();

$is_employee                     = $profession === \classes\calculation\client\model\parameter\pkv::PROFESSION_EMPLOYEE;
$is_child                        = $insured_person === \classes\calculation\client\model\parameter\pkv::INSURED_PERSON_CHILD;
$is_servant_child                = ($is_child && $this->parameter->get_parent_servant_or_servant_candidate() === 'yes');
$is_servant_or_servant_candidate = ($profession == \classes\calculation\client\model\parameter\pkv::PROFESSION_SERVANT || $profession == \classes\calculation\client\model\parameter\pkv::PROFESSION_SERVANT_CANDIDATE);

$favorite_contribution           = ($is_employee && !$is_child) ? $this->tariff->get_paymentperiod_size_net_contribution() : $this->tariff->get_paymentperiod_size();
$is_favorite_page                = isset($this->is_favorite_page) ? $this->is_favorite_page : false;

$is_favorite_class               = ($this->tariff->is_favorite_tariff()) ? 'is-favorite' : "";
$trash_icon_class                = ($is_favorite_page) ? "trash-icon" : "";

$favorite_price_difference_class = $is_favorite_page && ($this->tariff->get_price_difference_text() != '') ? 'on' : 'off';

?>

<div id="c24-tariff-detail" class="<?php echo $promo_class ?>">

    <div class="c24-result-tariff-info c24-link" data-link-exclude="c24-info-icon-tooltip" data-link="<?php $this->output($tariff_link); ?>">

        <div class="c24-result-top-row c24-clearfix">

            <?php if ($promotion || $promotion_reordered): ?>
                <div class="c24-result-promo-tip">
                    <?php echo $this->output($promotion_title, false); ?>
                </div>
            <?php endif; ?>

            <div class="c24-result-tariff-header">

                <?php if (!$is_favorite_page): ?>

                    <?php if ($this->tariff->get_result_position()): ?>
                        <div class="c24-result-tariff-position">
                            <?php echo $this->tariff->get_result_position() . '.'; ?>
                        </div>
                    <?php endif; ?>

                <?php endif; ?>

                <div class="c24-result-tariff-logo tariffinfo">
                    <img src="<?php $this->output($this->tariff->get_provider_logo('svg'), false); ?>"
                         alt="<?php $this->output($this->tariff->get_provider_comparename()); ?>">
                </div>

            </div>

            <?php if ($promotion_reordered): ?>
                <div class="result-row-right-icons promo-favorite-icon-position">
            <?php else: ?>
                <div class="result-row-right-icons">
            <?php endif; ?>

                    <div class="my-favorite <?php echo $is_favorite_class; ?> <?php echo $trash_icon_class; ?>"
                         data-favorite-calculation-parameter-id="<?php echo $this->parameter->get_id(); ?>"
                         data-favorite-tariffversion-id="<?php echo $this->tariff->get_tariff_version_id(); ?>"
                         data-favorite-tariffversion-variaton-key="<?php echo $this->tariff->get_tariff_variation_key(); ?>"
                         data-favorite-is-promo-tariff="<?php echo $this->tariff->is_promo_tariff() ? 'yes' : 'no'; ?>"
                         data-favorite-promotion-type="<?php echo $this->tariff->get_promotion_type(); ?>"
                         data-favorite-is-gold-grade="<?php echo ($this->tariff->is_gold_grade() == 1) ? 'yes' : 'no'; ?>"
                         data-favorite-contribution="<?php echo $favorite_contribution; ?>">
                    </div>
                </div>
                <div class="c24-result-tariff-name">
                    <ul class='c24-result-tariff-name-list'>
                        <li class="c24-result-tariff-name-list-content">
                        <?php
                            echo 'Tarif: ' . $this->tariffnameFormater($this->tariff->get_tariff_name());
                        ?>
                        </li>
                        <?php
                            $icon = $this->partial('mclient/view/default/pkv/tariff_name_tooltip_partial.php',[
                                'title'   => 'Tarifbausteine',
                                'content' => $this->tariffnameFormater($this->tariff->get_tariff_name())
                            ]);
                        ?>
                        <div class="tooltip-wrapper"><?php echo $icon ?></div>
                    </ul>
                </div>

            <div class="c24-wrapper-tariff-informations tariff_information_result">

                <div class="c24-result-row-middle">
                   <div class="result-middle">
                       <div class="feature-list">
                      <ul class="c24-tariff-informations">
                        <?php if (!$is_servant_child && $is_child && $this->tariff->get_provision_children_costsharing_amount() == 0): ?>
                            <li class="check_green">Keine Selbstbeteiligung für Kinder</li>
                        <?php elseif ($is_child && !$is_servant_child): ?>
                            <li class="check_<?php echo $this->tariff->get_tariff_feature1_color_for_children(); ?>"><?php echo $this->currencyformat($this->tariff->get_provision_children_costsharing_amount(), NULL, 0); ?> Selbstbeteiligung p.a.</li>
                        <?php else: ?>
                          <?php if(!empty($this->tariff->get_tariff_feature1_tooltip())){ ?>
                            <li class="check_<?php echo $this->escapeHtml($this->tariff->get_tariff_feature1_color()) ?>"><?php echo $this->escapeHtml($this->tariff->get_tariff_feature1_tooltip()) ?></li>
                          <?php } endif; ?>

                        <?php //See ticket PVPKV-3148 for the str_replace sentence ?>

                        <?php if(!empty($this->tariff->get_tariff_feature2_tooltip())){ ?>
                        <li class="check_<?php echo $this->escapeHtml($this->tariff->get_tariff_feature2_color()) ?>"><?php echo $this->escapeHtml(str_replace('-Behandlung', '', $this->tariff->get_tariff_feature2_tooltip())) ?></li>
                        <?php } if(!empty($this->tariff->get_tariff_feature3_tooltip())){ ?>
                        <li class="check_<?php echo $this->escapeHtml($this->tariff->get_tariff_feature3_color()) ?>"><?php echo $this->escapeHtml($this->tariff->get_tariff_feature3_tooltip()) ?></li>
                        <?php } if(!empty($this->tariff->get_tariff_feature4_tooltip())){ ?>
                        <li class="check_<?php echo $this->escapeHtml($this->tariff->get_tariff_feature4_color()) ?>"><?php echo $this->escapeHtml($this->tariff->get_tariff_feature4_tooltip()) ?></li>
                        <?php } ?>
                    </ul>
                    </div>
                       <div class="grade-box">
                           <?php if ($this->tariff->is_gold_grade()): ?>
                           <div class="grade golden c24-tooltip-trigger">
                               <?php else: ?>
                               <div class="grade c24-tooltip-trigger">
                                   <?php endif; ?>

                                   <span class="gradeNumber"><?php $this->output(number_format($this->tariff->get_tariff_grade_result(), 1, ',', NULL), false);?></span>
                                   <span class="tarifflabel">Tarifnote</span>
                                   <span class="gradeText <?php echo $grade_text_class; ?>">
                                <?php echo ($this->tariff->is_gold_grade()) ? 'Testsieger' : $grade_text; ?>
                            </span>
                               </div>
                           </div>
                       </div>
                   </div>
                </div>

                <div class="c24-clearfix interferrer-breaker">
                    <?php include 'module/classes/calculation/mclient/view/default/pv/tariff_interferer.phtml'; ?>
                </div>

            <?php if ($is_employee && !$is_child): ?>
        <div class="c24-clearfix tariff_bottom">
            <div class="c24-result-row-left">

                <div class="wrapper-price">
                    <span class="price-text">
                        Beitrag pro Monat
                    </span>
                    <span class="result-price">
                            <?php echo $this->currencyformat($this->tariff->get_paymentperiod_size()); ?>
                    </span>
                </div>

                <div class="wrapper-employee-part">
                    <span class="employee-part-text">Ihr Anteil*</span>
                    <span class="employee-part">
                        <?php echo $this->currencyformat($this->tariff->get_paymentperiod_size_net_contribution()) ?>
                    </span>

                </div>

                <?php $wrapper_saving_price_class = ($this->tariff->get_paymentperiod_size_net_saving() > 0) ? 'on' : 'off'; ?>
                <?php $saving_price_text          = $wrapper_saving_price_class == 'on' ? 'Gespart pro Jahr**' : ''; ?>
                <?php $saving_price_value         = $wrapper_saving_price_class == 'on' ? $this->currencyformat($this->tariff->get_paymentperiod_size_net_saving_per_year()) : ''; ?>

                <div class="wrapper-saving-price <?php echo $wrapper_saving_price_class ?>">
                    <span class="saving-price-text">
                        <?php echo $saving_price_text ?>
                    </span>
                                <span class="saving-price">
                         <?php echo $saving_price_value ?>
                    </span>
                </div>

                <?php if($is_favorite_page): ?>
                    <div class="favorite-employee-price-difference <?php echo $favorite_price_difference_class; ?>">
                        <?php echo $this->tariff->get_price_difference_text(); ?>
                    </div>
                <?php endif; ?>

            </div>
            <?php else: ?>
            <div class="c24-clearfix tariff_bottom no-employee">
            <div class="c24-result-row-left">

                    <?php //@ToDo: Style this properly ?>
                    <div class="wrapper-employee-part" style="text-align: right;">
                        <span class="employee-part-text">monatlich</span>
                        <span class="not-empoyee-part">
                            <?php echo $this->currencyformat($this->tariff->get_paymentperiod_size()); ?>
                        </span>

                        <?php if($is_favorite_page): ?>
                            <div class="favorite-price-difference <?php echo $favorite_price_difference_class; ?>">
                            <?php echo $this->tariff->get_price_difference_text(); ?>
                            </div>
                        <?php endif; ?>

                    </div>

                </div>
            <?php endif; ?>

            <?php include 'module/Mobile/view/common/special_action.phtml'; ?>

    </div>
</div>
</div>
</div>
