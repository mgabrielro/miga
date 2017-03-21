<?php

namespace Common\Provider;

use Common\Exception\RemoteException;
use Common\Request\WpsetRequestMockTrait;
use GuzzleHttp\Client;
use Test\AbstractUnitTestCase;

class WpsetTest extends AbstractUnitTestCase
{
    use WpsetRequestMockTrait;

    /**
     * @test
     */
    public function callFetchShouldReturnAnArray()
    {
        $clientMock = $this->buildStub(Client::class, []);
        $clientMock->method('request')
            ->will(
                $this->returnValueMap(
                    [$this->getGuzzleWpsetRequestValueMap()]
                )
            );

        $wpsetProvider = new Wpset($clientMock, $this->getGuzzleOptions('foobar'));

        $this->assertEquals($this->getMockData(), $wpsetProvider->fetch());
    }

    /**
     * @expectedException \Common\Exception\RuntimeException
     * @dataProvider getTestJson
     * @test
     *
     * @var string $data
     */
    public function callFetchShouldProduceRuntimeException($data)
    {
        $clientMock = $this->buildStub(Client::class, []);
        $clientMock->method('request')
            ->will(
                $this->returnValueMap(
                    [
                        $this->getGuzzleWpsetRequestValueMapWithInvalidJsonResponse($data),
                    ]
                )
            );

        $wpsetProvider = new Wpset($clientMock, $this->getGuzzleOptions('foobar'));
        $wpsetProvider->fetch();
    }

    /**
     * @test
     * @expectedException \Common\Exception\RemoteException
     */
    public function callFetchShouldProduceRequestException()
    {
        $requestException = $this->getGuzzleRequestExceptionMock(400);

        $clientMock = $this->buildStub(Client::class, []);
        $clientMock->method('request')
            ->will(
               $this->throwException(
                   $requestException
               )
            );

        $wpsetProvider = new Wpset($clientMock, $this->getGuzzleOptions('foobar'));
        try {
            $wpsetProvider->fetch();
        }catch (RemoteException $exception){
            // RemoteException is thrown in fetchData due to RequestException
            // Otherwise it could not be determined wether it is thrown during fetch or decode
            $this->assertEquals($exception->getPrevious(), $requestException);
            throw $exception;
        }
    }
    /**
     * additional guzzle options as third parameter for request method
     *
     * @param  string $configKey
     *
     * @return array
     */
    protected function getGuzzleOptions($configKey)
    {
        return [
            'base_uri' => 'https://foobar',
            'auth'     => ['user', 'password'],
            'verify'   => false,
        ];
    }

    /**
     * callFetchShouldProduceRuntimeException dataProvider
     *
     * @return array
     */
    public function getTestJson()
    {
        return [
            [null],   // no headers
            ['{}'],   // data not an array
            ['{[]"'], // malformed JSON
        ];
    }
}