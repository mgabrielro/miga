<?php

namespace Common\Calculation\Service;

use Common\Calculation\Service\CalculationInternalParameterService;
use Test\AbstractIntegrationTestCase;
use Common\Request\WpsetRequestMockTrait;
use Common\Calculation\Model;

/**
 * Class CalculationInternalParameterServiceTest
 *
 * @package Common\Calculation\Service
 * @author Lars Kneschke <lars.kneschke@check24.de>
 */
class CalculationInternalParameterServiceTest extends AbstractIntegrationTestCase
{
    use WpsetRequestMockTrait;

    /**
     * @test
     */
    public function getCalculationParameter()
    {
        $this->getGuzzleClientServiceMock([
            $this->getGuzzleWpsetRequestValueMap()
        ]);

        /** @var \Zend\Http\PhpEnvironment\Request $request */
        $request = $this->getApplicationServiceLocator()->get('Request');

        $request->getQuery()
            ->set('wpset', 'ds_cs_email');

        /** @var Model\Parameter\Internal $calculationParameter */
        $calculationParameter = $this->getApplicationServiceLocator()
            ->get(CalculationInternalParameterService::class)
            ->getCalculationParameter();

        $this->assertInstanceOf(Model\Parameter\Internal::class, $calculationParameter);
        $this->assertEquals('ch24_csds_em2015', $calculationParameter->getTrackingId());
    }
}