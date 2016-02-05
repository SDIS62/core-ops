<?php

namespace SDIS62\Core\Ops\Test\Exception;

use PHPUnit_Framework_TestCase;
use SDIS62\Core\Ops as Core;

class InvalidPompierExceptionTest extends PHPUnit_Framework_TestCase
{
    protected static $object;

    public function setUp()
    {
        self::$object = new Core\Exception\InvalidPompierException();
    }

    public function test_if_it_is_initializable()
    {
        $this->assertInstanceOf('\Exception', self::$object);
    }
}
