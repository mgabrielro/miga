<?php

namespace Common\Controller\Factory;

use Common\Controller\MissingDocumentsController;
use Common\Service\Documents\DocumentsServiceInterface;
use Zend\Mvc\Controller\ControllerManager;

/**
 * Class MissingDocumentsControllerFactory
 *
 * @package Common\Controller\Factory
 * @author Martin Rintelen <martin.rintelen@check24.de>
 */
class MissingDocumentsControllerFactory
{
    /**
     * @param ControllerManager $controllerManager
     *
     * @return MissingDocumentsController
     */
    public function __invoke(ControllerManager $controllerManager)
    {
        $serviceLocator = $controllerManager->getServiceLocator();

        return new MissingDocumentsController(
            $serviceLocator->get(DocumentsServiceInterface::class)
        );
    }
}