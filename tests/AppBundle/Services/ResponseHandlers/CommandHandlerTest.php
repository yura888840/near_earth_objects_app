<?php
/**
 * Created by PhpStorm.
 * User: yuri
 * Date: 18.10.17
 * Time: 13:59
 */

namespace Tests\AppBundle\Services\ResponseHandlers;

use AppBundle\Services\ResponseHandlers\CommandHandler;
use Doctrine\ORM\EntityManager;
use PHPUnit\Framework\TestCase;

class CommandHandlerTest extends TestCase
{
    /** @var CommandHandler */
    private $service;

    public function setUp()
    {
        $em = $this
            ->getMockBuilder(EntityManager::class)
            ->disableOriginalConstructor()
            ->getMock();

        $em
            ->expects($this->any())
            ->method('merge')
            ->withAnyParameters()
            ->will($this->returnValue(true))
        ;

        $em
            ->expects($this->any())
            ->method('flush')
            ->withAnyParameters()
            ->will($this->returnValue(true))
        ;

        $this->service = new CommandHandler($em);
    }

    public function testHandleResponse()
    {
        $data = [
            'element_count' => 2,
            'near_earth_objects' => [
                [],
                []
            ]
        ];

        $expected = 2;

        $actual = $this->service->handleResponse($data);

        $this->assertEquals($actual, $expected);
    }
}
