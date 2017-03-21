<?php

namespace Common\Controller\Factory;

use Common\Controller\AjaxController;
use Common\Provider\AddressServiceProvider;
use Zend\Mvc\Controller\ControllerManager;

/**
 * Class AjaxControllerFactory
 *
 * @package Common\Controller\Factory
 * @author Martin Rintelen <martin.rintelen@check24.de>
 */
class AjaxControllerFactory
{
    /**
     * @param ControllerManager $serviceLocator
     *
     * @return AjaxController
     */
    public function __invoke(ControllerManager $serviceLocator)
    {
        return new AjaxController(
            $serviceLocator->getServiceLocator()->get(AddressServiceProvider::class)
        );
    }
}