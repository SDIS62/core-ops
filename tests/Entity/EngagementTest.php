<?php

namespace SDIS62\Core\Ops\Test\Entity;

use Mockery;
use Datetime;
use DateInterval;
use SDIS62\Core\Ops as Core;
use PHPUnit_Framework_TestCase;

class EngagementTest extends PHPUnit_Framework_TestCase
{
    protected static $object;

    public function setUp()
    {
        $sinistre     = new Core\Entity\Sinistre('Feu de');
        $intervention = new Core\Entity\Intervention($sinistre);

        self::$object = Mockery::mock('SDIS62\Core\Ops\Entity\Engagement', [$intervention])->makePartial();
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

    public function test_if_it_have_evenements()
    {
        self::$object->shouldReceive('setUpdated')->times(3);

        $this->assertCount(0, self::$object->getEvenements());

        self::$object->addEvenement(new Core\Entity\Evenement('Arrive sur les lieux'));
        self::$object->addEvenement(new Core\Entity\Evenement('Intervention terminee', '01-01-2050 15:00:00'));
        self::$object->addEvenement(new Core\Entity\Evenement('Secours', new Datetime('tomorrow')));

        $this->assertCount(3, self::$object->getEvenements());
        $this->assertEquals('Arrive sur les lieux', self::$object->getEvenements()[0]->getDescription());
        $this->assertEquals('Secours', self::$object->getEvenements()[1]->getDescription());
        $this->assertEquals('Intervention terminee', self::$object->getEvenements()[2]->getDescription());
    }

    public function test_if_it_have_a_create_date()
    {
        $now = new Datetime('NOW');
        $this->assertInstanceOf('\Datetime', self::$object->getCreated());
        $this->assertEquals($now->format('Y-m-d H:i'), self::$object->getCreated()->format('Y-m-d H:i'));
    }

    public function test_if_it_have_a_update_date()
    {
        $this->assertNull(self::$object->getUpdated());

        $created = self::$object->getCreated();
        self::$object->setUpdated($created);
        $this->assertNull(self::$object->getUpdated());

        $old = $created->sub(new DateInterval('PT1H'));
        self::$object->setUpdated($old);
        $this->assertNull(self::$object->getUpdated());

        $updated = new Datetime('tomorrow');
        self::$object->setUpdated($updated);
        $this->assertEquals($updated, self::$object->getUpdated());

        self::$object->setUpdated('01-01-2050 15:00:00');
        $this->assertEquals('01-01-2050 15:00:00', self::$object->getUpdated()->format('d-m-Y H:i:s'));

        $this->assertInstanceOf('\Datetime', self::$object->getUpdated());
    }

    public function test_if_it_have_a_end_date()
    {
        self::$object->shouldReceive('setUpdated')->twice();

        $this->assertFalse(self::$object->isEnded());

        $created = self::$object->getCreated();
        self::$object->setEnded($created);
        $this->assertNull(self::$object->getEnded());

        $old = $created->sub(new DateInterval('PT1H'));
        self::$object->setEnded($old);
        $this->assertNull(self::$object->getEnded());

        $updated = new Datetime('tomorrow');
        self::$object->setEnded($updated);
        $this->assertEquals($updated, self::$object->getEnded());

        self::$object->setEnded('01-01-2050 15:00:00');
        $this->assertEquals('01-01-2050 15:00:00', self::$object->getEnded()->format('d-m-Y H:i:s'));

        $this->assertInstanceOf('\Datetime', self::$object->getEnded());
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
