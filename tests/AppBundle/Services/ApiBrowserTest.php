<?php
/**
 * Created by PhpStorm.
 * User: yuri
 * Date: 19.10.17
 * Time: 13:17
 */

namespace Tests\AppBundle\Services;

use AppBundle\Services\ApiBrowser;
use AppBundle\Services\ApiClient;
use AppBundle\Services\CrawlerResponseHandlers\ICrawlerResponseHandler;
use AppBundle\Services\ResponseHandlers\IResponseHandler;
use PHPUnit\Framework\TestCase;

class ApiBrowserTest extends TestCase
{
    /** @var ApiBrowser */
    private $service;

    /** @var  IResponseHandler */
    private $responseHandler;

    /** @var  ICrawlerResponseHandler */
    private $crawlerResponseHandler;

    public function setUp()
    {
        $apiClient = $this
            ->getMockBuilder(ApiClient::class)
            ->disableOriginalConstructor()
            ->getMock();

        $apiClient
            ->expects($this->any())
            ->method('doRequest')
            ->withAnyParameters()
            ->will($this->returnValue(true))
        ;

        $this->service = new ApiBrowser($apiClient);

        $this->responseHandler = $this
            ->getMockBuilder(IResponseHandler::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->responseHandler
            ->expects($this->any())
            ->method('handleResponse')
            ->withAnyParameters()
            ->will($this->returnValue(true))
        ;

        $this->crawlerResponseHandler = $this
            ->getMockBuilder(ICrawlerResponseHandler::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->crawlerResponseHandler
            ->expects($this->any())
            ->method('handleBrowserResponse')
            ->withAnyParameters()
            ->will($this->returnValue([]))
        ;
    }

    public function testHandleBrowserResponse()
    {
        $expected = [];

        $actual = $this->service->browse($this->responseHandler, $this->crawlerResponseHandler);

        $this->assertEquals($actual, $expected);
    }
}
