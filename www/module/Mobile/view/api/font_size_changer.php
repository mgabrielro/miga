<div id="c24-font-size-change" class="c24-clearfix">

    <a id="c24-font-toggle" onclick="font_sizes_toggle();">Schriftgröße ändern</a>

    <span id="c24-font-container">

        <a class="size1 <?php if ($this->current_fontsize == '' || $this->current_fontsize == 'size1') { $this->output('active'); } ?>">A</a>
        <a class="size2 <?php if ($this->current_fontsize == 'size2') { $this->output('active'); } ?>">A</a>
        <a class="size3 <?php if ($this->current_fontsize == 'size3') { $this->output('active'); } ?>">A</a>

    </span>

</div>

<script type="text/javascript">
/* <![CDATA[ */

    var fontClasses = <?php $this->output(json_encode(array('size1', 'size2', 'size3')), false); ?>;
    var font_container = $('#c24-font-container');

    font_sizes_toggle = function() {
        font_container.toggle();
    }

    $(document).ready(function() {

        $('#c24-font-container a').click(function() {

            $('#c24-font-container a').removeClass('active');

            $(fontClasses).each(function(index, fontClass) {
                $('.c24-content').removeClass(fontClass);
            });

            var caller = $(this);

            var sizeClass = caller.attr('class');
            $('.c24-content').addClass(sizeClass);

            $.ajax({
                url: '<?php $this->output($this->ajax_fontsize_link, false); ?>',
                dataType: 'jsonp',
                data: {sizeclass: sizeClass},
                success: function(data) {

                    if (data.status != 200) {
                        alert('Leider konnte die Schriftgröße nicht gespeichert werden. Bitte aktivieren Sie Cookies in ihrem Browser.');
                    }

                    caller.addClass('active');

                }

            });

        });

    });

/* ]]> */
</script>