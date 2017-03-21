<?php

namespace Common\Validator\Factory;

use C24\ZF2\User\Service\AuthenticationService;
use Common\Provider\AddressServiceProvider;
use Common\Validator\StreetValidator;
use Zend\ServiceManager\MutableCreationOptionsInterface;
use Zend\ServiceManager\MutableCreationOptionsTrait;
use Zend\Validator\ValidatorPluginManager;

/**
 * Class StreetValidatorFactory
 *
 * @package Common\Validator\Factory
 * @author  Henrik Oelze <henrik.oelze@check24.de>
 */
class StreetValidatorFactory implements MutableCreationOptionsInterface
{
    use MutableCreationOptionsTrait;

    /**
     * @param ValidatorPluginManager $pluginManager
     *
     * @return StreetValidator
     */
    public function __invoke(ValidatorPluginManager $pluginManager)
    {
        $serviceLocator = $pluginManager->getServiceLocator();

        return new StreetValidator(
            $serviceLocator->get(AuthenticationService::class),
            $serviceLocator->get(AddressServiceProvider::class),
            $this->creationOptions
        );
    }
}