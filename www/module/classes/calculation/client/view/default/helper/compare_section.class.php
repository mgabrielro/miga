<?php

namespace shared\classes\calculation\client\view\helper;

use \shared\classes\calculation\client\model\tariff as tariff_model;
use \shared\classes\common\utils;

/**
 * print icon view helper
 *
 * @author Robert Eichholtz <robert.eichholtz@check24.de>
 */
class compare_section extends base {

    /**
     * @var array
     */
    private $area;

    /**
     * @var
     */
    private $tariffs;

    /**
     * Constructor
     *
     * @param \shared\classes\calculation\client\view $view View
     */
    public function __construct(\shared\classes\calculation\client\view $view, array $area, $tariffs)
    {
        utils::check_string($view->product_key, 'view->product_key');

        $this->area   = $area;
        $this->tariffs = $tariffs;

        parent::__construct($view);
    }

    /**
     * Returns the rendered output.
     *
     * @return string
     */
    protected function create_output() {

        $this->view->area = $this->area;
        $this->view->tariffs = $this->tariffs;

        return $this->view->render($this->view->product_key . '/compare_section.phtml');
    }
}