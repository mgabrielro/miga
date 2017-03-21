<?php

namespace Common\Validator;

use Zend\Validator\AbstractValidator;

/**
 * Class StreetNumberValidator
 *
 * @package Common\Validator
 * @author Martin Rintelen <martin.rintelen@check24.de>
 */
class StreetNumberValidator extends AbstractValidator
{
    /**
     * @var string
     */
    const MISSING_NUMBER = 'missingNumber';

    /**
     * @var string
     */
    const NOT_VALID = 'notValid';

    /**
     * @var array
     */
    protected $messageTemplates = [
        self::MISSING_NUMBER => self::MISSING_NUMBER,
        self::NOT_VALID      => self::NOT_VALID,
    ];

    /**
     * The regex used, is based on following assumptions:
     * Minimum 1 Char, Max 7 Chars; Has to begin with min 1 Number;
     *
     * @param  string $value
     *
     * @return bool
     */
    public function isValid($value)
    {
        $valid = true;

        if (!preg_match('/[1-9]/', $value)) {
            $valid = false;
            $this->error(self::MISSING_NUMBER);
        }

        if (!preg_match('/^(?=.{1,7}$)[0-9]+.*$/', $value)) {
            $valid = false;
            $this->error(self::NOT_VALID);
        }

        return $valid;
    }
}