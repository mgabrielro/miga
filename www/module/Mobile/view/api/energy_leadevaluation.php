<div class="c24-energy-ajax-container c24-clearfix">

    <a href="javascript: void(0);" class="c24-close" onclick="return c24_tariffdetail_close(this);"><!-- --></a>

    <strong class="c24-lead-evaluation-info"><?php $this->output($this->tariff->get_provider_name()) ?>: Bewertungen, Meinungen und Kommentare</strong>

    <div class="c24-clearfix">

        <div style="float: left; width: 45%;" class="c24-lead-evaluation-container">

            <span>
                Die 3 neuesten Kundenmeinungen für die <?php $this->output($this->tariff->get_provider_name()) ?>
            </span>

            <ul class="c24-lead-evaluation">

                <?php

                    for ($i = 0, $i_max = count($this->evaluation_comments); $i < $i_max; ++$i) {

                        $this->output('<li' . ($i + 1 == $i_max ? ' class="last"' : '') . ' style="display:inline-block; width:100%">', false);

                        $this->output(date('d.m.Y', strtotime($this->evaluation_comments[$i]->get_created())) . ' aus ' . $this->evaluation_comments[$i]->get_city() . ' ');
                        $this->output($this->evaluation_comments[$i]->get_stars(), false);

                        $this->output('<br />', false);

                        $this->output('<span class="c24-lead-evaluation-comment">', false);
                        $this->output($this->evaluation_comments[$i]->get_comment());
                        $this->output('</span></li>', false);

                    }

                ?>

            </ul>

        </div>

        <div class="c24-lead-evalulation-details">

            <div class="c24-lead-evalulation-details-inner">

                <table width="335" class="c24-evaluation-overview">

                    <tr>

                        <td class="left">
                            Gesamtbewertung
                        </td>

                        <td class="right">
                            <?php
                                $this->output($this->evaluation->get_avg_stars_energy('total'), false);
                                $this->output(' bei ' . $this->evaluation->get_total_count() . ' Bewertungen');
                            ?>

                        </td>

                    </tr>

                    <tr>

                        <td class="left">
                            Schnelligkeit
                        </td>

                        <td class="right">
                            <?php
                                $this->output($this->evaluation->get_avg_stars_energy('speed'), false);
                                $this->output(' bei ' . $this->evaluation->get_speed_count() . ' Bewertungen');
                            ?>

                        </td>

                    </tr>

                    <tr>

                        <td class="left">
                            Kundenservice
                        </td>

                        <td class="right">
                            <?php
                                $this->output($this->evaluation->get_avg_stars_energy('team'), false);
                                $this->output(' bei ' . $this->evaluation->get_team_count() . ' Bewertungen');
                            ?>

                        </td>

                    </tr>

                    <tr>

                        <td class="left">
                            Verständlichkeit AGB
                        </td>

                        <td class="right">
                            <?php
                                $this->output($this->evaluation->get_avg_stars_energy('terms'), false);
                                $this->output(' bei ' . $this->evaluation->get_terms_count() . ' Bewertungen');
                            ?>

                        </td>

                    </tr>

                    <tr>

                        <td class="left">
                            Verständlichkeit Tarif
                        </td>

                        <td class="right">
                            <?php
                                $this->output($this->evaluation->get_avg_stars_energy('tariff'), false);
                                $this->output(' bei ' . $this->evaluation->get_tariff_count() . ' Bewertungen');
                            ?>

                        </td>

                    </tr>

                    <tr>

                        <td class="left">
                            Kundenservice
                        </td>

                        <td class="right">
                            <?php
                                $this->output($this->evaluation->get_avg_stars_energy('total'), false);
                                $this->output(' bei ' . $this->evaluation->get_total_count() . ' Bewertungen');
                            ?>

                        </td>

                    </tr>

                </table>

            </div>

            <div class="c24-lead-evalulation-details-inner">

                <table width="335" class="c24-lead-evaluation-detail-total">

                    <tr>

                        <td class="left">
                            5 Sterne
                        </td>

                        <td class="middle">
                            <?php
                                $this->output($this->evaluation->get_chart('total', 1), false);
                            ?>
                        </td>

                        <td class="right">
                            <?php
                                $this->output($this->evaluation->get_total_1());
                            ?>
                        </td>

                    </tr>

                    <tr>

                        <td class="left">
                            4 Sterne
                        </td>

                        <td class="middle">
                            <?php
                                $this->output($this->evaluation->get_chart('total', 2), false);
                            ?>
                        </td>

                        <td class="right">
                            <?php
                                $this->output($this->evaluation->get_total_2());
                            ?>
                        </td>

                    </tr>

                    <tr>

                        <td class="left">
                            3 Sterne
                        </td>

                        <td class="middle">
                            <?php
                                $this->output($this->evaluation->get_chart('total', 3), false);
                            ?>
                        </td>

                        <td class="right">
                            <?php
                                $this->output($this->evaluation->get_total_3());
                            ?>
                        </td>

                    </tr>

                    <tr>

                        <td class="left">
                            2 Sterne
                        </td>

                        <td class="middle">
                            <?php
                                $this->output($this->evaluation->get_chart('total', 4), false);
                            ?>
                        </td>

                        <td class="right">
                            <?php
                                $this->output($this->evaluation->get_total_4());
                            ?>
                        </td>

                    </tr>

                    <tr>

                        <td class="left">
                            1 Sterne
                        </td>

                        <td class="middle">
                            <?php
                                $this->output($this->evaluation->get_chart('total', 5), false);
                            ?>
                        </td>

                        <td class="right">
                            <?php
                                $this->output($this->evaluation->get_total_5());
                            ?>
                        </td>

                    </tr>

                </table>

            </div>

        </div>

    </div>

    <a class="c24-lead-evalulation-link" onclick="return $.rs.library.popup('<?php $this->output($this->link_providerevaluation); ?>', 800, 600, 'Kundenbewertung', true);" href="<?php $this->output($this->link_providerevaluation); ?>" target="_blank" title="Alle <?php $this->output(number_format($this->count, 0, ',', '.')); ?> Kundenmeinungen">» Alle <?php $this->output(number_format($this->count, 0, ',', '.')); ?> Kundenkommentare</a>

</div>