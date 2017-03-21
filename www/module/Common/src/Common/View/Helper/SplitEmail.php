<?php

namespace Common\View\Helper;

use Zend\Form\View\Helper\AbstractHelper;

/**
 * Class SplitEmail
 *
 * @author Marlon Hänsdieke <marlon.haensdieke@check24.de>
 */
class SplitEmail extends AbstractHelper
{
    /**
     * @param string $email
     * @param integer $maxLength
     *
     * @return string
     */
    public function __invoke($email, $maxLength)
    {
        return $this->render($email, $maxLength);
    }

    /**
     * @param string $email
     * @param integer $maxLength
     *
     * @return string
     */
    protected function render($email, $maxLength)
    {
        $positionAt = strpos($email, '@');

        if (false === $positionAt) {
            return $email;
        }

        if (strlen($email) < $maxLength) {
            return $email;
        }

        return substr_replace($email, '<br>', $positionAt, null);
    }
}