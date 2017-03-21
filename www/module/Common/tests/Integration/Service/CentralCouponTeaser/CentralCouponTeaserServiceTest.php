<?php

namespace Integration\Service\CentralCouponTeaser;

use Common\Model\Lead\LeadModel;
use Common\Service\CentralCouponTeaser\CentralCouponTeaserHashService;
use Common\Service\CentralCouponTeaser\CentralCouponTeaserService;
use Test\AbstractIntegrationTestCase;
use Zend\Hydrator\ClassMethods;

/**
 * Class CentralCouponTeaserServiceTest
 *
 * @package Integration\Service\CentralCouponTeaser
 * @author Martin Rintelen <martin.rintelen@check24.de>
 */
class CentralCouponTeaserServiceTest extends AbstractIntegrationTestCase
{
    /**
     * @test
     */
    public function itCanBeCreatedFromServiceLocator()
    {
        $service = $this->getService();

        $this->assertInstanceOf(CentralCouponTeaserService::class, $service);
    }

    /**
     * @test
     */
    public function itFillsCustomerData()
    {
        $service = $this->getService();
        $lead = $this->getLead();

        $data = $service->buildRequestData($lead);

        $this->assertInternalType('array', $data);
        $this->assertArrayHasKey('customer', $data);

        $customerData = $data['customer'];

        $requiredData = [
            'firstname' => $lead->getFirstname(),
            'lastname'  => $lead->getLastname(),
            'birthday'  => $lead->getBirthdate(),
            'email'     => $lead->getEmail(),
            'user_id'   => $lead->getC24LoginUserId()
        ];

        foreach ($requiredData as $dataKey => $expectedValue) {
            $this->assertArrayHasKey($dataKey, $customerData);
            $this->assertEquals($expectedValue, $customerData[$dataKey]);
        }
    }

    /**
     * @test
     */
    public function itFillsAuthData()
    {
        $service = $this->getService();
        $lead = $this->getLead();

        $data = $service->buildRequestData($lead);

        $this->assertInternalType('array', $data);
        $this->assertArrayHasKey('auth', $data);

        $authData = $data['auth'];

        /** @var CentralCouponTeaserHashService $hashService */
        $hashService = $this->getApplicationServiceLocator()
            ->get(CentralCouponTeaserHashService::class);

        $requiredData = [
            'product' => 'gkv',
            'lead_id' => $lead->getId(),
            'hash'    => $hashService->generateHash($lead),
        ];

        foreach ($requiredData as $dataKey => $expectedValue) {
            $this->assertArrayHasKey($dataKey, $authData);
            $this->assertEquals($expectedValue, $authData[$dataKey]);
        }
    }

    /**
     *
     * @return CentralCouponTeaserService
     */
    protected function getService()
    {
        return $this->getApplicationServiceLocator()
            ->get(CentralCouponTeaserService::class);
    }

    /**
     * @return object|LeadModel
     */
    protected function getLead()
    {
        $hydrator = new ClassMethods();

        return $hydrator->hydrate(
            [
                'id'             => 1,
                'salutation'     => 'female',
                'firstname'      => 'Test',
                'lastname'       => 'Test',
                'birthdate'      => '2000-10-05',
                'email'          => 'gkv-dev@check24.de',
                'c24LoginUserId' => 12345,
            ],
            new LeadModel()
        );
    }
}