<?php

namespace Common\View\Helper\Factory;

use C24\ZF2\User\View\Helper\AuthenticationHelper;
use C24\ZF2\User\View\Helper\Factory\AuthenticationHelperFactory;
use Test\AbstractIntegrationTestCase;

class AuthenticationHelperFactoryTest extends AbstractIntegrationTestCase
{
    /**
     * test helper class
     */
    public function testFactory()
    {
        /** @var AuthenticationHelper $class */
        $factory = new AuthenticationHelperFactory();
        $class = $factory($this->getApplicationServiceLocator()->get('ViewHelperManager'));

        $this->assertInstanceOf(AuthenticationHelper::class, $class);
    }

    /**
     * try to get instance of helper via servicemanager
     */
    public function testServiceManager()
    {
        /** @var  $class */
        $class = $this->getApplicationServiceLocator()->get('ViewHelperManager')->get('authentication');

        $this->assertInstanceOf(AuthenticationHelper::class, $class);
    }
}