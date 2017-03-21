<?php

namespace Common\Service\Factory;

use Test\AbstractIntegrationTestCase;

class WpsetFactoryTest extends AbstractIntegrationTestCase
{
    /**
     * test factory
     */
    public function testFactory()
    {
        /** @var \Common\Service\Wpset $class */
        $class = (new WpsetFactory())->__invoke($this->getApplicationServiceLocator());

        $this->assertInstanceOf('Common\Service\Wpset', $class);
    }
}