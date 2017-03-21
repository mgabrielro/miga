<?php
namespace Common\Service;

use Common\Request\CalculationMockTrait;
use Common\Request\TariffDataMockTrait;
use GuzzleHttp\Psr7;
use \Common\Calculation\Model\Tariff\Gkv as Tariff;

/**
 * Trait with mocks for wpset provider
 *
 * @author Lars Kneschke <lars.kneschke@check24.de>
 * @package Common\Provider
 */
trait MobileCalculationClientMockTrait
{
    use CalculationMockTrait;
    use TariffDataMockTrait;

    /**
     * mock special action getData method
     * @todo .. do not use calculation client, .. use guzzle client
     * @param string $clientType
     * @throws \shared\classes\common\exception\argument
     */
    protected function mockMobileCalculationClient($clientType = null)
    {
        // switch to required client implementation
        switch ($clientType) {
            case OUTPUT_DESKTOP:
                $clientType = 'client';
                break;
            case OUTPUT_MOBILE:
                $clientType = 'mclient';
                break;
            default:
                $clientType = 'mclient';
                break;
        }

        // mock wpset provider in development environment
        $client = $this->getMockBuilder('\classes\calculation\\' . $clientType . '\client')
            ->disableOriginalConstructor()
            ->setMethods([
                'get_calculation',
                'get_calculation_models',
                'get_view_path_stack',
                'get_link',
                'get_partner_id',
                'get_style',
                'get_protocol',
                'get_filter_position',
            ])
            ->getMock();

        // mock get_partner_id method
        $client->method('get_partner_id')->willReturn(PARTNER_GKV);

        // mock get_style method
        $client->method('get_style')->willReturn('check24-bluegrey-mobile');

        // mock get_style method
        $client->method('get_protocol')->willReturn('http');

        // mock fetch method of wpset provider
        $client->method('get_link')->willReturn('link');

        // mock fetch method get_filter_position
        $client->method('get_filter_position')->willReturn('top');

        // mock fetch method of wpset provider
        $client->method('get_view_path_stack')->willReturn([
            0 => 'module/classes/calculation/' . $clientType . '/view/',
            1 => 'module/classes/calculation/' . $clientType . '/view/default/',
        ]);

        // mock fetch method of wpset provider
        $client->method('get_calculation')->willReturn($this->getCalculationResponse());

        // overwrite wpset provider in service manager
        $this->getApplicationServiceLocator()
            ->setAllowOverride(true)
            ->setService('classes\calculation\\' . $clientType . '\client', $client);
    }

    /**
     * @throws \shared\classes\common\exception\argument
     * @return array
     */
    protected function getTariffData()
    {
        $data = $this->getTariffDataArray();
        $tariffs = [];
        while (list($index, $tariff) = @each($data)) {
            $tariffs[] = new Tariff($tariff);
        }

        return $tariffs;
    }

    /**
     * @return CalculationService
     */
    public function getCalculationService()
    {
        return $this->getApplicationServiceLocator()->get('CalculationService');
    }

    /**
     * @return array
     */
    public function getParsedCalculationResponse()
    {
        return $this->getCalculationService()
                    ->convertCalculationResponse(
                        $this->getCalculationResponse()
                    );
    }

    
}