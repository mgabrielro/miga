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
trait PartnerConfigurationRequestMockTrait
{
    /**
     * @param string  $partnerId  The city name
     * @return array
     */
    protected function getGuzzlePartnerConfigurationRequestValueMap($partnerId)
    {
        $parameters = [
            'partner_id' => $partnerId
        ];

        $mockData = [
            'partner_id'                           => $partnerId,
            'focus_startform'                      => 'yes',
            'tuevlogo_visible'                     => 'yes',
            'check24_tip'                          => 'yes',
            'result_customer_satisfaction'         => 'yes',
            'check24_customer_agb'                 => 'yes',
            'check24_guidelinematch'               => 'yes',
            'check24_tarifupdate_mail'             => 'yes',
            'check24_provider_contact_information' => 'yes'
        ];

        return [
            'get',
            'partnerconfiguration/',
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