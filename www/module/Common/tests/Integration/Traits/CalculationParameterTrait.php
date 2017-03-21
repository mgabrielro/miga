<?php

namespace Common\Traits;

use Common\Calculation\Model\Parameter\User as Parameter;
use Zend\Hydrator\ClassMethods;

/**
 * Class CalculationParameterTrait
 *
 * @author Martin Rintelen <martin.rintelen@check24.de>
 */
trait CalculationParameterTrait
{
    /**
     * @param array $data
     *
     * @return Parameter
     */
    public function getCalculationParameter($data = [])
    {
        $defaultData = [
            'calculation_id'         => '559d279910397de4e52be63f58237583',
            'sortfield'              => 'price',
            'sortorder'              => 'asc',
            'occupation_group'       => 'employee',
            'current_insurance_type' => 'by_law',
            'zipcode'                => '22089',
            'federal_state'          => 'Hamburg',
            'current_insurer'        => 'by_law',
            'salary'                 => '40.000',
        ];

        $hydrator = new ClassMethods();

        /** @var Parameter $user */
        $user = $hydrator->hydrate(
            array_merge($defaultData, $data),
            new Parameter()
        );

        return $user;
    }

    /**
     * @param array $data
     *
     * @return array
     */
    public function getCalculationParameterData($data = [])
    {
        $defaultData = [
            'calculation_id'         => '559d279910397de4e52be63f58237583',
            'sortfield'              => 'price',
            'sortorder'              => 'asc',
            'occupation_group'       => 'employee',
            'current_insurance_type' => 'by_law',
            'zipcode'                => '22089',
            'federal_state'          => 'Hamburg',
            'current_insurer'        => 'by_law',
            'salary'                 => '40.000',
        ];

        $addressData = array_merge($defaultData, $data);

        return $addressData;
    }
}