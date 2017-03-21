<?php

namespace Common\Validator\Input1;

use Zend\Validator\AbstractValidator;

/**
 * Class SalaryValidator
 *
 * @package Common\Validator\Input1
 * @author Martin Rintelen <martin.rintelen@check24.de>
 */
class SalaryValidator extends AbstractValidator
{
    /**
     * @var int
     */
    const SALARY_LOWER_LIMIT_EMPLOYEE = 5400;

    /**
     * @var int
     */
    const SALARY_LOWER_LIMIT = 0;

    /**
     * @var int
     */
    const SALARY_ABOVE_LIMIT = 500000;

    /**
     * @var string
     */
    const EMPLOYEE_SALARY_BELOW_LIMIT = 'employeeSalaryBelowLimit';

    /**
     * @var string
     */
    const EMPLOYEE_RANGE_ERROR = 'employeeRangeError';

    /**
     * @var string
     */
    const RANGE_ERROR = 'rangeError';

    /**
     * @var array
     */
    protected $messageTemplates = [
        self::EMPLOYEE_SALARY_BELOW_LIMIT => self::EMPLOYEE_SALARY_BELOW_LIMIT,
        self::EMPLOYEE_RANGE_ERROR        => self::EMPLOYEE_RANGE_ERROR,
        self::RANGE_ERROR                 => self::RANGE_ERROR,
    ];

    /**
     * @var string
     */
    protected $fieldOccupationGroup;

    /**
     * @param mixed $value
     * @param null|array $context
     *
     * @return bool
     */
    public function isValid($value, $context = null)
    {
        $occupationGroup = $context[$this->fieldOccupationGroup];

        if ($occupationGroup === 'employee' && $value < self::SALARY_LOWER_LIMIT_EMPLOYEE) {
            $this->error(self::EMPLOYEE_SALARY_BELOW_LIMIT);
            return false;
        }

        if ($value < self::SALARY_LOWER_LIMIT || $value > self::SALARY_ABOVE_LIMIT) {

            if ($occupationGroup === 'employee') {
                $this->error(self::EMPLOYEE_RANGE_ERROR);
            } else {
                $this->error(self::RANGE_ERROR);
            }

            return false;
        }

        return true;
    }

    /**
     * @param string $fieldOccupationGroup
     * @return SalaryValidator
     */
    public function setFieldOccupationGroup($fieldOccupationGroup)
    {
        $this->fieldOccupationGroup = $fieldOccupationGroup;

        return $this;
    }
}