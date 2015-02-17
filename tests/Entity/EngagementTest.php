<?php

namespace SDIS62\Core\Ops\Test\Entity;

use Mockery;
use Datetime;
use SDIS62\Core\Ops as Core;
use PHPUnit_Framework_TestCase;

class EngagementTest extends PHPUnit_Framework_TestCase
{
    protected static $object;

    public function setUp()
    {
        $sinistre = new Core\Entity\Sinistre("Feu de");
        $intervention = new Core\Entity\Intervention($sinistre);
        $centre = new Core\Entity\Centre("CIS Arras");
        $materiel = new Core\Entity\Materiel($centre, "VSAV1");

        self::$object = Mockery::mock('SDIS62\Core\Ops\Entity\Engagement', array($intervention, $materiel))->makePartial();
    }

    public function test_if_it_have_an_id()
    {
        self::$object->setId(10);
        $this->assertEquals(10, self::$object->getId());
    }

    public function test_if_it_is_initializable()
    {
        $this->assertInstanceOf('SDIS62\Core\Ops\Entity\Engagement', self::$object);
    }

    public function test_if_it_have_a_intervention()
    {
        $this->assertInstanceOf('SDIS62\Core\Ops\Entity\Intervention', self::$object->getIntervention());
    }

    public function test_if_it_have_a_materiel()
    {
        $this->assertInstanceOf('SDIS62\Core\Ops\Entity\Materiel', self::$object->getMateriel());
    }

    public function test_if_it_have_an_etat()
    {
        self::$object->setEtat("En cours");
        $this->assertEquals("En cours", self::$object->getEtat());
    }

    public function test_if_it_have_a_date()
    {
        $now = new Datetime('NOW');
        $this->assertInstanceOf('\Datetime', self::$object->getDate());
        $this->assertEquals($now->format('Y-m-d H:i'), self::$object->getDate()->format('Y-m-d H:i'));
    }

    public function test_if_it_throw_an_exception_if_engagement_is_not_valid()
    {
        try {
            self::$object->getType();
        } catch (Core\Exception\InvalidEngagementException $e) {
            return;
        }
        $this->fail('Exception must be throw');
    }
}
