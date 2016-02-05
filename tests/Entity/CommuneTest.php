<?php

namespace SDIS62\Core\Ops\Test\Entity;

use PHPUnit_Framework_TestCase;
use SDIS62\Core\Ops as Core;

class CommuneTest extends PHPUnit_Framework_TestCase
{
    protected static $object;

    public function setUp()
    {
        self::$object = new Core\Entity\Commune('Arras', '62001');
    }

    public function test_if_it_have_an_numinsee()
    {
        $this->assertEquals('62001', self::$object->getNumInsee());
    }

    public function test_if_it_is_initializable()
    {
        $this->assertInstanceOf('SDIS62\Core\Ops\Entity\Commune', self::$object);
    }

    public function test_if_it_have_a_name()
    {
        $this->assertEquals('Arras', self::$object->getName());

        self::$object->setName('Arras');

        $this->assertEquals('Arras', self::$object->getName());
        $this->assertInternalType('string', self::$object->getName());
    }

    public function test_if_it_have_centres()
    {
        $this->assertCount(0, self::$object->getCentres());

        $centre = new Core\Entity\Centre(self::$object, 'CIS Arras');

        $this->assertCount(1, self::$object->getCentres());
    }
}
