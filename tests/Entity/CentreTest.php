<?php

namespace SDIS62\Core\Ops\Test\Entity;

use SDIS62\Core\Ops as Core;
use PHPUnit_Framework_TestCase;

class CentreTest extends PHPUnit_Framework_TestCase
{
    protected static $object;

    public function setUp()
    {
        $commune = new Core\Entity\Commune('Arras', '62001');
        self::$object = new Core\Entity\Centre($commune, "CIS Arras");
    }

    public function test_if_it_have_an_id()
    {
        self::$object->setId(10);
        $this->assertEquals(10, self::$object->getId());
    }

    public function test_if_it_is_initializable()
    {
        $this->assertInstanceOf('SDIS62\Core\Ops\Entity\Centre', self::$object);
    }

    public function test_if_it_have_a_name()
    {
        $this->assertEquals('CIS Arras', self::$object->getName());

        self::$object->setName('CIS Bethune');

        $this->assertEquals('CIS Bethune', self::$object->getName());
        $this->assertInternalType('string', self::$object->getName());
    }

    public function test_if_it_have_materiels()
    {
        $materiel1 = new Core\Entity\Materiel(self::$object, "VSAV1");
        $materiel2 = new Core\Entity\Materiel(self::$object, "VSAV2");

        $this->assertCount(2, self::$object->getMateriels());
    }

    public function test_if_it_have_commune()
    {
        $this->assertInstanceOf('SDIS62\Core\Ops\Entity\Commune', self::$object->getCommune());
    }
}
