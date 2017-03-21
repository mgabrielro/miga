<?php

namespace Common\View\Helper;

use Zend\View\Helper\AbstractHelper;

/**
 * Class FormElementErrorMessage
 *
 * @package Common\View\Helper
 * @author Marlon Hänsdieke <marlon.haensdieke@check24.de>
 */
class FormElementErrorMessage extends AbstractHelper
{
    /**
     * @param string $errorMessage
     * @param string $additionalClass
     *
     * @return string
     */
    public function __invoke($errorMessage, $additionalClass = null)
    {
        return $this->render($errorMessage, $additionalClass);
    }

    /**
     * @param string $errorMessage
     * @param string $additionalClass
     *
     * @return string
     */
    protected function render($errorMessage, $additionalClass)
    {
        return $this->getView()->render(
            'common/helper/formElementErrorMessage.phtml', [
                'errorMessage' => $errorMessage,
                'additionalClass' => $additionalClass
            ]
        );
    }
}