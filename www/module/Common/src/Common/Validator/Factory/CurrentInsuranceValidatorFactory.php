<?php

namespace  Common\Validator\Factory;

use Common\Factory\FactoryInterface;
use Common\Validator\CurrentInsuranceValidator;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class CurrentInsuranceValidatorFactory
 *
 * @package Common\Validator\Factory
 * @author Jens Schmidt <jens.schmidt@check24.de>
 */
class CurrentInsuranceValidatorFactory implements FactoryInterface
{
    /**
     * @param ServiceLocatorInterface $pluginManager
     *
     * @return CurrentInsuranceValidator
     */
    public function __invoke(ServiceLocatorInterface $pluginManager)
    {
        $config = $pluginManager
            ->getServiceLocator()
            ->get('ZendConfig')
            ->check24
            ->calculation
            ->validation;

        $currentInsuranceValidator = new CurrentInsuranceValidator();
        $currentInsuranceValidator->setHaystack(
            $config
                ->current_insurance_type
                ->toArray()
        );

        return $currentInsuranceValidator;
    }
}