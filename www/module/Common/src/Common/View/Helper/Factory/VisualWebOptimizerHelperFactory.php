<?php

namespace Common\View\Helper\Factory;

use C24\ZF2\Tracking\Service\TrackingEnabledService;
use Common\Service\VisualWebOptimizer;
use Common\View\Helper\VisualWebOptimizerHelper;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class VisualWebOptimizerFactory
 *
 * @package Common\View\Helper\Factory
 * @author Martin Rintelen <martin.rintelen@check24.de>
 */
class VisualWebOptimizerHelperFactory
{
    /**
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return VisualWebOptimizerHelper
     */
    public function __invoke(ServiceLocatorInterface $serviceLocator)
    {
        return new VisualWebOptimizerHelper(
            $serviceLocator->getServiceLocator()->get(TrackingEnabledService::class),
            $serviceLocator->getServiceLocator()->get(VisualWebOptimizer::class)
        );
    }
}