<?php

namespace Integration\Model\Lead\Builder;

use Common\Model\Lead\Builder\LeadModelBuilder;
use Common\Model\Lead\LeadModel;
use Test\AbstractIntegrationTestCase;

/**
 * Class LeadModelBuilderTest
 *
 * @package Integration\Model\Lead\Builder
 * @author Martin Rintelen <martin.rintelen@check24.de>
 */
class LeadModelBuilderTest extends AbstractIntegrationTestCase
{
    /**
     * @test
     */
    public function itCanBeCreatedFromServiceLocator()
    {
        $service = $this->getService();

        $this->assertInstanceOf(LeadModelBuilder::class, $service);
    }

    /**
     * @test
     */
    public function itBuildsModelFromArrayData()
    {
        $data = [
            'id'             => 1,
            'salutation'     => 'female',
            'firstname'      => 'Test',
            'lastname'       => 'Test',
            'birthdate'      => '2000-10-05',
            'email'          => 'gkv-dev@check24.de',
            'c24LoginUserId' => 12345,
        ];

        $lead = $this->getService()->build($data);

        $this->assertInstanceOf(LeadModel::class, $lead);

        $this->assertEquals($data['id'], $lead->getId());
        $this->assertEquals($data['salutation'], $lead->getSalutation());
        $this->assertEquals($data['firstname'], $lead->getFirstname());
        $this->assertEquals($data['lastname'], $lead->getLastname());
        $this->assertEquals($data['birthdate'], $lead->getBirthdate());
        $this->assertEquals($data['email'], $lead->getEmail());
        $this->assertEquals($data['c24LoginUserId'], $lead->getC24LoginUserId());
    }

    /**
     * @test
     */
    public function itBuildsModelFromRegisterData()
    {
        $data = [
            'lead_id'          => 1,
            'salutation'       => 'female',
            'insure_firstname' => 'Test',
            'insure_lastname'  => 'Test',
            'birthdate'        => '2000-10-05',
            'email'            => 'gkv-dev@check24.de',
            'c24login_user_id' => 12345,
        ];

        $lead = $this->getService()->buildFromRegisterData($data);

        $this->assertInstanceOf(LeadModel::class, $lead);

        $this->assertEquals($data['lead_id'], $lead->getId());
        $this->assertEquals($data['salutation'], $lead->getSalutation());
        $this->assertEquals($data['insure_firstname'], $lead->getFirstname());
        $this->assertEquals($data['insure_lastname'], $lead->getLastname());
        $this->assertEquals($data['birthdate'], $lead->getBirthdate());
        $this->assertEquals($data['email'], $lead->getEmail());
        $this->assertEquals($data['c24login_user_id'], $lead->getC24LoginUserId());
    }

    /**
     * @return LeadModelBuilder
     */
    protected function getService()
    {
        return $this->getApplicationServiceLocator()
            ->get(LeadModelBuilder::class);
    }
}