<?php

namespace Common\Calculation\Service;

use Common\Calculation\Service\CalculationService;
use Common\Exception\InvalidArgumentException;
use Common\Exception\RemoteException;
use Test\AbstractIntegrationTestCase;
use Common\Request\CalculationMockTrait;
use Common\Calculation\Provider\CalculationFetchMockTrait;
use Common\Request\WpsetRequestMockTrait;
use Common\Calculation\Model;
use Zend\Hydrator\ClassMethods;

/**
 * Class CalculationServiceTest
 *
 * @package Common\Calculation\Service
 * @author Lars Kneschke <lars.kneschke@check24.de>
 */
class CalculationServiceTest extends AbstractIntegrationTestCase
{
    use CalculationFetchMockTrait;
    use CalculationMockTrait;
    use WpsetRequestMockTrait;

    /**
     * @test
     */
    public function getCalculations()
    {
        $this->markTestSkipped('Response in CalculationService is null');
        /** @var ClassMethods $hydrator */
        $hydrator = $this->getApplicationServiceLocator()->get('HydratorManager')->get('ClassMethods');

        /** @var Model\Parameter\User $calculationUserParameter */
        $calculationUserParameter = $hydrator->hydrate([
            'occupation_group'       => 'employee',
            'current_insurance_type' => 'by_law',
            'zipcode'                => '22177',
            'federal_state'          => 'Hamburg',
            'salary'                 => 60000,
        ], new Model\Parameter\User());

        if ($this->useMockedRequest()) {
            /** @var Model\Parameter\Internal $calculationInternalParameter */
            $calculationInternalParameter = $hydrator->hydrate([
                'protocol'               => 'http',
                'remote_address'         => '127.0.0.1',
                'partner_id'             => PARTNER_GKV,
                'product_id'             => PRODUCT_GKV,
                'tracking_id'            => 'checkvers',
                'update_parameters'      => false,
            ], new Model\Parameter\Internal());

            $this->getGuzzleClientServiceMock([
                $this->getGuzzleWpsetRequestValueMap(),
                $this->getGuzzleCalculationRequestValueMap($calculationUserParameter, $calculationInternalParameter)
            ]);
        }

        /** @var \Zend\Http\PhpEnvironment\Request $request */
        $request = $this->getRequest();

        $request->getQuery()
            ->set('wpset', 'ds_cs_email');

        $headers = $request->getHeaders();
        $headers->addHeader(new \Zend\Http\Header\UserAgent('PHPUnit User Agent'));

        /** @var Model\Parameter\User $calculationParameter */
        $tariffs = $this->getApplicationServiceLocator()
            ->get(CalculationService::class)
            ->getCalculations($calculationUserParameter);

        $this->assertInstanceOf(Model\Tariff\Gkv::class, $tariffs[0]);
        $this->assertEquals('5c078fae67bf03fa1a69857151cb11c0', $calculationUserParameter->getCalculationparameterId());
    }

    /**
     * @test
     * @expectedException \Common\Exception\InvalidArgumentException
     */
    public function testInvalidCalculationParameterId()
    {
        /** @var ClassMethods $hydrator */
        $hydrator = $this->getApplicationServiceLocator()->get('HydratorManager')->get('ClassMethods');

        /** @var Model\Parameter\User $calculationUserParameter */
        $calculationUserParameter = $hydrator->hydrate([
            'occupation_group'       => 'employee',
            'current_insurance_type' => 'by_law',
            'zipcode'                => '22177',
            'federal_state'          => 'Hamburg',
            'salary'                 => 60000,
        ], new Model\Parameter\User());

        $this->getGuzzleClientServiceMock([
            $this->getGuzzleWpsetRequestValueMap(),
        ]);

        $this->getCalculationFetchStatus400Mock([
            'calculationparameter_id' => 'error'
        ]);

        try {
            $this->getApplicationServiceLocator()
                ->get(CalculationService::class)
                ->getCalculations($calculationUserParameter);
        } catch (InvalidArgumentException $e) {
            $this->assertArrayHasKey('calculationparameter_id', $e->errors);
            $this->assertEquals(400, $e->getCode());
            throw $e;
        }
    }

    /**
     * @test
     * @expectedException \Common\Exception\RemoteException
     */
    public function testInvalidResponse()
    {
        /** @var ClassMethods $hydrator */
        $hydrator = $this->getApplicationServiceLocator()->get('HydratorManager')->get('ClassMethods');

        /** @var Model\Parameter\User $calculationUserParameter */
        $calculationUserParameter = $hydrator->hydrate([
            'occupation_group'       => 'employee',
            'current_insurance_type' => 'by_law',
            'zipcode'                => '22177',
            'federal_state'          => 'Hamburg',
            'salary'                 => 60000,
        ], new Model\Parameter\User());

        $this->getGuzzleClientServiceMock([
            $this->getGuzzleWpsetRequestValueMap(),
        ]);

        $this->getCalculationFetchStatus500Mock();

        try {
            $this->getApplicationServiceLocator()
                ->get(CalculationService::class)
                ->getCalculations($calculationUserParameter);
        } catch (RemoteException $e) {
            $this->assertEquals(500, $e->getCode());
            throw $e;
        }
    }

}