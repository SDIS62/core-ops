<?php

namespace SDIS62\Core\Ops\Test\Entity;

use Datetime;
use Exception;
use Mockery;
use SDIS62\Core\Ops as Core;
use PHPUnit_Framework_TestCase;

class PlageHoraireTest extends PHPUnit_Framework_TestCase
{
    protected static $object;

    public function setUp()
    {
        $planning = new Core\Entity\Planning('Planning OPS');
        $pompier  = new Core\Entity\Pompier('DUBUC Kevin', 'mat001', Mockery::mock('SDIS62\Core\Ops\Entity\Centre')->makePartial());
        $start    = Datetime::createFromFormat('Y-m-d H:i:s', '2015-08-14 00:00:00');
        $end      = Datetime::createFromFormat('Y-m-d H:i:s', '2015-08-16 00:00:00');

        self::$object = Mockery::mock('SDIS62\Core\Ops\Entity\PlageHoraire', [$planning, $pompier, $start, $end])->makePartial();
    }

    public function test_if_it_have_an_id()
    {
        self::$object->setId(10);
        $this->assertEquals(10, self::$object->getId());
    }

    public function test_if_it_is_initializable()
    {
        $this->assertInstanceOf('SDIS62\Core\Ops\Entity\PlageHoraire', self::$object);
    }

    public function test_if_it_have_a_pompier()
    {
        $this->assertInstanceOf('SDIS62\Core\Ops\Entity\Pompier', self::$object->getPompier());
    }

    public function test_if_it_have_start_date()
    {
        $this->assertEquals(Datetime::createFromFormat('Y-m-d H:i:s', '2015-08-14 00:00:00'), self::$object->getStart());
        $this->assertInstanceOf('\Datetime', self::$object->getStart());
    }

    public function test_if_it_have_end_date()
    {
        $this->assertEquals(Datetime::createFromFormat('Y-m-d H:i:s', '2015-08-16 00:00:00'), self::$object->getEnd());
        $this->assertInstanceOf('\Datetime', self::$object->getEnd());
    }

    public function test_includes()
    {
        $plage = Mockery::mock('SDIS62\Core\Ops\Entity\PlageHoraire', [
            new Core\Entity\Planning('Planning OPS'),
            new Core\Entity\Pompier('DUBUC Kevin', 'mat001', Mockery::mock('SDIS62\Core\Ops\Entity\Centre')->makePartial()),
            Datetime::createFromFormat('Y-m-d H:i:s', '2015-08-14 00:00:00'),
            Datetime::createFromFormat('Y-m-d H:i:s', '2015-08-17 00:00:00'),
        ])->makePartial();

        $this->assertTrue(self::$object->includes($plage, false));

        $plage = Mockery::mock('SDIS62\Core\Ops\Entity\PlageHoraire', [
            new Core\Entity\Planning('Planning OPS'),
            new Core\Entity\Pompier('DUBUC Kevin', 'mat001', Mockery::mock('SDIS62\Core\Ops\Entity\Centre')->makePartial()),
            Datetime::createFromFormat('Y-m-d H:i:s', '2015-08-12 00:00:00'),
            Datetime::createFromFormat('Y-m-d H:i:s', '2015-08-13 23:59:59'),
        ])->makePartial();

        $this->assertFalse(self::$object->includes($plage, false));
    }

    public function test_contains()
    {
        $this->assertFalse(self::$object->contains(Datetime::createFromFormat('Y-m-d H:i:s', '2015-08-13 00:00:00')));
        $this->assertTrue(self::$object->contains(Datetime::createFromFormat('Y-m-d H:i:s', '2015-08-15 00:00:00')));
    }

    public function test_if_it_throw_an_exception_if_plage_horaire_is_not_valid()
    {
        try {
            self::$object->getType();
        } catch (Core\Exception\InvalidPlageHoraireTypeException $e) {
            return;
        }
        $this->fail('Exception must be throw');
    }

    public function test_if_it_throw_an_exception_if_dates_are_invalids()
    {
        $planning = new Core\Entity\Planning('Planning OPS');
        $pompier  = new Core\Entity\Pompier('DUBUC Kevin', 'mat001', Mockery::mock('SDIS62\Core\Ops\Entity\Centre')->makePartial());
        $end      = new Datetime('yesterday');
        $start    = new Datetime();

        try {
            self::$object = Mockery::mock('SDIS62\Core\Ops\Entity\PlageHoraire', [$planning, $pompier, $start, $end])->makePartial();
        } catch (Exception $e) {
            return;
        }
        $this->fail('Exception must be throw');
    }
}
