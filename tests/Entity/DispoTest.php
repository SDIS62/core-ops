<?php

namespace SDIS62\Core\Ops\Test\Entity;

use DateInterval;
use Exception;
use SDIS62\Core\Ops as Core;
use PHPUnit_Framework_TestCase;

class DispoTest extends PHPUnit_Framework_TestCase
{
    protected static $object;

    public function setUp()
    {
        $commune = new Core\Entity\Commune('Arras', '62001');
        $centre  = new Core\Entity\Centre($commune, 'CIS');
        $pompier = new Core\Entity\Pompier('Kevin', '0001', $centre);

        new Core\Entity\Dispo($pompier, '16-02-2015 15:00', '16-02-2015 18:00');
        new Core\Entity\Garde($pompier, '20-02-2015 15:00', '20-02-2015 18:00');

        self::$object = new Core\Entity\Dispo($pompier, '15-02-2015 15:00', '15-02-2015 18:00');
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

    public function test_if_it_have_dates()
    {
        $commune = new Core\Entity\Commune('Arras', '62001');
        $centre  = new Core\Entity\Centre($commune, 'CIS');
        $pompier = new Core\Entity\Pompier('Kevin', '0001', $centre);

        $dispo = new Core\Entity\Dispo($pompier, '14-02-2015 15:00', '14-02-2015 18:00');
        $this->assertEquals(new DateInterval('PT3H'), date_diff($dispo->getStart(), $dispo->getEnd()));
    }

    public function test_if_it_throw_an_exception_if_dispo_is_in_another_dispo()
    {
        try {
            $dispo = new Core\Entity\Dispo(self::$object->getPompier(), '16-02-2015 14:00', '16-02-2015 16:00');
        } catch (Exception $e) {
            return;
        }
        $this->fail('Exception must be throw');
    }

    public function test_if_it_throw_an_exception_if_dispo_is_in_garde()
    {
        try {
            $dispo = new Core\Entity\Dispo(self::$object->getPompier(), '20-02-2015 17:45', '20-02-2015 19:00');
        } catch (Exception $e) {
            return;
        }
        $this->fail('Exception must be throw');
    }
}
