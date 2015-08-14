<?php

namespace SDIS62\Core\Ops\Test\Entity;

use Datetime;
use SDIS62\Core\Ops as Core;
use PHPUnit_Framework_TestCase;

class MaterielTest extends PHPUnit_Framework_TestCase
{
    protected static $object;

    public function setUp()
    {
        $commune      = new Core\Entity\Commune('Arras', '62001');
        $centre       = new Core\Entity\Centre($commune, 'CIS Arras');
        self::$object = new Core\Entity\Materiel($centre, 'VSAV1');
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

        $commune = new Core\Entity\Commune('Bethune', '62002');
        self::$object->setCentre(new Core\Entity\Centre($commune, 'CIS Bethune'));

        $this->assertEquals('CIS Bethune', self::$object->getCentre()->getName());
        $this->assertInstanceOf('SDIS62\Core\Ops\Entity\Centre', self::$object->getCentre());
    }

    public function test_if_it_have_engagements()
    {
        $this->assertCount(0, self::$object->getEngagements());
        $this->assertFalse(self::$object->isEngage());

        $intervention = new Core\Entity\Intervention(new Core\Entity\Sinistre('Feu de'));
        $commune      = new Core\Entity\Commune('Arras', '62001');
        $centre       = new Core\Entity\Centre($commune, 'CIS Arras');
        $pompier      = new Core\Entity\Pompier('DUBUC Kévin', '0001', $centre);

        $engagement1 = new Core\Entity\Engagement\PompierEngagement($intervention, self::$object, $pompier);
        $engagement2 = new Core\Entity\Engagement\PompierEngagement($intervention, self::$object, $pompier);

        $this->assertCount(2, self::$object->getEngagements());
        $this->assertTrue(self::$object->isEngage());

        $intervention->setEnded(new Datetime('tomorrow'));

        $this->assertFalse(self::$object->isEngage());
    }

    public function test_if_it_have_a_coordinates()
    {
        $this->assertNull(self::$object->getCoordinates());

        $coord = new Core\Entity\Coordinates('x', 'y');
        self::$object->setCoordinates($coord);
        $this->assertEquals($coord, self::$object->getCoordinates());
    }

    public function test_if_it_have_statut()
    {
        $this->assertEquals('DISPONIBLE', self::$object->getStatut());

        self::$object->setStatut(Core\Entity\Statut::EN_ALERTE());
        $this->assertEquals('EN_ALERTE', self::$object->getStatut());

        $reflector = new \ReflectionClass(self::$object);
        $property  = $reflector->getProperty('statut');
        $property->setAccessible(true);
        $property->setValue(self::$object, 'DISPONIBLE');
        $this->assertInstanceOf("SDIS62\Core\Ops\Entity\Statut", self::$object->getStatut());
        $this->assertEquals('DISPONIBLE', self::$object->getStatut());
    }
}
