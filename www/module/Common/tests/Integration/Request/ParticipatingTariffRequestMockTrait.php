<?php
namespace Common\Request;

use GuzzleHttp\Psr7;

/**
 * Trait with mocks for application service
 *
 * @author Robert Eichholtz <robert.eichholtz@check24.de>
 * @package Common\Traits
 */
trait ParticipatingTariffRequestMockTrait
{
    /**
     * @return array
     */
    protected function getGuzzleParticipatingTariffRequestValueMap()
    {
        return [
            'get',
            'participating_tariff/',
            $this->getGuzzleOptions('calculation'),
            new Psr7\Response(200, [], '{
                "status_code": 200,
                "status_message": "OK",
                "data": [{
                  "provider_name": "AllSecur",
                  "tariff_name": "Tarif L0(DL)"
                }]
            }')
        ];
    }
}