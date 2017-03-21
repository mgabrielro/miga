<?php
namespace Common\Request;

use GuzzleHttp\Psr7;
use Zend\Json;

/**
 * Trait with mocks for application service
 *
 * @author Robert Eichholtz <robert.eichholtz@check24.de>
 * @package Common\Traits
 */
trait StyleRequestMockTrait
{
    /**
     * @param string $partnerId The partner id
     * @param string $key The style key
     * @param string $protocol The protocol (http / https)
     * @return array
     */
    protected function getGuzzleStyleRequestValueMap($partnerId, $key, $protocol)
    {
        $parameters = [
            'partner_id' => $partnerId,
            'key'        => $key,
            'protocol'   => $protocol
        ];

        $mockData = [
            'image_compare'        => 'http://rlvbu.vagrant.local/images/form/styles/standard/compare.gif',
            'image_compare_width'  => '176',
            'image_compare_height' => '31'
        ];

        return [
            'get',
            'style/',
            array_merge (
                $this->getGuzzleOptions('calculation'),
                ['query' => $parameters]
            ),
            new Psr7\Response(200, [],'{
                "status_code":200,
                "status_message":"OK",
                "data":' . Json\Encoder::encode($mockData). '
            }')
        ];
    }
}