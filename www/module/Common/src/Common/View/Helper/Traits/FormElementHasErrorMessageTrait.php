<?php

namespace Common\View\Helper\Traits;

use Zend\Form\Element;

/**
 * Class FormElementHasErrorMessageTrait
 *
 * @author Marlon Hänsdieke <marlon.haensdieke@check24.de>
 */
trait FormElementHasErrorMessageTrait
{
    /**
     * @param Element $element
     *
     * @return bool
     */
    private function formElementHasErrorMessage($element)
    {
        return (count($element->getMessages()) > 0);
    }
}