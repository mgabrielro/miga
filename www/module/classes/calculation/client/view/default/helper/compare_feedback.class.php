<?php

namespace shared\classes\calculation\client\view\helper;

/**
 * print icon view helper
 *
 * @author Robert Eichholtz <robert.eichholtz@check24.de>
 */
class compare_feedback extends base {

    /**
     * @var object
     */
    private $tariff = null;

    /**
     * Constructor
     *
     * @param \shared\classes\calculation\client\view $view View
     * @param string $status The Status of Icon
     * @param string $default The default Status of Icon
     * @param boolean $print if true, then print the output (default)
     */
    public function __construct(\shared\classes\calculation\client\view $view, $tariff)
    {
        $this->tariff  = $tariff;
        parent::__construct($view);
    }

    /**
     * Returns the rendered output.
     *
     * @return string
     */
    protected function create_output() {

        $this->view->tariff = $this->tariff;
        return $this->view->render($this->view->product_key . '/compare_feedback.phtml');
    }
}