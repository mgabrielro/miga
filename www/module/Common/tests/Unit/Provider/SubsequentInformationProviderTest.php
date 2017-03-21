<?php

namespace Common\Provider;

use Common\Exception\RemoteException;
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use Test\AbstractUnitTestCase;
use Zend\Http\Request;
use Common\Request\SubsequentInformationMockTrait;

/**
 * Class SubsequentInformationProviderTest
 *
 * @package Common\Provider
 * @author  Alexis Peters <alexis.peters@check24.de>
 */
class SubsequentInformationProviderTest extends AbstractUnitTestCase
{
    use SubsequentInformationMockTrait;

    /**
     * @test
     */
    public function callFetchShouldReturnAnLeadArray()
    {
        $clientMock = $this->buildStub(Client::class, []);
        $clientMock->method('request')
            ->will(
                $this->returnValueMap(
                    $this->getLeadValueMapMock()
                )
            );
        $subsequentProvider = new SubsequentInformationProvider($clientMock, []);

        $this->assertInstanceOf(SubsequentInformationProvider::class, $subsequentProvider);
        $this->assertEquals($this->getMockData()['lead'], $subsequentProvider->fetch($this->getLeadHashMock()));
    }

    /**
     * @test
     */
    public function callSaveShouldReturnAnLeadArray()
    {
        $a = $this->getSaveLeadValueMapMock(
            Request::METHOD_POST,
            RequestOptions::FORM_PARAMS,
            'foo',
            'bar'
        );
        $clientMock = $this->buildStub(Client::class, []);
        $clientMock->method('request')
            ->will(
                $this->returnValueMap(
                    $a
                )
            );
        $subsequentProvider = new SubsequentInformationProvider($clientMock, []);

        $this->assertInstanceOf(SubsequentInformationProvider::class, $subsequentProvider);
        $this->assertEquals(
            $this->getMockData()['lead'],
            $subsequentProvider->save($this->getLeadHashMock(), 'foo', 'bar')
        );
    }

    /**
     * @test
     * @dataProvider getTestData
     *
     * @expectedException \Common\Exception\RuntimeException
     */
    public function callFetchShouldThrowRuntimeException($jsonData)
    {
        $clientMock = $this->buildStub(Client::class, []);
        $clientMock->method('request')
            ->will(
                $this->returnValueMap(
                    $this->getLeadValueMapMockWithCustomData(
                        Request::METHOD_GET,
                        RequestOptions::QUERY,
                        $jsonData
                    )
                )
            );
        $subsequentProvider = new SubsequentInformationProvider($clientMock, []);
        $subsequentProvider->fetch($this->getLeadHashMock());
    }

    /**
     * @test
     */
    public function callFetchShouldThrowRequestException()
    {
        $mockException = $this->getRequestExceptionMock(400);
        $clientMock = $this->buildStub(Client::class, []);
        $clientMock->method('request')
            ->will(
                $this->throwException($mockException)
            );
        $subsequentProvider = new SubsequentInformationProvider($clientMock, []);
        try {
            $subsequentProvider->fetch($this->getLeadHashMock());
        } catch (RemoteException $runtimeException) {
            // RemoteException is thrown in fetchData due to RequestException
            // Otherwise it could not be determined wether it is thrown during fetch or decode
            $this->assertEquals($runtimeException->getPrevious(), $mockException);
        }
    }

    /**
     * @test
     */
    public function callSaveShouldThrowRequestException()
    {
        $mockException = $this->getRequestExceptionMock(400);
        $clientMock = $this->buildStub(Client::class, []);
        $clientMock->method('request')
            ->will(
                $this->throwException($mockException)
            );
        $subsequentProvider = new SubsequentInformationProvider($clientMock, []);
        try {
            $subsequentProvider->save($this->getLeadHashMock(), 'foo', 'bar');
        } catch (RemoteException $runtimeException) {
            // RemoteException is thrown in fetchData due to RequestException
            // Otherwise it could not be determined wether it is thrown during fetch or decode
            $this->assertEquals($runtimeException->getPrevious(), $mockException);
        }
    }

    /**
     * @return array
     */
    public function getTestData()
    {
        return [
            [null], // data key missing
            ['"foo"'], // data key not containing array
            ['"foo"'], // data key not containing array
            ['{"notlead":"asd"}'], // lead key missing
            ['{"lead":"asd"}'], // lead key not containing array
            ['{"}}'], // malformed JSON
        ];
    }

}