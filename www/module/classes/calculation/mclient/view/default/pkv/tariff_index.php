<?php
//TODO: subject of refactoring thema PVPKV-1335
$this->layout()->tariffs = [
    'Allianz',
    'Alte Oldenburger',
    'ARAG',
    'AXA',
    'Barmenia',
    'Concordia',
    'Continentale',
    'DBV',
    'Deutscher Ring',
    'DKV',
    'Gothaer',
    'Hallesche',
    'HanseMerkur',
    'Inter',
    'LKH',
    'Münchener Verein',
    'Nürnberger',
    'R+V',
    'SdK',
    'Signal Iduna',
    'Universa',
    'Versicherungskammer Bayern',
    'Württembergische'
];

$not_show_pages = [
    'mobile/pkv/tariffdetail',
    'address',
    'converted',
    'mobile/pkv/favorite'
];




?>

<?php if($this->layout()->tariffs && !in_array($this->layout()->step, $not_show_pages)) : ?>

    <div data-role="collapsibleset" data-corners="false" data-theme="a" data-content-theme="a">
        <div data-role="collapsible" class="listItemNoIcon" data-iconpos="right" data-collapsed-icon="carat-d" data-expanded-icon="carat-u">
            <h3>Teilnehmende Versicherungen</h3>

            <div class="tariffIndex">

                <h3>Private Krankenversicherung</h3>

                <p>Bei CHECK24 vergleichen Sie knapp 3.500 Tarifkombinationen von <?php echo count($this->layout()->tariffs) ?> Unternehmen für die Private Krankenversicherung.*
                    <br />
                    (Stand: <?php echo date('d.m.Y');?>)
                </p>

                <table class="tariffIndex-list">
                    <thead>
                    <tr>
                        <td>Versicherer</td>
                        <!-- <td>Tarif</td> -->
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach($this->layout()->tariffs as $tariff): ?>
                        <tr>
                            <td><?php echo $tariff ?></td>
                            <!-- <td><?php //echo $tariff['provider_name'] ?></td> -->
                            <!-- <td><?php //echo $tariff['tariff_name'] ?></td> -->
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>

                <p>
                    Aufgrund technischer Restriktionen können die Tarife der folgenden Versicherer derzeit im Vergleichsergebnis
                    nicht angezeigt werden, der Vergleich kann jedoch im Telefonat mit unseren PKV-Experten durchgeführt werden:
                    DEVK, Union
                </p>

                <p>
                    Eine Auswahl von im Moment nicht in unserem Vergleich enthaltenen Versicherungsunternehmen finden Sie
                    hier: Central, Debeka, HUK-Coburg, LVM, Mecklenburgische, Pax Familienfürsorge, Provinzial
                </p>

                <p>
                    * Aufgrund laufender Updates einzelner Tarife, technischer Probleme oder eingeschränkter Verfügbarkeiten
                    kann es vorkommen, dass einzelne Versicherer oder Tarife kurzzeitig nicht berechnet oder angezeigt werden können.
                </p>

            </div>
        </div>
    </div>

<?php endif; ?>