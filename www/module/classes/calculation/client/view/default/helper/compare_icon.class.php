<?php

namespace shared\classes\calculation\client\view\helper;

/**
 * print icon view helper
 *
 * @author Robert Eichholtz <robert.eichholtz@check24.de>
 */
class compare_icon extends base {

    /**
     * @var string
     */
    private $iconClass = 'NotOK';

    /**
     * @var
     */
    private $status = 'no';

    /**
     * @var
     */
    private $default = null;
    /**
     * Constructor
     *
     * @param \shared\classes\calculation\client\view $view View
     * @param string $status The Status of Icon
     * @param string $default The default Status of Icon
     * @param boolean $print if true, then print the output (default)
     */
    public function __construct(\shared\classes\calculation\client\view $view, $status, $default = null)
    {
        $this->status  = $status;
        $this->default = $default;

        parent::__construct($view);
    }

    /**
     * Returns the rendered output.
     *
     * @return string
     */
    protected function create_output() {

        if($this->default && $this->status == $this->default && $this->status != '') {
            $this->iconClass = 'OK';
        }

        elseif (!in_array($this->status, ['','Nein','no','low','very_low'])) {
            $this->iconClass = 'OK';
        }

        return '<div class="icon ' . $this->iconClass . '"></div>';
    }
}