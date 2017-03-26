<?php

namespace Base\Factory;

use Base\Controller\WriteController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class WriteControllerFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $realServiceLocator = $serviceLocator->getServiceLocator();
        $postService        = $realServiceLocator->get('Base\Service\PostService');
        $postInsertForm     = $realServiceLocator->get('FormElementManager')->get('Base\Form\PostForm');

        return new WriteController($postService, $postInsertForm);
    }
}