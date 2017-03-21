<?php

namespace Common\Service;

use Test\AbstractIntegrationTestCase;
use Common\Request\SpecialActionRequestMockTrait;

class SpecialActionTest extends AbstractIntegrationTestCase
{
    use SpecialActionRequestMockTrait;

    /**
     * try to get instance of helper via servicemanager
     */
    public function testServiceManager()
    {
        $this->markTestSkipped('SpecialActionTest::testServiceManager currently not implemented.');

        /** @var \Common\Service\SpecialAction $class */
        $class = $this->getApplicationServiceLocator()->get('SpecialAction');

        $this->assertInstanceOf('Common\Service\SpecialAction', $class);
    }

    /**
     * try to retrieve data
     */
    public function testGetData()
    {
        $this->markTestSkipped('SpecialActionTest::testGetData currently not implemented.');

        if ($this->useMockedRequest()) {
            $this->getGuzzleClientServiceMock([
                $this->getGuzzleSpecialActionRequestValueMap()
            ]);
        }

        /** @var \Common\Service\SpecialAction $class */
        $class = $this->getApplicationServiceLocator()->get('SpecialAction');

        $data = $class->getData();

        $this->assertArrayHasKey('special_action', $data);
    }
}