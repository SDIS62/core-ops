<?php

namespace SDIS62\Core\Ops\Test\Entity;

use Exception;
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
        $centre  = new Core\Entity\Centre($commune, 'CIS');
        $pompier = new Core\Entity\Pompier('Kevin', '0001', $centre);

        new Core\Entity\Dispo($pompier, '15-02-2015 16:00', '15-02-2015 17:00');

        self::$object = new Core\Entity\Garde($pompier, '15-02-2015 15:00', '15-02-2015 18:00');
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

        $garde = new Core\Entity\Garde($pompier, '14-02-2015 15:00', '14-02-2015 18:00');
        $this->assertEquals(new DateInterval('PT3H'), date_diff($garde->getStart(), $garde->getEnd()));
    }

    public function test_if_it_remove_dispos()
    {
        $this->assertCount(0, self::$object->getPompier()->getDispos());
    }

    public function test_if_it_transform_two_dispos()
    {
        $pompier = self::$object->getPompier();

        new Core\Entity\Dispo($pompier, '10-02-2015 15:00', '10-02-2015 18:00');
        new Core\Entity\Garde($pompier, '10-02-2015 16:00', '10-02-2015 17:00');

        $this->assertCount(2, $pompier->getDispos());

        return;

        $this->assertEquals(Datetime::createFromFormat('d-m-Y H:i', '15-02-2015 14:00'), self::$object->getPompier()->getDispos()[2]->getStart());
        $this->assertEquals(Datetime::createFromFormat('d-m-Y H:i', '15-02-2015 15:00'), self::$object->getPompier()->getDispos()[2]->getEnd());
    }

    public function test_if_it_throw_an_exception_if_dates_are_invalids()
    {
        try {
            $dispo = new Core\Entity\Garde(self::$object->getPompier(), '15-02-2015 16:00', '15-02-2015 14:00');
        } catch (Exception $e) {
            return;
        }
        $this->fail('Exception must be throw');
    }

    public function test_if_it_throw_an_exception_if_garde_is_in_another_garde()
    {
        try {
            $dispo = new Core\Entity\Garde(self::$object->getPompier(), '15-02-2015 14:00', '15-02-2015 16:00');
        } catch (Exception $e) {
            return;
        }
        $this->fail('Exception must be throw');
    }
}
