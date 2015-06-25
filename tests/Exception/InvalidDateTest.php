<?php

namespace SDIS62\Core\Ops\Test\Exception;

use SDIS62\Core\Ops as Core;
use PHPUnit_Framework_TestCase;

class InvalidDateTest
{
    protected static $object;

    public function setUp()
    {
        self::$object = new Core\Exception\InvalidDate();
    }

    public function test_if_it_is_initializable()
    {
        $this->assertInstanceOf('\Exception', self::$object);
    }
}
