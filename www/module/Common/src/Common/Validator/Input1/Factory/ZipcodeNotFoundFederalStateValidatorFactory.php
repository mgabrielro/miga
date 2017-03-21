<?php

namespace Common\Validator\Input1\Factory;

use Common\Provider\FederalState;
use Common\Validator\Input1\ZipcodeNotFoundFederalStateValidator;
use Zend\Validator\ValidatorPluginManager;

/**
 * Class ZipcodeNotFoundFederalStateValidatorFactory
 *
 * @package Common\Validator\Input1\Factory
 * @author Martin Rintelen <martin.rintelen@check24.de>
 */
class ZipcodeNotFoundFederalStateValidatorFactory
{
    /**
     * @param ValidatorPluginManager $pluginManager
     *
     * @return ZipcodeNotFoundFederalStateValidator
     */
    public function __invoke(ValidatorPluginManager $pluginManager)
    {
        $serviceLocator = $pluginManager->getServiceLocator();

        return new ZipcodeNotFoundFederalStateValidator(
            $serviceLocator->get(FederalState::class)
        );
    }
}