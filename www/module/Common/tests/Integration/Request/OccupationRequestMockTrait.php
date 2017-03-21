<?php
namespace Common\Request;

use GuzzleHttp\Psr7;

/**
 * Trait with mocks for application service
 *
 * @author Robert Eichholtz <robert.eichholtz@check24.de>
 * @package Common\Traits
 */
trait OccupationRequestMockTrait
{
    /**
     * @param string $snippet The Requested Zipcode
     * @param boolean $short_city Short city
     * @return array
     */
    protected function getGuzzleOccupationRequestValueMap($snippet, $limit = 10)
    {
        return [
            'get',
            'occupation/name/' . urlencode($snippet) . '/' . $limit . '/',
            $this->getGuzzleOptions('calculation'),
            new Psr7\Response('200', [], '{
                "status_code":200,
                "status_message":"OK",
                "data":{
                    "id":0,"status":"Success","data":"[[\"4384\",\"Rentier\"],[\"4385\",\"Rentner,in\"]]"
                }
            }')
        ];
    }
}