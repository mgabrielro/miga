<?php

namespace Integration\Model\Lead\Factory;

use Common\Model\Lead\Factory\LeadModelFactory;
use Common\Model\Lead\LeadModel;
use Test\AbstractIntegrationTestCase;

/**
 * Class LeadModelFactoryTest
 *
 * @package Integration\Model\Lead\Factory
 * @author Martin Rintelen <martin.rintelen@check24.de>
 */
class LeadModelFactoryTest extends AbstractIntegrationTestCase
{
    /**
     * @test
     */
    public function itCanBeCreatedFromServiceLocator()
    {
        $service = $this->getService();

        $this->assertInstanceOf(LeadModelFactory::class, $service);
    }

    /**
     * @test
     */
    public function itCreatesLeadModelInstance()
    {
        $service = $this->getService();

        $this->assertInstanceOf(
            LeadModel::class,
            $service()
        );
    }

    /**
     * @return LeadModelFactory
     */
    protected function getService()
    {
        return $this->getApplicationServiceLocator()
            ->get(LeadModelFactory::class);
    }
}