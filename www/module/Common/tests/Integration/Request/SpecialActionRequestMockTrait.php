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
trait SpecialActionRequestMockTrait
{
    /**
     * @param boolean $isActive True if special action is active
     * @return array
     */
    protected function getGuzzleSpecialActionRequestValueMap($isActive = true)
    {
        if ($isActive) {
            $data = [
                'special_action'    => true,
                'free_month'        => 3,
                'valid_until'       => (new \DateTime('last day of next month'))->format('Y-m-d'),
                'max_voucher_value' => 30,
                'countdown_start'   => (new \DateTime('today'))->format('Y-m-d')
            ];
        } else {
            $data = [
                'special_action'    => false
            ];
        }

        return [
            'get',
            'tariff_action/',
            $this->getGuzzleOptions('calculation'),
            new Psr7\Response(200, [],'{
                "status_code":200,
                "status_message":"OK",
                "data":' . Json\Encoder::encode($data) . '
            }')
        ];
    }

}