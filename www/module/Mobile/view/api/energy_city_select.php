
<?php $form_data = $this->form->get_data() ?>
<div id="c24OverlayLayerc24CitySelector" class="c24-overlay-city-selector">

    <div class="c24FrameContentPadding" style="border-width: 3px;" id="c24CitySelector">
        <h3><strong>Orts Auswahl:</strong></h3>

        <table class="c24Table">

            <tr>
                <td colspan="2">Zu Ihrer Postleitzahl <strong id="zipcode_city_select"><?php $this->output($form_data['c24api_zipcode'], false) ?></strong> gibt es mehrere Orte.</td>
            </tr>

            <tr>
                <td class="c24TableCellLeft" width="40%">
                    <span id="city_label">Ort:</span>
                    <span id="city_error" class="OverlayErrorText"></span>
                </td>
                <td width="60%">
                    <?php
                        $this->output(
                            ' ' . $this->form->generate_select_field('c24api_city',
                            array('id' => 'city_select')), false
                        );
                    ?>
                </td>
            </tr>

        </table>

        <div class="space5"><!-- --></div>


        <?php if ($this->partner_id == 24) { ?>
            <input value="weiter" type="submit" name="recalc" onclick="return submit_city_select();" />
        <?php } else if ($this->get_style('image_back') == '') { ?>
                <input type="submit" name="recalc" class="FormButtonUpdate" value="weiter" onclick="return submit_city_select();" />
        <?php } else { ?>
                <input type="submit" value=" " class="c24RegisterNext" onclick="return submit_city_select();" />
        <?php } ?>

    </div>

</div>

<script type="text/javascript">

/* <![CDATA[ */

    var show_city = <?php echo (count($this->form->get_options('c24api_city')) > 1 && $form_data['c24api_city'] == '') ? 'true' : 'false' ?>

    $(document).ready(function() {

        register_overlay();

        if (show_city) {
            open_overlay();
        }

    });

    register_overlay = function() {

        var overlay = $.rs.overlay.getInstance();
        overlay.setOptions({
            onClick: function() {
            },
            beforeEsc: function() {
                return false;
            },
            onEsc: function() {
            },
            appendTo: $('#c24Frame')
        });

    }

    open_overlay = function() {

        $('#zipcode_city_select').text($('#zipcode').val());

        var overlay = $.rs.overlay.getInstance();
        var opts = {
            css: {
                width: '350px'
            },
            id: 'c24CitySelector'
        };

        if (top != self) {
            opts.top = 100;
        }

        overlay.show(opts);

    }

    submit_city_select = function() {

        $('#city_label').removeClass('FormError');
        $('#city_error').text('');
        var city = $('#city_select').val();

        if (city == '') {
            $('#city_label').addClass('FormError');
            $('#city_error').text('Bitte wählen.');
        } else {
            $('#c24api_city').val(city);
            $('#resultform').submit();
        }

        return false;

    };

/* ]]> */
</script>
