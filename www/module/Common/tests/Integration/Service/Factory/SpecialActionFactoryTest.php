<?php

namespace Common\Service\Factory;

use Test\AbstractIntegrationTestCase;

class SpecialActionFactoryTest extends AbstractIntegrationTestCase
{
    /**
     * test factory
     */
    public function testFactory()
    {
        /** @var \Common\Service\SpecialAction $class */
        $class = (new SpecialActionFactory())->createService($this->getApplicationServiceLocator());

        $this->assertInstanceOf('Common\Service\SpecialAction', $class);
    }
}