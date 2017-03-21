<?php

namespace Common\Service;

use Common\Request\WpsetRequestMockTrait;
use Test\AbstractIntegrationTestCase;
use Common\Request\PartnerConfigurationRequestMockTrait;

class PartnerConfigurationTest extends AbstractIntegrationTestCase
{
    use PartnerConfigurationRequestMockTrait;
    use WpsetRequestMockTrait;

    /**
     * try to get instance of helper via servicemanager
     */
    public function testServiceManager()
    {
        /** @var \Common\Service\PartnerConfiguration $class */
        $class = $this->getApplicationServiceLocator()->get('Common\Service\PartnerConfiguration');

        $this->assertInstanceOf('Common\Service\PartnerConfiguration', $class);
    }

    /**
     * try to retrieve data
     */
    public function testGetData()
    {
        $this->markTestSkipped('GuzzleClient is mocked wrong, because provider depends on Legacy\Backend\Guzzle\Client, fixed in PVGKV-1220');

        if ($this->useMockedRequest()) {
            $this->getGuzzleClientServiceMock([
                $this->getGuzzleWpsetRequestValueMap(),
                $this->getGuzzlePartnerConfigurationRequestValueMap(24)
            ]);
        }

        /** @var \Common\Service\PartnerConfiguration $class */
        $class = $this->getApplicationServiceLocator()->get('Common\Service\PartnerConfiguration');

        $data = $class->getData(24);

        $this->assertGreaterThanOrEqual(1, count($data));
        $this->assertArrayHasKey('partner_id', $data);
    }
}