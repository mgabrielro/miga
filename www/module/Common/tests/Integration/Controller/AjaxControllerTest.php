<?php

namespace Common\Controller;

use C24Efeedback\Request\FeedbackRequestMockTrait;
use Common\Request\WpsetRequestMockTrait;
use Zend\Json;
use Test\AbstractIntegrationTestCase;
use Common\Request\CityRequestMockTrait;
use Common\Request\StreetRequestMockTrait;

/**
 * Tests for ajax controller
 *
 * @author Lars Kneschke <lars.kneschke@check24.de>
 * @author Robert Eichholtz <robert.eichholtz@check24.de>
 * @package Application\Controller
 */
class AjaxControllerTest extends AbstractIntegrationTestCase
{
    use WpsetRequestMockTrait;
    use CityRequestMockTrait;
    use FeedbackRequestMockTrait;
    use StreetRequestMockTrait;

    /**
     * test route /ajax/json/city/[:zipcode]/
     */
    public function testRouteCity()
    {
        $this->getGuzzleClientServiceMock([
            $this->getGuzzleWpsetRequestValueMap(),
            $this->getGuzzleCityRequestValueMap('24247', false)
        ]);

        $this->dispatch('/ajax/json/city/24247/');
        $this->assertNull(
            $this->getApplication()->getMvcEvent()->getParam('exception')
        );
        $this->assertResponseStatusCode(200);

        $this->assertMatchedRouteName('ajax_json/city');
        $this->assertResponseHeaderContains('content-type', 'application/json; charset=utf-8');

        $this->assertJson($this->getResponse()->getContent());

        $result = Json\Decoder::decode($this->getResponse()->getContent());

        $this->assertObjectHasAttribute('status', $result);
        $this->assertEquals('OK', $result->status);
        $this->assertObjectHasAttribute('content', $result);
    }

    /**
     * test route /ajax/json/street/[:zipcode]/[:city]/
     */
    public function testRouteStreet()
    {
        $this->getGuzzleClientServiceMock([
            $this->getGuzzleWpsetRequestValueMap(),
            $this->getGuzzleStreetRequestValueMap('24247', 'Mielkendorf', false)
        ]);

        $this->dispatch('/ajax/json/street/24247/Mielkendorf/');
        $this->assertNull(
            $this->getApplication()->getMvcEvent()->getParam('exception')
        );
        $this->assertResponseStatusCode(200);

        $this->assertMatchedRouteName('ajax_json/street');
        $this->assertResponseHeaderContains('content-type', 'application/json; charset=utf-8');

        $this->assertJson($this->getResponse()->getContent());

        $result = Json\Decoder::decode($this->getResponse()->getContent());

        $this->assertObjectHasAttribute('status', $result);
        $this->assertEquals('OK', $result->status);
        $this->assertObjectHasAttribute('content', $result);
    }

    /**
     * test route /ajax/json/efeedback/:product_id/:provider_id/
     */
    public function testRouteEFeedback()
    {
        $this->markTestSkipped('AjaxControllerTest::testRouteEFeedback currently not implemented.');

        $this->getGuzzleClientServiceMock([
            $this->getGuzzleWpsetRequestValueMap(),
            $this->getGuzzleFeedbackEFeedbacksRequestValueMap(10, 11, [
                'limit'    => 5,
                'offset'   => 0,
                'min_rate' => 1,
                'max_rate' => 2,
                'filter'   => 'provider'
            ]),
            $this->getGuzzleFeedbackEFeedbacksRequestValueMap(10, 11, [
                'limit'    => 5,
                'offset'   => 0,
                'min_rate' => 1,
                'max_rate' => 2,
                'filter'   => 'provider'
            ])
        ]);

        $this->dispatch('/ajax/json/efeedback/10/11/?stars=1');
        $this->assertNull(
            $this->getApplication()->getMvcEvent()->getParam('exception')
        );
        $this->assertResponseStatusCode(200);

        $this->assertMatchedRouteName('ajax_json/efeedback');
        $this->assertResponseHeaderContains('content-type', 'application/json; charset=utf-8');

        $this->assertJson($this->getResponse()->getContent());

        $result = Json\Decoder::decode($this->getResponse()->getContent());

        $this->assertObjectHasAttribute('status', $result);
        $this->assertEquals('OK', $result->status);
        $this->assertObjectHasAttribute('content', $result);
    }
}