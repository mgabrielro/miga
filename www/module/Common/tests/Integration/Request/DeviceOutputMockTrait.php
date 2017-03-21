<?php
namespace Common\Request;

use C24\ZF2\DeviceRecognition\Service\DeviceOutput;

/**
 * Traut DeviceOutputMockTrait
 *
 * @author Martin Rintelen <martin.rintelen@check24.de>
 */
trait DeviceOutputMockTrait
{
    /**
     * mock the specified device type
     *
     * @param string $deviceOutput
     *
     * @return void
     */
    protected function mockDeviceOutput($deviceOutput)
    {
        $mock = $this->getMockBuilder(DeviceOutput::class)
            ->disableOriginalConstructor()
            ->setMethods(
                [
                    'get',
                ]
            )->getMock();

        // mock get method
        $mock->method('get')->willReturn($deviceOutput);

        $this->getApplicationServiceLocator()
            ->setAllowOverride(true)
            ->setService('DeviceOutput', $mock);
    }
}