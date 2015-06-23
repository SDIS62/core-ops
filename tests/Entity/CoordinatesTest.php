<?php

namespace SDIS62\Core\Ops\Test\Entity;

use Datetime;
use SDIS62\Core\Ops as Core;
use PHPUnit_Framework_TestCase;

class CoordinatesTest extends PHPUnit_Framework_TestCase
{
    protected static $object;

    public function setUp()
    {
        self::$object = new Core\Entity\Coordinates('x', 'y');
    }

    public function test_if_it_is_initializable()
    {
        $this->assertInstanceOf('SDIS62\Core\Ops\Entity\Coordinates', self::$object);
    }

    public function test_if_it_have_latitude()
    {
        $this->assertEquals('x', self::$object->getLatitude());
    }

    public function test_if_it_have_longitude()
    {
        $this->assertEquals('y', self::$object->getLongitude());
    }

    public function test_if_it_have_a_date()
    {
        $now = new Datetime('NOW');
        $this->assertInstanceOf('\Datetime', self::$object->getDate());
        $this->assertEquals($now->format('Y-m-d H:i'), self::$object->getDate()->format('Y-m-d H:i'));
    }
}
