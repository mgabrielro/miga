<?php

namespace shared\classes\calculation\client\view\helper;

use \shared\classes\common\utils;

/**
 * Generate and modify links
 *
 * @author Andreas Buchenrieder <andreas.buchenrieder@check24.de>
 */
class compare_popup_link extends base {

    private $base_link;
    private $title;
    private $class;

    /**
     * Constructor
     *
     * @param \shared\classes\calculation\client\view $view View
     * @param string $base_link Base link to modify
     * @param array $params Params to append. If empty, removes all params from base_link, if NULL, doesn't change params (default)
     * @param string $fragment Fragment to append. If empty, removes existing fragment, if NULL, doesn't change fragment (default)
     */
    public function __construct(\shared\classes\calculation\client\view $view, $title, $base_link, $class = '') {

        utils::check_string($title, 'title');
        utils::check_string($base_link, 'base_link');
        utils::check_string($class, 'class', true);

        $this->title = $title;
        $this->base_link = $base_link;
        $this->class = $class;

        parent::__construct($view);

    }

    /**
     * Returns the rendered output.
     *
     * @return string
     */
    protected function create_output() {

        return sprintf('<a href="%s"
                           data-href="ignore"
                           class="%s"
                           target="popup"
                           onclick="window.open(this.href, \'popup\', \'width=990,height=700,scrollbars=yes,toolbar=no,status=no,resizable=yes,menubar=no,location=no,directories=no,top=10,left=10\');return false;">%s</a>',
            $this->base_link,
            $this->class,
            $this->title
            );
    }

}
