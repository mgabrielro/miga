<?php

namespace Common\Validator;

use Zend\Validator\Csrf;

/**
 * Class CsrfValidator
 *
 * @TODO Remove this class when Zend/Math issue is fixed
 * @see https://github.com/zendframework/zend-math/issues/23
 *
 * @package Common\Validator
 * @author Martin Rintelen <martin.rintelen@check24.de>
 */
class CsrfValidator extends Csrf
{
    /**
     * @inheritdoc
     */
    protected function generateHash()
    {
        $token = md5($this->getSalt() . $this->randomBytes(32) . $this->getName());

        $this->hash = $this->formatHash($token, $this->generateTokenId());

        $this->setValue($this->hash);
        $this->initCsrfToken();
    }

    /**
     * @inheritdoc
     */
    protected function generateTokenId()
    {
        return md5($this->randomBytes(32));
    }

    /**
     * @TODO Replace this with PHP7 implementation or remove when Zend/Math is fixed.
     * @param int $length
     *
     * @return string
     */
    private function randomBytes($length)
    {
        return openssl_random_pseudo_bytes($length);
    }
}