<?php

namespace Common\Service;

use Test\AbstractIntegrationTestCase;
use Common\Request\WpsetRequestMockTrait;

class WpsetTest extends AbstractIntegrationTestCase
{
    use WpsetRequestMockTrait;

    /**
     * try to get instance of helper via servicemanager
     */
    public function testServiceManager()
    {
        /** @var \Common\Service\Wpset $class */
        $class = $this->getApplicationServiceLocator()->get(\Common\Service\Wpset::class);

        $this->assertInstanceOf('Common\Service\Wpset', $class);
    }

    /**
     * try to retrieve data
     */
    public function testGetData()
    {
        $this->getGuzzleClientServiceMock([
            $this->getGuzzleWpsetRequestValueMap(),
        ]);

        /** @var \Common\Service\Wpset $class */
        $class = $this->getApplicationServiceLocator()->get(\Common\Service\Wpset::class);

        $data = $class->getData();

        $this->assertGreaterThanOrEqual(1, count($data));
        $this->assertArrayHasKey('name', $data[0]);
    }

    /**
     * try to retrieve data by tracking id
     */
    public function testGetByTrackingId()
    {
        $this->getGuzzleClientServiceMock([
            $this->getGuzzleWpsetRequestValueMap()
        ]);

        /** @var \Common\Service\Wpset $class */
        $class = $this->getApplicationServiceLocator()->get(\Common\Service\Wpset::class);

        $data = $class->getByTrackingId('ch24_csds_em2015');

        $this->assertGreaterThanOrEqual(5, count($data));
        $this->assertArrayHasKey('name', $data);
    }

    /**
     * try to retrieve data by name
     */
    public function testGetByName()
    {
        $this->getGuzzleClientServiceMock([
            $this->getGuzzleWpsetRequestValueMap()
        ]);

        /** @var \Common\Service\Wpset $class */
        $class = $this->getApplicationServiceLocator()->get(\Common\Service\Wpset::class);

        $data = $class->getByName('ds_cs_email');

        $this->assertGreaterThanOrEqual(5, count($data));
        $this->assertArrayHasKey('tracking_id', $data);
    }

    /**
     * try to retrieve data by tracking id
     */
    public function testGetRequestWpsetFallback()
    {
        $this->getGuzzleClientServiceMock([
            $this->getGuzzleWpsetRequestValueMap()
        ]);

        /** @var \Common\Service\Wpset $class */
        $class = $this->getApplicationServiceLocator()->get(\Common\Service\Wpset::class);

        $this->getRequest()->getQuery()->offsetSet('wpset', 'unknown');

        $data = $class->getRequestWpset();

        $this->assertGreaterThanOrEqual(5, count($data));
        $this->assertArrayHasKey('name', $data);
        $this->assertEquals('default', $data['name']);
    }

    /**
     * try to retrieve data by name
     */
    public function testOnDispatch()
    {
        #$this->markTestSkipped('Different behavior on local and bamboo test runner');
        $this->getGuzzleClientServiceMock([
            $this->getGuzzleWpsetRequestValueMap()
        ]);

        /** @var \Zend\Http\PhpEnvironment\Request $request */
        $request = $this->getApplicationServiceLocator()->get('Request');

        $request->getQuery()
            ->set('cpref', 'foobar')
            ->set('wpset', 'ds_cs_email');

        $this->getApplicationServiceLocator()
            ->get(\Common\Service\Wpset::class)
            ->onDispatch();

        /** @var \Zend\Session\Container $session */
        $session = $this->getApplicationServiceLocator()->get("SessionContainer");

        $this->assertEquals('ds_cs_email', $session->offsetGet('wpset'));
        $this->assertEquals('foobar', $session->offsetGet('cpref'));

        /** @var \Zend\Http\PhpEnvironment\Response $response */
        $response = $this->getApplicationServiceLocator()->get('Response');

        /** @var \Zend\Http\Header\SetCookie $header */
        $cookieHeaders = $response->getHeaders()->get('SetCookie');

        foreach ($cookieHeaders as $cookieHeader) {
            switch ($cookieHeader->getName()) {
                case 'wpset':
                    $this->assertEquals('ds_cs_email', $cookieHeader->getValue());

                    break;

                case 'cpref':
                    $this->assertEquals('foobar', $cookieHeader->getValue());

                    break;

                default:
                    $this->fail('unknown cookie: ' . $cookieHeader->getName());
            }
        }
    }

    /**
     * @expectedException \Common\Exception\RuntimeException
     */
    public function testGetByNameWithInvalidJson()
    {
        $this->getGuzzleClientServiceMock([
            $this->getGuzzleWpsetRequestValueMapWithInvalidJsonResponse()
        ]);

        /** @var \Common\Service\Wpset $class */
        $class = $this->getApplicationServiceLocator()->get(\Common\Service\Wpset::class);

        $class->getByName('ds_cs_email');
    }
}