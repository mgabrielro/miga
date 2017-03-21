<?php

namespace  Common\Validator\Factory;

use Common\Factory\FactoryInterface;
use Common\Validator\OccupationGroupValidator;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class OccupationGroupValidatorFactory
 *
 * @package Common\Validator\Factory
 * @author Jens Schmidt <jens.schmidt@check24.de>
 */
class OccupationGroupValidatorFactory implements FactoryInterface
{
    /**
     * @param ServiceLocatorInterface $pluginManager
     *
     * @return OccupationGroupValidator
     */
    public function __invoke(ServiceLocatorInterface $pluginManager)
    {
        $config = $pluginManager
            ->getServiceLocator()
            ->get('ZendConfig')
            ->check24
            ->calculation
            ->validation;

        $occupationGroupValidator = new OccupationGroupValidator();
        $occupationGroupValidator->setHaystack(
            $config
                ->occupation_group
                ->toArray()
        );

        return $occupationGroupValidator;
    }
}