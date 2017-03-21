<?php

namespace Common\Validator;

use Zend\Validator\Digits;

/**
 * Class PhoneNumberPrefixValidator
 *
 * @package Common\Validator
 * @author Martin Rintelen <martin.rintelen@check24.de>
 */
class PhoneNumberPrefixValidator extends Digits
{
    /**
     * @var string
     */
    const LEADING_ZERO_MISSING = 'leadingZeroMissing';

    /**
     * @var string
     */
    const ONLY_ZEROS_NOT_ALLOWED = 'onlyZerosNotAllowed';

    /**
     * @var string
     */
    const DIGITS_MISSING = 'digitsMissing';

    /**
     * @var string
     */
    const NOT_VALID = 'notValid';

    /**
     * @var array
     */
    protected $messageTemplates = [
        self::NOT_DIGITS             => self::NOT_DIGITS,
        self::STRING_EMPTY           => self::STRING_EMPTY,
        self::INVALID                => self::INVALID,
        self::LEADING_ZERO_MISSING   => self::LEADING_ZERO_MISSING,
        self::ONLY_ZEROS_NOT_ALLOWED => self::ONLY_ZEROS_NOT_ALLOWED,
        self::DIGITS_MISSING         => self::DIGITS_MISSING,
    ];

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

        $valid = true;

        if (strlen($value) < 3) {
            $valid = false;
            $this->error(self::DIGITS_MISSING);
        }

        if (!preg_match('/[1-9]/', $value)) {
            $valid = false;
            $this->error(self::ONLY_ZEROS_NOT_ALLOWED);
        }

        if (!preg_match('/^0[0-9]+/', $value)) {
            $valid = false;
            $this->error(self::LEADING_ZERO_MISSING);
        }

        return $valid;
    }
}