<div class="c24-energy-ajax-container c24-clearfix">

    <a href="javascript: void(0);" class="c24-close" onclick="return c24_tariffdetail_close(this);"><!-- --></a>

    <div class="c24-ajax-container-right">

        <?php

            if ($this->tariff->get_provider_logo() != '') {
                $this->output('<div class="c24-ajax-container-content"><img src="' . $this->escape($this->tariff->get_provider_logo()) . '" alt="' . $this->escape($this->tariff->get_provider_name())  . '" title="' . $this->escape($this->tariff->get_provider_name()) . '" /></div>', false);
            } else {
                $this->output('<div class="c24-ajax-container-content"><strong>' . $this->tariff->get_provider_name() . '</strong></div>', false);
            }

            if ($this->tariff->get_provider_brand() != '') {
                $this->output('<div class="c24-ajax-container-content"><strong>' . $this->escape('Marke der ' . $this->tariff->get_provider_brand()) . '</strong></div>', false);
            }

            $this->output('<div class="c24-ajax-container-content"><strong>' . $this->escape($this->tariff->get_tariff_name()) . '</strong></div>', false);

        ?>

    </div>

    <?php
        $this->output($this->pricelayer, false);
    ?>

</div>