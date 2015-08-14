<?php

namespace SDIS62\Core\Ops\Test\Entity;

use Mockery;
use Datetime;
use SDIS62\Core\Ops as Core;
use PHPUnit_Framework_TestCase;

class DispoPlageHoraireTest extends PHPUnit_Framework_TestCase
{
    protected static $object;

    public function setUp()
    {
        $planning = new Core\Entity\Planning('Planning OPS');
        $pompier  = new Core\Entity\Pompier('DUBUC Kevin', 'mat001', Mockery::mock('SDIS62\Core\Ops\Entity\Centre')->makePartial());
        $start    = new Datetime('yesterday');
        $end      = new Datetime();

        self::$object = new Core\Entity\PlageHoraire\DispoPlageHoraire($planning, $pompier, $start, $end);
    }

    public function test_if_it_is_initializable()
    {
        $this->assertInstanceOf('SDIS62\Core\Ops\Entity\PlageHoraire', self::$object);
    }

    public function test_if_it_have_a_type_dispo()
    {
        $this->assertEquals('dispo', self::$object->getType());
    }
}
