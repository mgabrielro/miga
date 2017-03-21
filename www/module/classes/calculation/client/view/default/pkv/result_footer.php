<?php
/*
<div class="c24-content">

    <div class="c24-result-row c24-result-footer" style="display: none">

        <?php

            if (isset($this->paging)) {
                $this->output($this->paging, false);
            }

        ?>

        * Als Differenz zum ausgewählten Vergleichstarif im ersten Belieferungsjahr<br />
        <div class="c24-space10"><!-- --></div>
        <strong>Alle dargestellten Preise sind Bruttopreise einschließlich aller Steuern und Abgaben.</strong><br />

        <?php

            if ($this->get_partner_configuration()->show_check24_tarifupdate_mail() === true) {

                if ($this->partner_id == 1) {

                    $this->output(
                        'Fehlt ein Tarif oder haben Sie einen Fehler gefunden?<br />Dann nehmen Sie bitte Kontakt mit uns auf: <a href="mailto: tarifupdate@tarifvergleich.de">tarifupdate@tarifvergleich.de</a><br />',
                        false
                    );

                } else if ($this->partner_id != 25) {

                    $this->output(
                        'Fehlt ein Tarif oder haben Sie einen Fehler gefunden?<br />Dann nehmen Sie bitte Kontakt mit uns auf: <a href="mailto: tarifupdate@check24.de">tarifupdate@check24.de</a><br />',
                        false
                    );

                }

            }

        ?>

        <div class="c24-space10"></div>

        <?php

            if ($this->partner_id == 24) {
                $link = 'http://www.check24.de/strom-gas/popup/nicht-gelistete-anbieter/';
            } else {
                $link = 'http://vergleich.check24.de/app/form/popup_nicht-gelistete-anbieter.html';
            }

        ?>

        CHECK24 behält sich vor, Anbieter nicht zu listen, wenn bestimmte Kriterien nicht erfüllt sind.<br />
        Eine Übersicht der Anbieter, die derzeit nicht im Vergleichsrechner gelistet werden, finden Sie <a onclick="return $.rs.library.popup('<?php $this->output($link); ?>?popup=1', 650, 350, '', 'yes');" target="_blank" href="<?php $this->output($link); ?>" style="text-decoration: underline;">hier</a>.

    </div>

</div>

<script type="text/javascript">

    $(document).ready(function() {

        $("a.image-link").fancybox({
            'helpers' : {
                'overlay'     : {
                    'css' : {
                        'background' : 'rgba(0, 0, 0, 0)'
                    },
                    'showEarly'   : true
                }
            },
            'closeClick'    : true,
            'openEffect'    : 'elastic',
            'closeEffect'   : 'elastic',
            'openOpacity'   : false,
            'closeOpacity'  : false,
            'openSpeed '    : 'fast'
        });
    });

</script>
<?php
*/
?>
