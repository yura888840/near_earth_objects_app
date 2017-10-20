<?php
/**
 * Created by PhpStorm.
 * User: yuri
 * Date: 18.10.17
 * Time: 14:00
 */

namespace Tests\AppBundle\Services\ResponseHandlers;

use AppBundle\Services\ResponseHandlers\FastestHandler;
use PHPUnit\Framework\TestCase;

class FastestHandlerTest extends TestCase
{
    /** @var FastestHandler */
    private $service;

    public function setUp()
    {
        $this->service = new FastestHandler();
    }

    public function testHandleResponse()
    {
        $data = [
            'near_earth_objects' => [
                [
                    'id' => 1,
                    'is_potentially_hazardous_asteroid' => false,
                    'close_approach_data' => [
                        [
                            'relative_velocity' => [
                                'kilometers_per_second' => 5,
                                '...' => '...'
                            ],
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
                            'relative_velocity' => [
                                'kilometers_per_second' => 10,
                                '...' => '...'
                            ],
                            'close_approach_date' => '2015-01-02',
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
            'neo' => [
                'id' => 3,
                'is_potentially_hazardous_asteroid' => false,
                'close_approach_data' => [
                    [
                        'relative_velocity' => [
                            'kilometers_per_second' => 10,
                            '...' => '...'
                        ],
                        'close_approach_date' => '2015-01-02',
                        'field1' => '...'
                    ],
                ],
                'field1' => '...',
                'field2' => '...'
            ],
            'max_speed' => 10
        ];

        $actual = $this->service->handleResponse($data);

        $this->assertEquals($actual, $expected);
    }
}
