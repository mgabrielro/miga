<?php

namespace Common\Request;

use Common\Provider\SubsequentInformationProvider;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Response as GuzzleResponse;
use GuzzleHttp\Psr7\Request as GuzzleRequest;
use GuzzleHttp\RequestOptions;
use Zend\Http\Request;
use GuzzleHttp\Psr7\Response;
use Zend\Json\Json;

/**
 * trait SubsequentInformationMockTrait
 *
 * @package Common\Request
 * @author  Alexis Peters <alexis.peters@check24.de>
 */
trait SubsequentInformationMockTrait
{

    /**
     * get a Fake Lead Hash
     *
     * @return string
     */
    protected function getLeadHashMock()
    {
        return '3b1e980aaab97bc5b4ed6a4417dc49e3';
    }

    /**
     * @param string $method
     * @param string $optionsKey
     *
     * @return array
     */
    protected function getLeadValueMapMock(
        $method = Request::METHOD_GET,
        $optionsKey = RequestOptions::QUERY
    ) {
        return $this->getLeadValueMapMockWithCustomData(
            $method,
            $optionsKey,
            Json::encode($this->getMockData())
        );
    }

    /**
     * @param string $method
     * @param string $optionsKey
     * @param string $pensionNumber
     * @param string $healthNumber
     *
     * @return array
     */
    protected function getSaveLeadValueMapMock(
        $method,
        $optionsKey,
        $pensionNumber,
        $healthNumber
    ) {
        return $this->getLeadValueMapMockWithCustomData(
            $method,
            $optionsKey,
            Json::encode($this->getMockData()),
            $pensionNumber,
            $healthNumber
        );
    }

    /**
     * @param string      $method
     * @param string      $optionsKey
     * @param null|string $data
     * @param null|string $pensionNumber
     * @param null|string $healthNumber
     *
     * @return array
     */
    protected function getLeadValueMapMockWithCustomData(
        $method = Request::METHOD_GET,
        $optionsKey = RequestOptions::QUERY,
        $data = null,
        $pensionNumber = null,
        $healthNumber = null
    ) {
        if (!is_null($data)) {
            $response = new Response(
                200,
                [],
                '{
                    "status_code":200,
                    "status_message":"OK",
                    "data":' . $data . '
                }'
            );
        } else {
            $response = new Response(
                200,
                [],
                '{
                    "status_code":200,
                    "status_message":"OK"
                }'
            );
        }

        return [
            [
                $method,
                SubsequentInformationProvider::BASE_ROUTE_PART,
                $this->getClientOptionsMock($optionsKey, $pensionNumber, $healthNumber),
                $response,
            ],
        ];
    }

    /**
     * @param string $optionsKey
     * @param string $pensionNumber
     * @param string $healthNumber
     *
     * @return array
     */
    protected function getClientOptionsMock($optionsKey, $pensionNumber, $healthNumber)
    {
        $options = [
            SubsequentInformationProvider::LEAD_HASH => $this->getLeadHashMock(),
        ];

        if (!is_null($pensionNumber)) {
            $options[SubsequentInformationProvider::PENSION_NUMBER] = $pensionNumber;
        }

        if (!is_null($healthNumber)) {
            $options[SubsequentInformationProvider::HEALTH_NUMBER] = $healthNumber;
        }

        return [
            $optionsKey => $options,
        ];
    }

    /**
     * @return array
     */
    protected function getMockData()
    {
        return [
            'lead' => [
                'id' => 1,
            ],
        ];
    }

    /**
     * @return \Psr\Http\Message\RequestInterface
     */
    protected function getRequestMock()
    {
        return new GuzzleRequest(
            'get',
            'https://api/foobar'
        );
    }

    /**
     * @param int $code
     *
     * @return \GuzzleHttp\Exception\RequestException
     */
    protected function getRequestExceptionMock($code)
    {
        return new RequestException(
            'Simulated exception',
            $this->getRequestMock(),
            new GuzzleResponse(
                $code
            )
        );
    }
}