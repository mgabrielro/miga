<?php

namespace Common\View\Helper;

use Common\View\Helper\Traits\FormElementHasErrorMessageTrait;
use Zend\Form\Element;
use Zend\View\Helper\AbstractHelper;

/**
 * Class FormElementHasError
 *
 * @author  Marlon Hänsdieke <marlon.haensdieke@check24.de>
 * @package Common\View\Helper
 */
class FormElementHasError extends AbstractHelper
{
    use FormElementHasErrorMessageTrait;

    /**
     * @param Element $element
     *
     * @return string
     */
    public function __invoke(Element $element)
    {
        return $this->render($element);
    }

    /**
     * @param Element $element
     *
     * @return bool
     */
    protected function render($element)
    {
        return $this->formElementHasErrorMessage($element);
    }
}