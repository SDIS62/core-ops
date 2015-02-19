<?php

namespace SDIS62\Core\Ops\Test\Entity;

use Datetime;
use DateInterval;
use SDIS62\Core\Ops as Core;
use PHPUnit_Framework_TestCase;

class GardeTest extends PHPUnit_Framework_TestCase
{
    protected static $object;

    public function setUp()
    {
        $commune = new Core\Entity\Commune('Arras', '62001');
        $centre = new Core\Entity\Centre($commune, "CIS");
        $pompier = new Core\Entity\Pompier("Kevin", "0001", $centre);
        self::$object = new Core\Entity\Garde($pompier, '15-02-2015 15:00', '15-02-2015 18:00');
    }

    public function test_if_it_have_an_id()
    {
        self::$object->setId(10);
        $this->assertEquals(10, self::$object->getId());
    }

    public function test_if_it_is_initializable()
    {
        $this->assertInstanceOf('SDIS62\Core\Ops\Entity\Garde', self::$object);
    }

    public function test_if_it_have_a_pompier()
    {
        $this->assertInstanceOf('SDIS62\Core\Ops\Entity\Pompier', self::$object->getPompier());
    }

    public function test_if_it_have_dates()
    {
        $commune = new Core\Entity\Commune('Arras', '62001');
        $centre = new Core\Entity\Centre($commune, "CIS");
        $pompier = new Core\Entity\Pompier("Kevin", "0001", $centre);

        $garde = new Core\Entity\Garde($pompier, '14-02-2015 15:00', '14-02-2015 18:00');
        $this->assertEquals(new DateInterval('PT3H'), date_diff($garde->getStart(), $garde->getEnd()));

        $start = new Datetime('14-02-2015 15:00');
        $end = new Datetime('NOW');
        $garde = new Core\Entity\Garde($pompier, $start, $end);
        $this->assertEquals(date_diff($start, $end), date_diff($garde->getStart(), $garde->getEnd()));
    }
}
