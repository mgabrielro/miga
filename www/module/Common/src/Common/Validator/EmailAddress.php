<?php

namespace Common\Validator;

/**
 * Class EmailAddress
 *
 * @package Common\Validator
 * @author Martin Rintelen <martin.rintelen@check24.de>
 */
class EmailAddress extends \Zend\Validator\EmailAddress
{
    /**
     * @var string
     */
    const INVALID = 'invalid';

    /**
     * @param string $value
     *
     * @return bool
     */
    public function isValid($value)
    {
        if (!parent::isValid($value)) {
            return false;
        }

        if (!$this->checkDnsRecord($value)) {
            $this->error(self::INVALID);

            return false;
        }

        return true;
    }

    /**
     * This is the same validation that the backoffice does.
     * see validation/register/email.class.php:48
     *
     * @param string $value
     *
     * @return bool
     */
    protected function checkDnsRecord($value)
    {
        $emailParts = explode('@', $value);
        $hostname = end($emailParts);

        return checkdnsrr(idn_to_ascii($hostname), 'MX');
    }
}