<?php
namespace Common\Request;

use GuzzleHttp\Psr7;

/**
 * Trait with mocks for application service
 *
 * @author Robert Eichholtz <robert.eichholtz@check24.de>
 * @package Common\Traits
 */
trait CityRequestMockTrait
{
    /**
     * @param integer $zipcode The Requested Zipcode
     * @param boolean $short_city Short city
     * @return array
     */
    protected function getGuzzleCityRequestValueMap($zipcode, $short_city = true)
    {
        $parameters = [
            'zipcode'    => $zipcode,
            'short_city' => ($short_city === true) ? 'yes' : 'no'
        ];

        return [
            'get',
            'cities/',
            array_merge (
                $this->getGuzzleOptions('calculation'),
                ['query' => $parameters]
            ),
            new Psr7\Response(200, [],'{
                "status_code":200,
                "status_message":"OK",
                "data":["Mielkendorf","Rodenbek"]
            }')
        ];
    }
}