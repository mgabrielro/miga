<?php

namespace Common\View\Helper;

use Common\View\Helper\Traits\FormElementHasErrorMessageTrait;
use Zend\Form\Element;
use Zend\Filter\Word\UnderscoreToStudlyCase;
use Zend\View\Helper\AbstractHelper;

/**
 * Class FormElementError
 *
 * @author  Marlon Hänsdieke <marlon.haensdieke@check24.de>
 * @package Common\View\Helper
 */
class FormElementError extends AbstractHelper
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
     * @return string
     */
    protected function render($element)
    {
        if (false === $this->formElementHasErrorMessage($element)) {
            return '';
        }

        return $this->getView()->formElementErrorMessage(
            $this->getErrorMessage($element),
            $this->getAdditionalClass($element)
        );
    }

    /**
     * Determine the elements error message.
     *
     * There are two types of error definitions returned by the calculation api which are
     * attached to the form element:
     *  1. input1:
     *  The error message text is defined in the calculation api response
     *      e.g. ['Lorem error message ipsum.']
     *  2. register:
     *  The error message is a label-key attached to an api hash
     *      e.g. ['api' => '<FIELDNAME>_MANDATORY']
     *
     * @param Element $element
     *
     * @return string
     */
    protected function getErrorMessage($element)
    {
        $errorMessages = $element->getMessages();
        if (array_key_exists('api', $errorMessages)) {
            return $this->getErrorMessageValueByErrorName($errorMessages['api']);
        }

        return implode('<br />', $errorMessages);
    }

    /**
     * @param string $errorName
     *
     * @return string
     */
    protected function getErrorMessageValueByErrorName($errorName)
    {
        return $this->getView()->translate(
            'form.error.' . $this->getStudlyCaseErrorName($errorName)
        );
    }

    /**
     * @param string $errorName
     *
     * @return string
     */
    protected function getStudlyCaseErrorName($errorName)
    {
        return (new UnderscoreToStudlyCase())->filter(
            strtolower($errorName)
        );
    }

    /**
     * @param Element $element
     *
     * @return null|string
     */
    protected function getAdditionalClass($element)
    {
        $additionalClass = null;

        switch ($element->getAttribute('type')) {
            case 'checkbox':
                $additionalClass = ' form__error--checkbox';
                break;
        }

        return $additionalClass;
    }
}