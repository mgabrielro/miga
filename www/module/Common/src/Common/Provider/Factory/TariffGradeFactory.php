<?php

namespace Common\Provider\Factory;

    use Common\Provider\TariffGrade;
    use Zend\ServiceManager\FactoryInterface;
    use Zend\ServiceManager\ServiceLocatorInterface;

    /**
     * Factory for the TariffGrade Http Controller
     *
     * @author Ignaz Schlennert <Ignaz.Schlennert@check24.de>
     */
    class TariffGradeFactory implements FactoryInterface {
        /**
         * Create service
         *
         * @param ServiceLocatorInterface $serviceLocator
         *
         * @return TariffGrade
         */
        public function createService(ServiceLocatorInterface $serviceLocator)
        {
            return new TariffGrade($serviceLocator->get('Common\Api\Client'));
        }
    }