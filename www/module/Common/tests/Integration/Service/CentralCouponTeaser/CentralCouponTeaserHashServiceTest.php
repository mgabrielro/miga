<?php

namespace Integration\Service\CentralCouponTeaser;

use Common\Model\Lead\LeadModel;
use Common\Service\CentralCouponTeaser\CentralCouponTeaserHashService;
use Common\Service\CentralCouponTeaser\CentralCouponTeaserService;
use Test\AbstractIntegrationTestCase;
use Zend\Hydrator\ClassMethods;

/**
 * Class CentralCouponTeaserHashServiceTest
 *
 * @package Integration\Service\CentralCouponTeaser
 * @author Martin Rintelen <martin.rintelen@check24.de>
 */
class CentralCouponTeaserHashServiceTest extends AbstractIntegrationTestCase
{
    /**
     * @test
     */
    public function itCanBeCreatedFromServiceLocator()
    {
        $service = $this->getService();

        $this->assertInstanceOf(CentralCouponTeaserHashService::class, $service);
    }

    /**
     * @test
     */
    public function itGeneratesCorrectHash()
    {
        $productKey = $this->getApplicationServiceLocator()
            ->get('ZendConfig')
            ->check24
            ->product
            ->key;

        $secret = $this->getApplicationServiceLocator()
            ->get('ZendConfig')
            ->check24
            ->central_coupon_teaser
            ->secret;

        $service = $this->getService();
        $lead = $this->getLead();

        $hash = $service->generateHash($lead);

        $this->assertEquals(
            sha1($productKey . $lead->getId() . $secret),
            $hash
        );
    }

    /**
     *
     * @return CentralCouponTeaserHashService
     */
    protected function getService()
    {
        return $this->getApplicationServiceLocator()
            ->get(CentralCouponTeaserHashService::class);
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