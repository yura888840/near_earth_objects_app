<?php
/**
 * Created by PhpStorm.
 * User: yuri
 * Date: 19.10.17
 * Time: 13:17
 */

namespace Tests\AppBundle\Services;

use AppBundle\Services\ApiBrowser;

class ApiBrowserTest extends \PHPUnit_Framework_TestCase
{
    /** @var ApiBrowser */
    private $service;

    public function setUp()
    {
        $this->service = new ApiBrowser();
    }

    public function testHandleBrowserResponse()
    {
        $result = [

        ];
        $data = [

        ];

        $expected = [

        ];

        $actual = $this->service->handleBrowserResponse($result, $data);

        $this->assertEquals($actual, $expected);
    }
}
