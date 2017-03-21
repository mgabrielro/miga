<?php $promo_row = ($this->tariff->get_result_position() == 0 && $this->tariff->get_tariff_promotion() != 'no'); ?>
<?php
// We need a unique ID for each tariff. The prefix is made out of the tariff
// version id and its variation key.
// Because a promo row may be twice in the result, we need to add a suffix for
// the case, that it's on pos 0 ($promo_row == true).

$show_additional_seal = (
    $promo_row &&
        true &&
        $this->tariff->get_provider_id() == 7801 &&
        (
            $this->tariff->get_tariff_promotion() === 'exklusivbonus' ||
                $this->tariff->get_tariff_promotion() === 'exklusivbonusoeko'
        )
);


$id_prefix = $this->tariff->get_tariff_version_id() . '-' . $this->tariff->get_tariff_variation_key() . ($promo_row ? '_promorow' : '');
?>
<div class="c24-result-row c24-result-row-energy<?php $promo_row && $this->output(' c24-result-row-energy-promo') ?>" data-tariffversion_id="<?php $this->output($this->tariff->get_tariff_version_id()); ?>" data-tariffversion_variation_key="<?php $this->output($this->tariff->get_tariff_variation_key()); ?>" c24_position="<?php $this->output($this->tariff->get_result_position()); ?>" >

<?php if ($promo_row) { ?>
    <div class="c24-result-promo c24-result-promo-<?php $this->output($this->tariff->get_tariff_promotion()) ?>" id="<?php $this->output($id_prefix . '_promo') ?>"></div>
    <div class="c24-result-promo-tip">Anzeige</div>
<?php } ?>

    <div class="c24-result-tariff-info c24-clearfix">

        <div class="c24-result-row-left">

            <ul class="c24-result-informations">

                <li class="c24-result-provider-name">
                    <?php
                        $this->output($this->tariff->get_provider_comparename());
                    ?>
                </li>

                <?php

                    if ($this->tariff->get_provider_brand() != '') {

                        $this->output('<li class="c24-result-brand-name">', false);
                        $this->output('Marke der ' . $this->tariff->get_provider_brand());
                        $this->output('</li>', false);

                    }

                ?>

                <li class="c24-result-tariff-name">
                    <?php

                        if ($this->tariff->get_tariff_eco() == 'yes') {
                            $this->output('<span class="c24-color-ecogreen">' . $this->escape($this->tariff->get_tariff_name()) . '</span>', false);
                        } else {
                            $this->output('<span class="c24-color">' . $this->escape($this->tariff->get_tariff_name()) . '</span>', false);
                        }

                        if ($this->tariff->get_tariff_commoncarrier() == 'yes') {
                            $this->output('&nbsp;<img class="c24-result-tariff-icons" src="/images/icons/commoncarrier-32x32.gif" width="16" height="16" title="Grundversorgungstarif" />', false);
                        }

                        if ($this->tariff->get_tariff_guidelinematch() == 'no') {
                            $this->output('&nbsp;<img class="c24-result-tariff-icons" src="/images/icons/warning-32x32.png" width="16" height="16" title="Entspricht nicht den Richtlinien" />', false);
                        }

                    ?>
                </li>

                <?php

                    if (isset($this->evaluation)) {

                        if ($this->tariff->get_subscription_possible() == 'yes') {

                            $this->output('<li>', false);
                            $this->output($this->evaluation->get_avg_stars_energy('total'), false);
                            $this->output('</li>', false);

                        }

                    }

                ?>

            </ul>

        </div>
        <div class="c24-result-row-right">

            <div class="c24-clearfix">

                <?php

                    if ($this->tariff->get_tariff_eco() == 'yes') {

                        if ($this->tariff->get_tariff_product_id() == 1 && $this->tariff->get_tariff_eco_type() == 'sustainable') {
                            $this->output('<img class="c24-result-eco-image" src="/images/icons/sunflower-32x32.png" alt="nachhaltiger Ökostrom" height="16" width="16" />', false);
                        } else {
                            $this->output('<img class="c24-result-eco-image" src="/images/icons/eco-32x32.png" alt="Ökostrom" height="16" width="16" />', false);
                        }

                    }

                ?>

                <span class="c24-result-price">
                    <?php $this->output(number_format($this->tariff->get_price_price() / 100, 2, ',', '.') . ' € '); ?>
                </span>

            </div>

            <span class="c24-result-saving">

                <?php

                    if ($this->parameter->get_considerdiscounts() == 'yes') {
                        $this->output('im 1. Jahr<br>', false);
                    } else {
                        $this->output('pro Jahr<br>', false);
                    }

                ?>

                <span class="c24-result-saving-amount">

                    <?php

                        if (round($this->tariff->get_saving_referencetariff(), 2) > 0) {
                            $this->output(number_format($this->tariff->get_saving_referencetariff() / 100, 2, ',', '.') . ' € gespart*');
                        } else if ($this->tariff->get_result_referencetariff() == 'yes') {
                            $this->output('Vergleichstarif');
                        } else {
                            $this->output('keine Ersparnis');
                        }

                    ?>

                </span>

            </span>

        </div>

    </div>

    <div class="c24-result-tariff-info c24-clearfix" style="width: 100%;">

        <span class="c24-result-next <?php if ($this->tariff->get_subscription_possible() == 'no') { echo 'c24-result-next-small'; } ?>">
        </span>

		<div class="c24-result-informations-details-cover" >
	        <ul class="c24-result-informations-details">

	            <?php

                    $infos = $this->row_settings->generate_info_informations();

	                if ($infos !== NULL) {

	                    for ($in = 0, $in_max = count($infos); $in < $in_max; ++$in) {

                            if ($infos[$in]['info'] == 'Tarif entspricht den empfohlenen Einstellungen') {

                                $this->output('<li class="' . $this->escape($infos[$in]['style']) . ' c24-adviced-setting-info">', false);
                                $this->output('<span>' . $infos[$in]['info'] . '</span>', false);
                                $this->output('</li>', false);

                            } else {

                                $this->output('<li class="' . $this->escape($infos[$in]['style']) . '">', false);
                                $this->output('<span>' . $infos[$in]['info'] . '</span>', false);
                                $this->output('</li>', false);

                            }


	                    }

	                }

	            ?>

	        </ul>
        </div>

        <?php

            if ($this->tariff->get_tariff_household_protection_letter_possible()) {
                $this->output('<div class="c24-household-protection"> ', false);
                $this->output('</div>', false);
            }

            if ($show_additional_seal) {
                $this->output('<div class="c24-result-vattenfall-exclusive"> ', false);
                $this->output('</div>', false);
            }

        ?>




    </div>

</div>
