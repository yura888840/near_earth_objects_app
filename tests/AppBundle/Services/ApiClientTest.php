<?php
/**
 * Created by PhpStorm.
 * User: yuri
 * Date: 18.10.17
 * Time: 13:25
 */

namespace Tests\AppBundle\Services;

use AppBundle\Services\ApiClient;
use AppBundle\Services\ResponseHandlers\IResponseHandler;
use GuzzleHttp\Client;

class ApiClientTest extends \PHPUnit_Framework_TestCase
{
    /** @var ApiClient */
    private $service;

    public function setUp()
    {
        $apiKey = 'SOME_DUMMY_KEY';
        $client = $this
            ->getMockBuilder(Client::class)
            ->disableOriginalConstructor()
            ->getMock();

        $client
            ->expects($this->any())
            ->method('all')
            ->withAnyParameters()
            ->will($this->returnValue(true))
        ;
        $this->service = new ApiClient($client, $apiKey);
    }

    public function testDummy()
    {
        $responseHandler = $this
            ->getMockBuilder(IResponseHandler::class)
            ->disableOriginalConstructor()
            ->getMock();

        $responseHandler
            ->expects($this->any())
            ->method('all')
            ->withAnyParameters()
            ->will($this->returnValue(true))
        ;

        $actual = $this->service->doRequest(ApiClient::NEO_BROWSE, [], $responseHandler);

        $this->assertEquals($actual, true);
    }
}
