<?php
/**
 * Created by PhpStorm.
 * User: yuri
 * Date: 19.10.17
 * Time: 13:19
 */

namespace Tests\AppBundle\Services\CrawlerResponseHandlers;

use AppBundle\Services\CrawlerResponseHandlers\FastestHandler;
use PHPUnit\Framework\TestCase;

class FastestHandlerTest extends TestCase
{
    /** @var FastestHandler */
    private $service;

    public function setUp()
    {
        $this->service = new FastestHandler();
    }

    public function testHandleBrowserResponseWhenResultGreaterThanData()
    {
        $result = [
            'max_speed' => 15,
            'neo' => [
                'some_data_here_not_important_for_test_1'
            ]
        ];
        $data = [
            'max_speed' => 0,
            'neo' => [
                'some_data_here_not_important_for_test_2'
            ]
        ];

        $expected = [
            'max_speed' => 15,
            'neo' => [
                'some_data_here_not_important_for_test_1'
            ]
        ];

        $actual = $this->service->handleBrowserResponse($result, $data);

        $this->assertEquals($actual, $expected);
    }

    public function testHandleBrowserResponseWhenResultLessThanData()
    {
        $result = [
            'max_speed' => 2,
            'neo' => [
                'some_data_here_not_important_for_test_1'
            ]
        ];
        $data = [
            'max_speed' => 30,
            'neo' => [
                'some_data_here_not_important_for_test_2'
            ]
        ];

        $expected = [
            'max_speed' => 30,
            'neo' => [
                'some_data_here_not_important_for_test_2'
            ]
        ];

        $actual = $this->service->handleBrowserResponse($result, $data);

        $this->assertEquals($actual, $expected);
    }
}
