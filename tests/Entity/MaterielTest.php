<?php

namespace SDIS62\Core\Ops\Test\Entity;

use SDIS62\Core\Ops as Core;
use PHPUnit_Framework_TestCase;

class MaterielTest extends PHPUnit_Framework_TestCase
{
    protected static $object;

    public function setUp()
    {
        $centre = new Core\Entity\Centre("CIS Arras");
        self::$object = new Core\Entity\Materiel($centre, "VSAV1");
    }

    public function test_if_it_have_an_id()
    {
        self::$object->setId(10);
        $this->assertEquals(10, self::$object->getId());
    }

    public function test_if_it_is_initializable()
    {
        $this->assertInstanceOf('SDIS62\Core\Ops\Entity\Materiel', self::$object);
    }

    public function test_if_it_have_a_name()
    {
        $this->assertEquals('VSAV1', self::$object->getName());

        self::$object->setName('VSAV2');

        $this->assertEquals('VSAV2', self::$object->getName());
        $this->assertInternalType('string', self::$object->getName());
    }

    public function test_if_it_have_a_centre()
    {
        $this->assertInstanceOf('SDIS62\Core\Ops\Entity\Centre', self::$object->getCentre());

        self::$object->setCentre(new Core\Entity\Centre("CIS Bethune"));

        $this->assertEquals('CIS Bethune', self::$object->getCentre()->getName());
        $this->assertInstanceOf('SDIS62\Core\Ops\Entity\Centre', self::$object->getCentre());
    }

    public function test_if_it_have_a_etat()
    {
        self::$object->setEtat('Disponible');

        $this->assertEquals('Disponible', self::$object->getEtat());
        $this->assertInternalType('string', self::$object->getEtat());
    }
}
