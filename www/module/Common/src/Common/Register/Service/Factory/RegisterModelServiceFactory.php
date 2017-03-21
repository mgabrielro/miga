<?php

namespace Common\Register\Service\Factory;
use Common\Calculation\Model\Parameter\Hydrator\UserHydratorStrategy;
use Common\Calculation\Model\Tariff\Hydrator\GkvTariffHydratorStrategy;
use Common\Register\Model\Factory\RegisterModelFactory;
use Common\Register\Provider\RegisterProvider;
use Common\Register\Service\RegisterModelService;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Hydrator\AbstractHydrator;

/**
 * Class RegisterModelServiceFactory
 *
 * @package Common\Register\Service\Factory
 * @author Martin Rintelen <martin.rintelen@check24.de>
 */
class RegisterModelServiceFactory
{
    /**
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return RegisterModelService
     */
    public function __invoke(ServiceLocatorInterface $serviceLocator)
    {
        /** @var AbstractHydrator $hydrator */
        $hydrator = $serviceLocator->get('HydratorManager')->get('ClassMethods');

        $hydrator->addStrategy(
            'calculationparameter',
            $serviceLocator->get(UserHydratorStrategy::class)
        );

        $hydrator->addStrategy(
            'registertariff',
            $serviceLocator->get(GkvTariffHydratorStrategy::class)
        );

        return new RegisterModelService(
            $serviceLocator->get(RegisterProvider::class),
            $serviceLocator->get(RegisterModelFactory::class),
            $hydrator
        );
    }
}