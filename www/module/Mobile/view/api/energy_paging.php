<div class="c24-result-energy-pager">

    <ul class="c24-result-pager-list c24-clearfix">

        <li id="c24-result-pager-list-label">
            Seite:
        </li>

        <?php

            $pages = $this->paging->get_pages();

            for ($i = 0, $i_max = count($pages); $i < $i_max; ++$i) {

        ?>

        <li class="page <?php $this->output($pages[$i]['class']) ?>">

            <?php

                if ($pages[$i]['url'] != '') {
                    $this->output('<a href="' . $this->escape($pages[$i]['url']) . '">', false);
                } else {
                    $this->output('<span>', false);
                }

                $this->output($pages[$i]['label']);

                if ($pages[$i]['url'] != '') {
                    $this->output('</a>', false);
                } else {
                    $this->output('</span>', false);
                }

            ?>

        </li>

        <?php

            }

        ?>

    </ul>

</div>