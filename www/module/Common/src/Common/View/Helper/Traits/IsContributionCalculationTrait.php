<?php

namespace Common\View\Helper\Traits;

use Common\Calculation\Model\Parameter\OccupationGroup;
use Common\Calculation\Model\Parameter\User as Parameter;

/**
 * Class IsContributionCalculationTrait
 *
 * @package Common\View\Helper\Traits
 * @author Martin Rintelen <martin.rintelen@check24.de>
 */
trait IsContributionCalculationTrait
{
    /**
     * @param Parameter $calculationParameter
     *
     * @return bool
     */
    public function isContributionCalculation(Parameter $calculationParameter)
    {
        $occupationGroup = $calculationParameter->getOccupationGroup();

        return (
            $occupationGroup === OccupationGroup::EMPLOYEE
            || ( $occupationGroup === OccupationGroup::TRAINEE && $calculationParameter->getSalary() > 3900 )
            || $occupationGroup === OccupationGroup::SELF_EMPLOYED
            || $occupationGroup === OccupationGroup::SELF_EMPLOYED_WITH_FOUNDER_GRANT
            || $occupationGroup === OccupationGroup::CIVIL_SERVANT
            || $occupationGroup === OccupationGroup::STUDENT
            || $occupationGroup === OccupationGroup::SCHOOLED_STUDENT
            || $occupationGroup === OccupationGroup::OTHER
        );
    }
}