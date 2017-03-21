<?php

namespace Common\Service;

use Common\Request\WpsetRequestMockTrait;
use Test\AbstractIntegrationTestCase;
use Common\Request\StyleRequestMockTrait;

/**
 * Class StyleTest
 *
 * @package Common\Service
 * @author Martin Rintelen <martin.rintelen@check24.de>
 */
class StyleTest extends AbstractIntegrationTestCase
{
    use StyleRequestMockTrait;
    use WpsetRequestMockTrait;

    /**
     * @inheritdoc
     */
    public function setUp()
    {
        parent::setUp();

    }

    /**
     * try to get instance of helper via servicemanager
     */
    public function testServiceManager()
    {
        /** @var \Common\Service\Style $class */
        $class = $this->getApplicationServiceLocator()->get('Common\Service\Style');

        $this->assertInstanceOf('Common\Service\Style', $class);
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
                $this->getGuzzleStyleRequestValueMap(24, 'check24-bluegrey', 'http')
            ]);
        }

        /** @var \Common\Service\Style $class */
        $class = $this->getApplicationServiceLocator()->get('Common\Service\Style');

        $data = $class->getData(24, 'check24-bluegrey', 'http');

        $this->assertGreaterThanOrEqual(1, count($data));
        $this->assertArrayHasKey('image_compare', $data);
    }
}