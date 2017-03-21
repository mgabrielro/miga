<?php

namespace shared\classes\calculation\client\view\helper;

use \shared\classes\calculation\client\model\tariff as tariff_model;
use \shared\classes\common\utils;

/**
 * print icon view helper
 *
 * @author Robert Eichholtz <robert.eichholtz@check24.de>
 */
class compare_change extends base
{
    /**
     * @var
     */
    private $tariffs;

    /**
     * Constructor
     *
     * @param \shared\classes\calculation\client\view $view View
     */
    public function __construct(\shared\classes\calculation\client\view $view, $tariffs)
    {
        utils::check_string($view->product_key, 'view->product_key');

        $this->tariffs = $tariffs;

        parent::__construct($view);
    }

    /**
     * Returns the rendered output.
     *
     * @return string
     */
    protected function create_output() {

        $this->view->tariffs = $this->tariffs;
        $this->view->tariffs_count = count($this->tariffs);

        return $this->view->render($this->view->product_key . '/compare_change.phtml');
    }
}