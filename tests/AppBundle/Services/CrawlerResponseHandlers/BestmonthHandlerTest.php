<?php
/**
 * Created by PhpStorm.
 * User: yuri
 * Date: 19.10.17
 * Time: 13:17
 */

namespace Tests\AppBundle\Services\CrawlerResponseHandlers;

use AppBundle\Services\CrawlerResponseHandlers\BestmonthHandler;

class BestmonthHandlerTest extends \PHPUnit_Framework_TestCase
{
    /** @var  BestmonthHandler */
    private $service;

    public function setUp()
    {
        $this->service = new BestmonthHandler();
    }

    public function testHandleBrowserResponse()
    {
        $result = [
            'data' => [
                '01' => 7,
                '02' => 2,
                '09' => 5,
                '11' => 8
            ],
            'some_link' => '',
        ];
        $data = [
            '01' => 1,
            '03' => 3,
            '08' => 5,
            '11' => 100
        ];

        $expected = [
            '01' => 8,
            '02' => 2,
            '03' => 3,
            '08' => 5,
            '09' => 5,
            '11' => 108
        ];

        $actual = $this->service->handleBrowserResponse($result, $data);

        $this->assertEquals($actual, $expected);
    }
}