<?php

namespace SDIS62\Core\Ops\Test\Entity;

use PHPUnit_Framework_TestCase;
use SDIS62\Core\Ops as Core;

class EvenementTest extends PHPUnit_Framework_TestCase
{
    protected static $object;

    public function setUp()
    {
        self::$object = new Core\Entity\Evenement('Description');
    }

    public function test_if_it_have_an_id()
    {
        self::$object->setId(10);
        $this->assertEquals(10, self::$object->getId());
    }

    public function test_if_it_is_initializable()
    {
        $this->assertInstanceOf('SDIS62\Core\Ops\Entity\Evenement', self::$object);
    }

    public function test_if_it_have_a_date()
    {
        $this->assertInstanceOf('Datetime', self::$object->getDate());
    }

    public function test_if_it_have_a_description()
    {
        $this->assertEquals('Description', self::$object->getDescription());
    }
}
