<?php

namespace CommonTest\Controller\Plugin;

use Common\Controller\Plugin\FormPostRedirectGet;
use PHPUnit_Framework_MockObject_MockObject;
use Test\AbstractUnitTestCase;
use Zend\Http\Request;
use Zend\Http\Response;
use Zend\Mvc\Controller\AbstractController;
use Zend\Session\Container;
use Zend\Stdlib\Parameters;

/**
 * Class FormPostRedirectGetTest
 *
 * @package CommonTest\Controller\Plugin
 * @author  Christian Blank <christian.blank@check24.de>
 */
class FormPostRedirectGetTest extends AbstractUnitTestCase
{
    /**
     * @test
     */
    public function returnsFalseOnInitialGet()
    {
        $request = $this->createRequest(['isPost' => false]);
        $controller = $this->createController($request);
        $form = $this->createForm();

        $formPrg = new FormPostRedirectGet(new Container());
        $formPrg->setController($controller);
        $prgResult = $formPrg($form, 'home');

        $this->assertFalse($prgResult);
    }

    /**
     * @test
     */
    public function itRedirectsOnPost()
    {
        $request = $this->createRequest(
            [
                'isPost'  => true,
                'getPost' => new Parameters(),
            ]
        );
        $response = $this->createResponse();
        $response->method('setStatusCode')->with($this->equalTo(303));
        $pluginManager = $this->createPluginManager($response);
        $controller = $this->createController($request, $pluginManager);
        $form = $this->createForm();

        $formPrg = new FormPostRedirectGet(new Container());
        $formPrg->setController($controller);
        /** @var Response $prgResult */
        $prgResult = $formPrg($form, 'home');

        $this->assertInstanceOf('Zend\Http\Response', $prgResult);
    }

    /**
     * @test
     */
    public function appliesFormDataAndErrors()
    {
        $request = $this->createRequest(
            [
                'isPost' => false,
            ]
        );
        $response = $this->createResponse();
        $response->method('setStatusCode')->with($this->equalTo(303));
        $pluginManager = $this->createPluginManager($response);
        $controller = $this->createController($request, $pluginManager);

        $sessionContainer = new Container();
        $sessionContainer->post = ['PostData'];
        $sessionContainer->isValid = false;
        $sessionContainer->errors = ['FooError'];

        $form = $this->createForm();
        $form->method('setData')->with($this->equalTo(['PostData']));
        $form->method('setMessages')->with($this->equalTo(['FooError']));

        $formPrg = new FormPostRedirectGet($sessionContainer);
        $formPrg->setController($controller);
        /** @var Response $prgResult */
        $prgResult = $formPrg($form, 'home');

        $this->assertEquals(['PostData'], $prgResult);
    }

    /**
     * @param array $definition
     *
     * @return PHPUnit_Framework_MockObject_MockObject
     */
    private function createRequest($definition)
    {
        return $this->buildStub(Request::class, $definition);
    }

    /**
     * @return PHPUnit_Framework_MockObject_MockObject
     */
    private function createResponse()
    {
        return $this->buildStub(Response::class, []);
    }

    /**
     * @param PHPUnit_Framework_MockObject_MockObject $response
     *
     * @return PHPUnit_Framework_MockObject_MockObject
     */
    private function createPluginManager($response)
    {
        $pluginManager = $this->buildStub(
            'Zend\Mvc\Controller\PluginManager',
            [
                'get' => $this->buildStub(
                    'Zend\Mvc\Controller\Plugin\Redirect',
                    ['toRoute' => $response]
                ),
            ]
        );

        return $pluginManager;
    }

    /**
     * @return PHPUnit_Framework_MockObject_MockObject
     */
    private function createForm()
    {
        $form = $this->buildStub('Zend\Form\Form', []);

        return $form;
    }

    /**
     * @param PHPUnit_Framework_MockObject_MockObject $request
     * @param PHPUnit_Framework_MockObject_MockObject $pluginManager
     *
     * @return PHPUnit_Framework_MockObject_MockObject
     */
    private function createController($request, $pluginManager = null)
    {
        $controller = $this->buildStub(
            AbstractController::class,
            [
                'getRequest'       => $request,
                'getPluginManager' => $pluginManager,
            ]
        );

        return $controller;
    }

}