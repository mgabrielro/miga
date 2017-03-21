<?php

namespace Common\Service\Factory;

use Test\AbstractIntegrationTestCase;

class ParticipatingTariffFactoryTest extends AbstractIntegrationTestCase
{
    /**
     * test factory
     */
    public function testFactory()
    {
        /** @var \Common\Service\ParticipatingTariff $class */
        $class = (new ParticipatingTariffFactory())->createService($this->getApplicationServiceLocator());

        $this->assertInstanceOf('Common\Service\ParticipatingTariff', $class);
    }
}