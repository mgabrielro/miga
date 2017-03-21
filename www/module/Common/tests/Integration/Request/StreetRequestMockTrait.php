<?php
namespace Common\Request;

use GuzzleHttp\Psr7;

/**
 * Trait with mocks for application service
 *
 * @author Robert Eichholtz <robert.eichholtz@check24.de>
 * @package Common\Traits
 */
trait StreetRequestMockTrait
{
    /**
     * @param string  $zipCode    The Requested zipCode
     * @param string  $city       The city name
     * @param boolean $shortCity  Short city?
     * @return array
     */
    protected function getGuzzleStreetRequestValueMap($zipCode, $city = null, $shortCity = true)
    {
        $parameters = [
            'zipcode' => $zipCode
        ];

        if ($city !== null) {
            $parameters['city']       = $city;
            $parameters['short_city'] = ($shortCity === true) ? 'yes' : 'no';
        }

        return [
            'get',
            'streets/',
            array_merge (
                $this->getGuzzleOptions('calculation'),
                ['query' => $parameters]
            ),
            new Psr7\Response(200, [],'{
                "status_code":200,
                "status_message":"OK",
                "data":[{
                    "id":0,"status":"Success","data":"[]"
                }]
            }')
        ];
    }
}