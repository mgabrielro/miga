<?php

namespace Common\Service\Factory;

use Common\Service\SubsequentInformationService;
use Test\AbstractIntegrationTestCase;

/**
 * Class SubsequentInformationFactoryTest
 *
 * @package Common\Service\Factory
 * @author  Alexis Peters <alexis.peters@check24.de>
 */
class SubsequentInformationFactoryTest extends AbstractIntegrationTestCase
{
    /**
     * @test
     */
    public function invokeFactoryShouldReturnAnObjectOfTypeSubsequentInformationService()
    {
        $factory = new SubsequentInformationServiceFactory();
        $class = $factory($this->getApplicationServiceLocator());

        $this->assertInstanceOf(SubsequentInformationService::class, $class);
    }
}