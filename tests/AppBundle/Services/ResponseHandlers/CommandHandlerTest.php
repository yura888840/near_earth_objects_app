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

class CommandHandlerTest extends \PHPUnit_Framework_TestCase
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
            ->method('all')
            ->withAnyParameters()
            ->will($this->returnValue(true))
        ;

        $this->service = new CommandHandler($em);
    }

    public function testHandleBrowserResponse()
    {
        $data = [
            'element_count' => 2,
            'near_earth_objects' => [
                [],
                []
            ]
        ];

        $expected = 2;

        $actual = $this->service->handleBrowserResponse($data);

        $this->assertEquals($actual, $expected);
    }
}
