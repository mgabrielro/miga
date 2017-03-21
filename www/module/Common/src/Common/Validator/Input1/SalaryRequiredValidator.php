<?php

namespace Common\Validator\Input1;

use Traversable;
use Zend\Validator\NotEmpty;

/**
 * Class SalaryRequiredValidator
 *
 * @package Common\Validator\Input1
 * @author Martin Rintelen <martin.rintelen@check24.de>
 */
class SalaryRequiredValidator extends NotEmpty
{
    /**
     * @var string
     */
    const SALARY_REQUIRED = 'salaryRequired';

    /**
     * @var string
     */
    const INCOME_REQUIRED = 'incomeRequired';

    /**
     * @var array
     */
    protected $messageTemplates = [
        self::IS_EMPTY        => self::IS_EMPTY,
        self::INVALID         => self::INVALID,
        self::SALARY_REQUIRED => self::SALARY_REQUIRED,
        self::INCOME_REQUIRED => self::INCOME_REQUIRED,
    ];

    /**
     * @var string
     */
    protected $fieldOccupationGroup;

    /**
     * @param  array|Traversable|int $options
     */
    public function __construct($options = null)
    {
        parent::__construct($options);

        $this->setType(self::INTEGER);
    }

    /**
     * @param string $value
     * @param null|array $context
     *
     * @return bool
     */
    public function isValid($value, $context = null)
    {
        $valid = (
            parent::isValid($value) && $value !== null
        );

        if (!$valid) {
            $this->abstractOptions['messages'] = [];
            $this->determineRequiredErrorMessage($context);
            $valid = false;
        }

        return $valid;
    }

    /**
     * @param array|null $context
     *
     * @return void
     */
    protected function determineRequiredErrorMessage(array $context)
    {
        if (
            $context[$this->fieldOccupationGroup] === 'employee' ||
            $context[$this->fieldOccupationGroup] === 'trainee'
        ) {
            $this->error(self::SALARY_REQUIRED);
        } else {
            $this->error(self::INCOME_REQUIRED);
        }
    }

    /**
     * @param string $fieldOccupationGroup
     *
     * @return SalaryRequiredValidator
     */
    public function setFieldOccupationGroup($fieldOccupationGroup)
    {
        $this->fieldOccupationGroup = $fieldOccupationGroup;

        return $this;
    }
}