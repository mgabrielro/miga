<?php

namespace Common\Validator;

use c24login\apiclient\service\Phonenumber;
use libphonenumber\NumberParseException;
use Zend\Validator\AbstractValidator;

/**
 * Class PhoneNumberValidator
 *
 * @package Common\Validator
 * @author  Martin Rintelen <martin.rintelen@check24.de>
 * @author  Robert Eichholtz <robert.eichholtz@check24.de>
 */
class PhoneNumberValidator extends AbstractValidator
{
    /**
     * @var string
     */
    const NOT_VALID = 'notValid';

    /**
     * @var Phonenumber
     */
    protected $phoneNumber;

    /**
     * @var array
     */
    protected $messageTemplates = [
        self::NOT_VALID => self::NOT_VALID,
    ];

    /**
     * @param Phonenumber $phoneNumber
     * @param array       $options
     */
    public function __construct(
        Phonenumber $phoneNumber,
        array $options = []
    ) {
        parent::__construct($options);

        $this->phoneNumber = $phoneNumber;
    }

    /**
     * @param string $value
     *
     * @return bool
     */
    public function isValid($value)
    {
        try {
            $value = $this->phoneNumber->convertToInternationalFormat($value);
        } catch (NumberParseException $e) {
            $this->error(self::NOT_VALID);
            return false;
        } catch (\InvalidArgumentException $e) {
            $this->error(self::NOT_VALID);
            return false;
        }

        if (!$this->phoneNumber->validate($value)) {
            $this->error(self::NOT_VALID);
            return false;
        }

        return true;
    }
}