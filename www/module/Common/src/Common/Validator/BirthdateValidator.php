<?php

namespace Common\Validator;

use DateTime;
use Zend\Validator\Date;

/**
 * Class BirthdateValidator
 *
 * @package Common\Validator
 * @author Martin Rintelen <martin.rintelen@check24.de>
 */
class BirthdateValidator extends Date
{
    /**
     * @var string
     */
    const IN_FUTURE = 'inFuture';

    /**
     * @var string
     */
    const TOO_OLD = 'tooOld';

    /**
     * @var string
     */
    protected $format = 'd.m.Y';

    /**
     * @var array
     */
    protected $messageTemplates = [
        self::INVALID      => self::INVALID,
        self::INVALID_DATE => self::INVALID_DATE,
        self::FALSEFORMAT  => self::FALSEFORMAT,
        self::IN_FUTURE    => self::IN_FUTURE,
        self::TOO_OLD      => self::TOO_OLD,
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

        $date = DateTime::createFromFormat($this->format, $value);

        if ($date === false) {
            $this->error(self::INVALID_DATE);
            return false;
        }

        // To achieve a negative value on ->diff you need to format it.
        $daysBetween = (int) $date->diff(new DateTime())->format("%r%a");
        if ($daysBetween <= 0) {
            $valid = false;
            $this->error(self::IN_FUTURE);
        }

        if ($date->diff(new DateTime())->y > 100) {
            $valid = false;
            $this->error(self::TOO_OLD);
        }

        return $valid;
    }
}