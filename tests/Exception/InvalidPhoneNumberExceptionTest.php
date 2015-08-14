<?php

namespace SDIS62\Core\Ops\Test\Exception;

use SDIS62\Core\Ops as Core;

class InvalidPhoneNumberExceptionTest
{
    protected static $object;

    public function setUp()
    {
        self::$object = new Core\Exception\InvalidPhoneNumberException();
    }

    public function test_if_it_is_initializable()
    {
        $this->assertInstanceOf('\Exception', self::$object);
    }
}
