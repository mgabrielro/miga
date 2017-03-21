<?php

namespace Common\Validator;

use Zend\Validator\Regex;

/**
 * Class HealthNumberValidator
 *
 * @package Common\Validator
 * @author Martin Rintelen <martin.rintelen@check24.de>
 */
class HealthNumberValidator extends Regex
{
    /**
     * @var string
     */
    const INVALID_FORMAT = 'invalidFormat';

    /**
     */
    public function __construct()
    {
        parent::__construct('/^([A-Za-z][0-9]{9})$/');
    }

    /**
     * @param string $value
     *
     * @return bool
     */
    public function isValid($value)
    {
        $valid = parent::isValid($value);

        if (!$valid) {
            $this->abstractOptions['messages'] = [
                self::INVALID_FORMAT => self::INVALID_FORMAT
            ];
        }

        return $valid;
    }
}