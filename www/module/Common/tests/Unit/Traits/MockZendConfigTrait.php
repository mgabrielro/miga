<?php

namespace Common\Traits;

use PHPUnit_Framework_MockObject_MockObject;
use Zend\Config\Config;

/**
 * Class MockZendConfigTrait
 * use it in PHPUnit_Framework_TestCase for mock zend config object with any
 * array
 *
 * @package Common\Controller\Traits
 * @author  Dirk Winkhaus <dirk.winkhaus@check24.de>
 */
trait MockZendConfigTrait
{
    /**
     * @return mixed
     */
    protected function getConfigMock()
    {
        return $this
            ->getMockBuilder(Config::class)
            ->disableOriginalConstructor()
            ->getMock();
    }

    /**
     * Mocks an array as zend config object recursively
     * use: mockZendConfig(array $config) to mock your config
     *
     * @param PHPUnit_Framework_MockObject_MockObject $mock
     * @param array                                   $configPart
     */
    protected function recursiveMethodForMockZendConfig(
        PHPUnit_Framework_MockObject_MockObject $mock,
        array $configPart
    ) {
        $mapping = [];
        foreach ($configPart as $key => $value) {
            if (is_array($value)) {
                $configMock = $this->getConfigMock();
                $this->recursiveMethodForMockZendConfig(
                    $configMock,
                    $value
                );

                $mapping[] = [$key, $configMock];
            } else {
                $mapping[] = [$key, $value];
            }
        }
        $mock->method('__get')
            ->will($this->returnValueMap($mapping));
        $mock->method('toArray')
            ->will($this->returnValue([]));
    }

    /**
     * Mocks a zend config object from your array settings
     *
     * @param array $config
     *
     * @return PHPUnit_Framework_MockObject_MockObject
     */
    protected function mockZendConfig(array $config)
    {
        $zendConfig = $this->getConfigMock();
        $this->recursiveMethodForMockZendConfig($zendConfig, $config);

        return $zendConfig;
    }
}