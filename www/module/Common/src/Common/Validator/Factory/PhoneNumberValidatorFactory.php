<?php

namespace Common\Validator\Factory;

use c24login\apiclient\service\Phonenumber;
use Common\Validator\PhoneNumberValidator;
use Zend\ServiceManager\MutableCreationOptionsInterface;
use Zend\ServiceManager\MutableCreationOptionsTrait;
use Zend\Validator\ValidatorPluginManager;

/**
 * Class PhoneNumberValidatorFactory
 *
 * @package Common\Validator\Factory
 * @author  Robert Eichholtz <robert.eichholtz@check24.de>
 */
class PhoneNumberValidatorFactory implements MutableCreationOptionsInterface
{
    use MutableCreationOptionsTrait;

    /**
     * @param ValidatorPluginManager $pluginManager
     *
     * @return PhoneNumberValidator
     */
    public function __invoke(ValidatorPluginManager $pluginManager)
    {
        $serviceLocator = $pluginManager->getServiceLocator();

        return new PhoneNumberValidator(
            $serviceLocator->get(Phonenumber::class),
            $this->creationOptions
        );
    }
}