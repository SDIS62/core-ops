<?php

namespace SDIS62\Core\Ops\Test\Exception;

use PHPUnit_Framework_TestCase;
use SDIS62\Core\Ops as Core;

class InvalidEngagementExceptionTest extends PHPUnit_Framework_TestCase
{
    protected static $object;

    public function setUp()
    {
        self::$object = new Core\Exception\InvalidEngagementException();
    }

    public function test_if_it_is_initializable()
    {
        $this->assertInstanceOf('\Exception', self::$object);
    }
}
