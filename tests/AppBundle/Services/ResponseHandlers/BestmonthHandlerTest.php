<?php
/**
 * Created by PhpStorm.
 * User: yuri
 * Date: 18.10.17
 * Time: 13:59
 */

namespace Tests\AppBundle\Services\ResponseHandlers;

use AppBundle\Services\ResponseHandlers\BestmonthHandler;

class BestmonthHandlerTest extends \PHPUnit_Framework_TestCase
{
    /** @var BestmonthHandler */
    private $service;

    public function setUp()
    {
        $this->service = new BestmonthHandler();
    }

    public function testHandleBrowserResponse()
    {
        $data = [
            'near_earth_objects' => [
                [
                    'id' => 1,
                    'is_potentially_hazardous_asteroid' => false,
                    'close_approach_data' => [
                        [
                            'close_approach_date' => '2017-01-01',
                            'field1' => '...'
                        ],
                    ],
                    'field1' => '...',
                    'field2' => '...'
                ],
                [
                    'id' => 2,
                    'is_potentially_hazardous_asteroid' => true,
                    'close_approach_data' => [
                        [
                            'close_approach_date' => '2017-02-01',
                            'field1' => '...'
                        ],
                    ],
                    'field1' => '...',
                    'field2' => '...'
                ],
                [
                    'id' => 3,
                    'is_potentially_hazardous_asteroid' => false,
                    'close_approach_data' => [
                        [
                            'close_approach_date' => '2017-01-02',
                            'field1' => '...'
                        ],
                    ],
                    'field1' => '...',
                    'field2' => '...'
                ],
            ],
            'links' => [
                'next' => 'some_link'
            ]
        ];

        $expected = [
            'next' => 'some_link',
            'data' => [
                '01' => 2
            ]
        ];

        $actual = $this->service->handleBrowserResponse($data);

        $this->assertEquals($actual, $expected);
    }
}
