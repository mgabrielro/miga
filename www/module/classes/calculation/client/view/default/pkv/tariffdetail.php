<?php
/* @var $this \shared\classes\calculation\client\view
 */
//$this->output($this->render('default/pv/tariffinfo.php'), false);

$promotion = ($this->tariff->get_tariff_promotion() == 'yes');
$tariff_link = ($this->tariff_detail_link ? $this->tariff_detail_link : '');
$promotion_class = ($promotion) ? 'c24-promo-div': '';
$style_star = 'star0';

    if (!empty($this->customerfeedback)) {

        switch ($this->customerfeedback['stars']) {

            case 0:    $style_star = 'star0';
                break;
            case 0.5:  $style_star = 'star05';
                break;
            case 1:    $style_star = 'star1';
                break;
            case 1.5:  $style_star = 'star15';
                break;
            case 2:    $style_star = 'star2';
                break;
            case 2.5:  $style_star = 'star25';
                break;
            case 3:    $style_star = 'star3';
                break;
            case 3.5:  $style_star = 'star35';
                break;
            case 4:    $style_star = 'star4';
                break;
            case 4.5:  $style_star = 'star45';
                break;
            case 5:    $style_star = 'star5';
                break;

        }

    }


?>
<?php

    if (count($this->tariff_history) > 2) {

        ?>

        <div class="c24-tariff-history">
            <h1>Erneut anzeigen</h1>
            <table>
                <tr>
                    <td>
                        <div class="left_arrow">
                            <i class="fa fa-caret-left"></i>
                        </div>
                    </td>
                    <td class="tariff_logos">
                        <div style="height: 40px;width: 100%;position: relative;">
        <?php

        foreach ($this->tariff_history AS $tariff) {

            $this->output('<a href="' . $tariff['link'] . '" data-ajax="false">
                            <div class="tariff_logo">
                                <img src="' . $tariff['logo'] . '">
                            </div>
                        </a>', false);

        }

        ?>
                        </div>
                    </td>
                    <td>
                        <div class="right_arrow">
                            <i class="fa fa-caret-right"></i>
                        </div>
                    </td>
                </tr>
            </table>
        </div>

    <?php

    }

    ?>

<div class="c24_tariff-overview <?php $this->output($promotion_class, false);?>">

    <h1>Ihr unverbindliches Angebot</h1>

    <?php

    if ($promotion) {

        $promotion_title = $this->tariff->get_tariff_promotion_title();

        ?>

        <div class="c24-promo-banner c24-clearfix">
            <div class="c24-result-promo-tip">Tipp</div>
            <div class="c24-result-promo c24-result-promo">
                <?php
                ($promotion_title) ? $this->output($promotion_title, false) : '';
                ?>
            </div>
        </div>

    <?php

    }

    ?>

    <div class="row">
        <div class="column" style="width: 70%">
            <div class="row">
                <img src="<?php $this->output($this->tariff->get_provider_logo(), false); ?>"
                     alt="<?php $this->output($this->tariff->get_provider_comparename()); ?>" class="logo">
            </div>
            <div class="row" style="margin-bottom: 10px;">
                    <b>Tarif:</b>
                    <?php
                    $this->output($this->tariff->get_tariff_name(), false);
                    ?>
            </div>
            <div class="row">
                <div class="column" style="width: 62%;">
                    <b>Versicherungssumme</b>
                </div>
                <div class="column align_right" style="width: 36%;">
                    <?php $this->output(number_format($this->parameter->get_data('insure_sum'), 0, ',', '.'), false); ?> &euro;
                </div>
            </div>
            <div class="row">
                <div class="column" style="width: 62%">
                    <b>Laufzeit</b>
                </div>
                <div class="column align_right" style="width: 36%;">
                    <?php $this->output($this->parameter->get_data('insure_period'), false); ?> Jahre
                </div>
            </div>
            <hr>
            <ul class="c24-result-informations-details">
                <li class="green_checkmark_small checkmark"><span>Absicherung im Todesfall</span></li>
    <?php

    if ($this->tariff->get_provider_id() != 82) {

        $txt = ($this->tariff->get_data()['tariff']['product_dependent_features']['preliminary_insurance_cover'] == 'no')
            ? 'Kein sofortiger Versicherungsschutz': 'Sofortiger Versicherungsschutz';

        $this->output('<li class="green_checkmark_small checkmark"><span>' . $txt . '</span></li>', false);

    }

    if ($this->tariff->get_provider_id() != 80 && $this->tariff->get_provider_id() != 82) {

        if ($this->customerfeedback['rate']) {
            $this->output('<li class="green_checkmark_small checkmark"><span>' . $this->customerfeedback['rate'] . '% Weiterempfehlung</span></li>', false);
        }

    } else {
        $this->output('<li class="green_checkmark_small checkmark"><span>Top 10 Risikoleben</span></li>', false);
    }

    ?>
            </ul>
        </div>
        <div class="column align_right" style="width:28%;">
            <div class="row" style="margin-top: 7px;">
                <div class="column">
                    <span class="c24-result-price">
                         <?php $this->output(number_format($this->tariff->get_paymentperiod_size(), 2, ',', '.') . ' &euro;', false); ?>
                    </span>
                    <span class="c24-result-saving">
    <?php

    switch ($this->tariff->get_paymentperiod_period()) {

        case 'year':
            $this->output('jährlich');
            break;
        case 'semester':
            $this->output('halbjährlich');
            break;
        case 'quarter':
            $this->output('vierteljährlich');
            break;
        case 'month':
            $this->output('monatlich');
            break;

    }

    ?>
                </span>
                </div>
            </div>
            <div class="row" style="margin-top: 11px;">
                <div class="column">
                    <div class="grade golden c24-tooltip-trigger">
                        <span class="tarifflabel">Tarifnote</span>
                        <span class="gradeNumber"><?php $this->output(number_format($this->tariff->get_tariff_grade_result(), 1, ',', NULL), false);?></span>
                        <span class="gradeText  golden"><?php $this->output($this->tariff->get_tariff_grade_name(), false);?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?

    // show the tariff special action
    include_once 'module/Application/view/common/special_action.phtml';

    ?>
</div>


<div class="c24-tariff-detail-subscription">

    <?php
    $this->output(
        '<a class="c24-button-plain-blue c24-button-online full_button" data-ajax="false" href="' . $this->escape($this->subscription_url) . '">
        weiter zu Adressdaten
        <div class="subtext">(Schritt 1 von 2)</div>
        </a>', false);
    ?>

</div>


<div data-role="collapsibleset" data-corners="false" data-theme="a" data-content-theme="a">
    <div data-role="collapsible" class='listItemNoIcon c24-tariffdetails tariff_accordion' data-iconpos="right" data-collapsed-icon="carat-d" data-expanded-icon="carat-u">
        <h3><i class="fa fa-tachometer"></i> Tarifleistungen</h3>
        <?php $this->output($this->render('default/helper/pkv.php'), false); ?>
    </div>
    <div data-role="collapsible" class='listItemNoIcon tariff_accordion' data-iconpos="right" data-collapsed-icon="carat-d" data-expanded-icon="carat-u">
        <h3><i class="fa fa-th"></i> Testberichte</h3>
        <div class="c24-efeedbacktests">

            <h3>
                Die neuesten Testberichte für die <?php echo $this->tariff->get_provider_comparename(); ?></b>
            </h3>

    <?php

    if ($this->efeedbacktests && isset($this->efeedbacktests['report'])) {

        foreach ($this->efeedbacktests['report'] AS $tests) {

            ?>

            <div class="c24-efeedbacktest">
                <div class="c24-efeedbacktest-text">
                    <h1><?php echo $tests['TestReportTitle'] ?></h1>
                    <h2><?php echo $tests['TestDate'] ?></h2>
                    <img src="<?php echo $tests['TestMediumLogo'] ?>">
                    <?php echo $tests['TestTextLong']; ?>
                </div>
            </div>

        <?php

        }

    } else {

        ?>
        <p>
            Für den aktuellen Tarif sind keine Testberichte vorhanden.
        </p>
    <?php

    }
    ?>
        </div>
    </div>
    <div data-role="collapsible" class='listItemNoIcon tariff_accordion' data-iconpos="right" data-collapsed-icon="carat-d" data-expanded-icon="carat-u">
        <h3><i class="fa fa-comments"></i> Kundenmeinungen
        <?php
        $this->output('<div class="starempty14"><div class="starfull14 ' . $style_star . '"></div></div> ', false);
        ?>
        </h3>
        <div class="c24-customerfeedback">

    <?php

    if (empty($this->customerfeedback)) {

        ?>

                <p>
                    Bei diesem Tarif sind aktuell keine Kundenmeinungen vorhanden.
                </p>

    <?php

    } else {

        $this->output('<div class="starempty14">
                            <div class="starfull14 ' . $style_star . '"></div>
                       </div> ' . $this->customerfeedback['stars'] . ' von 5', false);

        $stars = [
            5 => ['count' => $this->customerfeedback['rate10'] + $this->customerfeedback['rate9']],
            4 => ['count' => $this->customerfeedback['rate8'] + $this->customerfeedback['rate7']],
            3 => ['count' => $this->customerfeedback['rate6'] + $this->customerfeedback['rate5']],
            2 => ['count' => $this->customerfeedback['rate4'] + $this->customerfeedback['rate3']],
            1 => ['count' => $this->customerfeedback['rate2'] + $this->customerfeedback['rate1']],
        ];

        foreach ($stars AS $star => $value) {
            $stars[$star]['percent'] = ($value['count'] / $this->customerfeedback['total_count']) * 100;
        }

        $this->output('
                    <table class="table star-table">
                       <tbody>
                          <tr>
                             <td><span class="star-table-key-column">5 Sterne</span></td>
                             <td class="progress-bar-column">
                                <div class="row ng-isolate-scope" width="' . $stars[5]['percent'] . '" hide-percentage="true">
                                   <div class="col-xs-12 progress">
                                      <div data-percentage="0%" style="width:' . $stars[5]['percent'] . '%" class="progress-bar progress-bar-success" role="progressbar" aria-valuemin="0" aria-valuemax="100">    </div>
                                      <!-- ngIf: !hidePercentage -->
                                   </div>
                                </div>
                             </td>
                             <td class="star-table-value-column ng-binding">' . $stars[5]['count'] . '</td>
                          </tr>
                          <tr>
                             <td><span class="star-table-key-column">4 Sterne</span></td>
                             <td>
                                <div class="row ng-isolate-scope" width="' . $stars[4]['percent'] . '" hide-percentage="true">
                                   <div class="col-xs-12 progress">
                                      <div data-percentage="0%" style="width:' . $stars[4]['percent'] . '%" class="progress-bar progress-bar-success" role="progressbar" aria-valuemin="0" aria-valuemax="100">    </div>
                                      <!-- ngIf: !hidePercentage -->
                                   </div>
                                </div>
                             </td>
                             <td class="star-table-value-column ng-binding">' . $stars[4]['count'] . '</td>
                          </tr>
                          <tr>
                             <td><span class="star-table-key-column">3 Sterne</span></td>
                             <td>
                                <div class="row ng-isolate-scope" width="' . $stars[3]['percent'] . '" hide-percentage="true">
                                   <div class="col-xs-12 progress">
                                      <div data-percentage="0%" style="width: ' . $stars[3]['percent'] . '%;" class="progress-bar progress-bar-success" role="progressbar" aria-valuemin="0" aria-valuemax="100">    </div>
                                      <!-- ngIf: !hidePercentage -->
                                   </div>
                                </div>
                             </td>
                             <td class="star-table-value-column ng-binding">' . $stars[3]['count'] . '</td>
                          </tr>
                          <tr>
                             <td><span class="star-table-key-column">2 Sterne</span></td>
                             <td>
                                <div class="row ng-isolate-scope" width="' . $stars[2]['percent'] . '" hide-percentage="true">
                                   <div class="col-xs-12 progress">
                                      <div data-percentage="0%" style="width: ' . $stars[2]['percent'] . '%;" class="progress-bar progress-bar-success" role="progressbar" aria-valuemin="0" aria-valuemax="100">    </div>
                                      <!-- ngIf: !hidePercentage -->
                                   </div>
                                </div>
                             </td>
                             <td class="star-table-value-column ng-binding">' . $stars[2]['count'] . '</td>
                          </tr>
                          <tr>
                             <td><span class="star-table-key-column">1 Stern</span></td>
                             <td>
                                <div class="row ng-isolate-scope" width="' . $stars[1]['percent'] . '" hide-percentage="true">
                                   <div class="col-xs-12 progress">
                                      <div data-percentage="0%" style="width: ' . $stars[1]['percent'] . '%;" class="progress-bar progress-bar-success" role="progressbar" aria-valuemin="0" aria-valuemax="100">    </div>
                                      <!-- ngIf: !hidePercentage -->
                                   </div>
                                </div>
                             </td>
                             <td class="star-table-value-column ng-binding">' . $stars[1]['count'] . '</td>
                          </tr>
                       </tbody>
                    </table>
        ', false);

        $this->output('<h1>Letzten 3 Kundenmeinungen</h1>', false);

        foreach ($this->customerfeedback['comments'] AS $comment) {

            ?>
                    <div class="c24-user-comments">
                        <div class="c24-user-comment-date">
            <?php

            $date = str_replace('-', '', $comment['date']);
            echo date('d.m.Y', strtotime($date)) . ' - ' . $comment['customer'];

            ?>
                        </div>

            <?php

            if ($comment['comment_good'] != '') {

                ?>

                <div class="c24-user-comment">
                    <div class="positive"><i class="fa fa-check"></i></div>
                    <div class="comment"><?php echo $comment['comment_good'] ?></div>
                </div>

            <?php

            }

            if ($comment['comment_bad'] != '') {

                ?>

                <div class="c24-user-comment">
                    <div class="negative"><i class="fa fa-times"></i></div>
                    <div class="comment"><?php echo $comment['comment_bad'] ?></div>
                </div>

            <?php

            }

            ?>

                        <div class="c24-user-comment-score">
                            <div class="starempty14">
                                <div
                                    class="starfull14 <?php $this->output('star' . str_replace('.', '', $comment['customer_rate'] / 2)); ?>"></div>
                            </div>
                        </div>
                    </div>

            <?php

        }

    }

        ?>

        </div>
    </div>
    <div data-role="collapsible" class='listItemNoIcon tariff_accordion' data-iconpos="right" data-collapsed-icon="carat-d" data-expanded-icon="carat-u">
        <h3><i class="fa fa-file"></i> Versicherungsunterlagen</h3>
        <?php

    $pdf = $this->tariff->get_tariff_attachments();
    $pdf_documents = [
        'terms'       => ['name' => 'Versicherungsbedingungen', 'tooltip' => 'In den Versicherungsbedingungen werden alle relevanten Informationen über den Versicherungstarif detailliert aufgeführt, unter anderem die genauen Leistungen der gewählten Versicherung und die versicherten Bereiche. Die Versicherungsbedingungen der einzelnen Tarife können hier im PDF-Format heruntergeladen werden.'],
        'terms_extra' => ['name' => 'Besondere Versicherungsbedingungen', 'tooltip' => 'In den Versicherungsbedingungen werden alle relevanten Informationen über den Versicherungstarif detailliert aufgeführt, unter anderem die genauen Leistungen der gewählten Versicherung und die versicherten Bereiche. Die Versicherungsbedingungen der einzelnen Tarife können hier im PDF-Format heruntergeladen werden.']
    ];
    $html = '';

    foreach ($pdf_documents AS $pdf_document_key => $pdf_document) {

        if ($pdf[$pdf_document_key]) {

            $html .= '<div class="c24-content-row-info c24-tariffdetails-files" style="">
                        <a href="' . $pdf[$pdf_document_key] . '" data-href="ignore" class="document-link pdf-icon" target="popup" onclick="window.open(this.href, \'popup\', \'width=990,height=700,scrollbars=yes,toolbar=no,status=no,resizable=yes,menubar=no,location=no,directories=no,top=10,left=10\');return false;" title="ansehen">' . $pdf_document['name'] . '</a>
                      </div>';

        }

    }

    $this->output($html, false);

        ?>
    </div>
</div>

<div id="bottom_subscribe_button" class="c24-tariff-detail-subscription" style="display: none">

    <?php
    $this->output(
        '<a class="c24-button-plain-blue c24-button-online full_button" data-ajax="false" href="' . $this->escape($this->subscription_url) . '">
        weiter zu Adressdaten
        <div class="subtext">(Schritt 1 von 2)</div>
        </a>', false);
    ?>

</div>
