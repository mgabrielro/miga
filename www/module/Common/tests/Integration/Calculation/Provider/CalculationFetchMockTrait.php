<?php

namespace Common\Calculation\Provider;

use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Psr7;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Zend\Json;

/**
 * Trait with mocks for calculation provider
 *
 * @package Common\Calculation\Provider
 * @author Lars Kneschke <lars.kneschke@check24.de>
 */
trait CalculationFetchMockTrait
{
    /**
     * @param array $errors
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    protected function getCalculationFetchStatus400Mock(array $errors)
    {
        $calculationProviderMock = $this->getServiceMock(
            Calculation::class,
            Calculation::class,
            [
                'fetch',
            ]
        );

        $clientException = new ClientException(
            'Simulated exception',
            new Request(
                'get',
                'https://api/foobar'
            ),
            new Response(
                400,
                [],
                Json\Json::encode([
                    'data' => $errors
                ])
            )
        );

        $calculationProviderMock
            ->expects($this->any())
            ->method('fetch')
            ->willThrowException($clientException);

        return $calculationProviderMock;
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    protected function getCalculationFetchStatus500Mock()
    {
        $calculationProviderMock = $this->getServiceMock(
            Calculation::class,
            Calculation::class,
            [
                'fetch',
            ]
        );

        $clientException = new ClientException(
            'Simulated exception',
            new Request(
                'get',
                'https://api/foobar'
            ),
            new Response(
                500
            )
        );

        $calculationProviderMock
            ->expects($this->any())
            ->method('fetch')
            ->willThrowException($clientException);

        return $calculationProviderMock;
    }
}