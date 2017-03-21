<?php
/** @var \classes\calculation\mclient\model\tariff\pkv $tariff */
$tariff = $this->tariff;
?>

<div class="c24-result-row"
     data-tariff-version-id="<?php echo $tariff->get_tariff_version_id();?>"
     data-provider="<?php echo $tariff->get_provider_name()?>"
     data-price="<?php echo $tariff->get_price_gross_total()?>"
     data-tariffgrade="<?php echo $tariff->get_tariff_grade_result()?>"
     data-is-gold-grade="<?php echo $tariff->is_gold_grade()?>"
    <?php if ($tariff->is_promo_tariff()): ?>
        data-promo="<?php echo $tariff->get_promotion_position()?>"
        data-promotiontype="<?php echo $tariff->get_promotion_type()?>"
    <?php endif; ?>
    <?php if (isset($this->favorite_id)): ?>
        data-favorite-id="<?php echo $this->favorite_id; ?>"
    <?php else: ?>
        data-favorite-id="0"
    <?php endif; ?>
>
    <span class="checkbox compare-checkbox hidden" data-tariff-version-id="<?php echo $tariff->get_tariff_version_id();?>"></span>

    <a class="scroll-anchor" name="tariff-<?php echo $tariff->get_tariff_id();?>"></a>
    <?php $this->output($this->render('default/pv/tariffinfo.php'), false);?>
</div>
