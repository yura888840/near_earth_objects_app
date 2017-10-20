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
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

class ApiClientTest extends TestCase
{
    /** @var ApiClient */
    private $service;

    public function setUp()
    {
        $dummyBody = $this
            ->getMockBuilder(StreamInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $dummyBody
            ->expects($this->any())
            ->method('getContents')
            ->withAnyParameters()
            ->will($this->returnValue('{}'))
        ;

        $dummyResponse = $this
            ->getMockBuilder(ResponseInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $dummyResponse
            ->expects($this->any())
            ->method('getStatusCode')
            ->withAnyParameters()
            ->will($this->returnValue(200))
        ;
        $dummyResponse
            ->expects($this->any())
            ->method('getBody')
            ->withAnyParameters()
            ->will($this->returnValue($dummyBody))
        ;

        $apiKey = 'SOME_DUMMY_KEY';
        $client = $this
            ->getMockBuilder(Client::class)
            ->disableOriginalConstructor()
            ->getMock();

        $client
            ->expects($this->any())
            ->method('request')
            ->withAnyParameters()
            ->will($this->returnValue($dummyResponse))
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
            ->method('handleResponse')
            ->withAnyParameters()
            ->will($this->returnValue(true))
        ;

        $actual = $this->service->doRequest(ApiClient::NEO_BROWSE, [], $responseHandler);

        $this->assertEquals($actual, true);
    }
}
