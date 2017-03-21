<!--<div id="c24-dialog-bar-content">
    <div id="c24_topbar" class="c24s c24Evolution">
        <h1><?php
            echo(get_def('product_f/' . $this->product_id));
            ?></h1>
        <div class="mod24TopbarData khv_result clearfix" style="padding-top: 0px!important;font-size: 12px!important;">
                <span class="box24Part">
                Geburtsdatum der versicherten Person:
                    <?
                    $date = date_create($this->parameter->get_birthdate());
                    echo('<b>' . date_format($date, 'd.m.Y') . '</b>'); ?>
                </span>
        </div>
    </div>
</div>-->