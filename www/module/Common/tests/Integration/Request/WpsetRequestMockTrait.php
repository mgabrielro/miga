<?php
namespace Common\Request;

use Common\Provider\Wpset;
use GuzzleHttp\Psr7;
use Zend\Http\Request;
use Zend\Json;
use GuzzleHttp\Psr7\Request as GuzzleRequest;
use GuzzleHttp\Psr7\Response as GuzzleResponse;

/**
 * Trait with mocks for application service
 *
 * @author  Robert Eichholtz <robert.eichholtz@check24.de>
 * @package Common\Traits
 */
trait WpsetRequestMockTrait
{

    /**
     * @return array
     */
    protected function getMockData()
    {
        return [
            [
                'name'            => 'default',
                'product'         => 'rlv',
                'tracking_id'     => 'checkvers',
                'banner'          => 'doubleclick',
                'cookie_lifetime' => null,
            ],
            [
                'name'            => 'ds_cs_email',
                'product'         => 'rlv',
                'tracking_id'     => 'ch24_csds_em2015',
                'banner'          => 'doubleclick',
                'cookie_lifetime' => null,
            ],
        ];
    }

    /**
     * @return \GuzzleHttp\Psr7\Request
     */
    protected function getGuzzleRequestMock()
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
    protected function getGuzzleRequestExceptionMock($code)
    {
        return new \GuzzleHttp\Exception\RequestException(
            'Simulated exception',
            $this->getGuzzleRequestMock(),
            new GuzzleResponse(
                $code
            )
        );
    }

    /**
     * @return array
     */
    protected function getGuzzleWpsetRequestValueMap()
    {

        return [
            Request::METHOD_GET,
            Wpset::BASE_ROUTE_PART,
            $this->getGuzzleOptions('calculation'),
            new Psr7\Response(
                200, [], '{
                "status_code":200,
                "status_message":"OK",
                "data":' . Json\Encoder::encode($this->getMockData()) . '
            }'
            ),
        ];
    }

    /**
     * @return array
     */
    protected function getGuzzleWpsetRequestValueMapWithInvalidJsonResponse($data = null)
    {

        if (!is_null($data)) {
            $headers = '{
                "status_code":200,
                "status_message":"OK",
                "data":"' . $data . '"
            }';
        } else {
            $headers = '{
                "status_code":200,
                "status_message":"OK"
            }';
        }

        return [
            Request::METHOD_GET,
            Wpset::BASE_ROUTE_PART,
            $this->getGuzzleOptions('calculation'),
            new Psr7\Response(200, [], $headers),
        ];
    }

}