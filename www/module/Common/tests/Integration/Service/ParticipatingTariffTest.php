<?php

namespace Common\Service;

use Test\AbstractIntegrationTestCase;
use Common\Request\ParticipatingTariffRequestMockTrait;

class ParticipatingTariffTest extends AbstractIntegrationTestCase
{
    use ParticipatingTariffRequestMockTrait;

    /**
     * try to get instance of helper via servicemanager
     */
    public function testServiceManager()
    {
        $this->markTestSkipped('ParticipatingTariffTest::testServiceManager currently not implemented.');

        /** @var \Common\Service\ParticipatingTariff $class */
        $class = $this->getApplicationServiceLocator()->get('ParticipatingTariff');

        $this->assertInstanceOf('Common\Service\ParticipatingTariff', $class);
    }

    /**
     * try to retrieve data
     */
    public function testGetData()
    {
        $this->markTestSkipped('ParticipatingTariffTest::testGetData currently not implemented.');

        if($this->useMockedRequest()) {
            $this->getGuzzleClientServiceMock([
                $this->getGuzzleParticipatingTariffRequestValueMap()
            ]);
        }

        /** @var \Common\Service\ParticipatingTariff $class */
        $class = $this->getApplicationServiceLocator()->get('ParticipatingTariff');

        $data = $class->getData();

        $this->assertArrayHasKey('provider_name', $data[0]);
    }
}