<?php
/**
 * Created by PhpStorm.
 * User: yuri
 * Date: 19.10.17
 * Time: 13:19
 */

namespace Tests\AppBundle\Services\CrawlerResponseHandlers;

use AppBundle\Services\CrawlerResponseHandlers\BestyearHandler;

class BestyearHandlerTest extends \PHPUnit_Framework_TestCase
{
    /** @var  BestyearHandler */
    private $service;

    public function setUp()
    {
        $this->service = new BestyearHandler();
    }

    public function testHandleBrowserResponse()
    {
        $result = [
            'data' => [
                '2001' => 7,
                '2002' => 2,
                '2009' => 5,
                '2011' => 8
            ],
            'some_link' => '',
        ];
        $data = [
            '2001' => 1,
            '2003' => 3,
            '2008' => 5,
            '2014' => 100
        ];

        $expected = [
            '2001' => 8,
            '2002' => 2,
            '2003' => 3,
            '2008' => 5,
            '2009' => 5,
            '2011' => 8,
            '2014' => 100
        ];

        $actual = $this->service->handleBrowserResponse($result, $data);

        $this->assertEquals($actual, $expected);
    }
}

