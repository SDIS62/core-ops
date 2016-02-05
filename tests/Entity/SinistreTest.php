<?php

namespace SDIS62\Core\Ops\Test\Entity;

use PHPUnit_Framework_TestCase;
use SDIS62\Core\Ops as Core;

class SinistreTest extends PHPUnit_Framework_TestCase
{
    protected static $object;

    public function setUp()
    {
        self::$object = new Core\Entity\Sinistre('Feu de');
    }

    public function test_if_it_have_an_id()
    {
        self::$object->setId(10);
        $this->assertEquals(10, self::$object->getId());
    }

    public function test_if_it_is_initializable()
    {
        $this->assertInstanceOf('SDIS62\Core\Ops\Entity\Sinistre', self::$object);
    }

    public function test_if_it_have_a_name()
    {
        $this->assertEquals('Feu de', self::$object->getName());

        self::$object->setName('TA');

        $this->assertEquals('TA', self::$object->getName());
        $this->assertInternalType('string', self::$object->getName());
    }
}
