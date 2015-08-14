<?php

namespace SDIS62\Core\Ops\Test\Entity;

use Mockery;
use Datetime;
use SDIS62\Core\Ops as Core;
use PHPUnit_Framework_TestCase;

class PlanningTest extends PHPUnit_Framework_TestCase
{
    protected static $object;

    public function setUp()
    {
        self::$object = new Core\Entity\Planning('Feu de');
    }

    public function test_if_it_have_an_id()
    {
        self::$object->setId(10);
        $this->assertEquals(10, self::$object->getId());
    }

    public function test_if_it_is_initializable()
    {
        $this->assertInstanceOf('SDIS62\Core\Ops\Entity\Planning', self::$object);
    }

    public function test_if_it_have_a_name()
    {
        $this->assertEquals('Feu de', self::$object->getName());

        self::$object->setName('TA');

        $this->assertEquals('TA', self::$object->getName());
        $this->assertInternalType('string', self::$object->getName());
    }

    public function test_if_it_have_plage_horaire()
    {
        $garde = new Core\Entity\PlageHoraire\GardePlageHoraire(self::$object,
            new Core\Entity\Pompier('DUBUC Kevin', 'mat001', Mockery::mock('SDIS62\Core\Ops\Entity\Centre')->makePartial()),
            Datetime::createFromFormat('Y-m-d H:i:s', '2015-08-14 00:00:00'),
            Datetime::createFromFormat('Y-m-d H:i:s', '2015-08-17 00:00:00')
        );

        $dispo = new Core\Entity\PlageHoraire\DispoPlageHoraire(self::$object,
            new Core\Entity\Pompier('DUBUC Kevin', 'mat001', Mockery::mock('SDIS62\Core\Ops\Entity\Centre')->makePartial()),
            Datetime::createFromFormat('Y-m-d H:i:s', '2015-08-14 00:00:00'),
            Datetime::createFromFormat('Y-m-d H:i:s', '2015-08-17 00:00:00')
        );

        $this->assertCount(2, self::$object->getPlagesHoraires());
        $this->assertCount(1, self::$object->getGardes());
        $this->assertCount(1, self::$object->getDispos());
    }

    public function test_if_it_throw_an_exception_if_dispo_is_in_another_dispo()
    {
        $pompier         = new Core\Entity\Pompier('DUBUC Kevin', 'mat001', Mockery::mock('SDIS62\Core\Ops\Entity\Centre')->makePartial());
        $another_pompier = new Core\Entity\Pompier('BILLET Kelly', 'mat002', Mockery::mock('SDIS62\Core\Ops\Entity\Centre')->makePartial());

        $dispo = new Core\Entity\PlageHoraire\DispoPlageHoraire(
            self::$object,
            $pompier,
            Datetime::createFromFormat('Y-m-d H:i:s', '2015-08-14 00:00:00'),
            Datetime::createFromFormat('Y-m-d H:i:s', '2015-08-17 00:00:00')
        );

        $dispo = new Core\Entity\PlageHoraire\DispoPlageHoraire(
            self::$object,
            $another_pompier,
            Datetime::createFromFormat('Y-m-d H:i:s', '2015-08-14 00:00:00'),
            Datetime::createFromFormat('Y-m-d H:i:s', '2015-08-17 00:00:00')
        );

        try {
            $dispo = new Core\Entity\PlageHoraire\DispoPlageHoraire(
                self::$object,
                $pompier,
                Datetime::createFromFormat('Y-m-d H:i:s', '2015-08-14 00:00:00'),
                Datetime::createFromFormat('Y-m-d H:i:s', '2015-08-17 00:00:00')
            );
        } catch (Core\Exception\InvalidDateException $e) {
            return;
        }

        $this->fail('Exception must be throw');
    }

    public function test_if_it_throw_an_exception_if_dispo_is_in_garde()
    {
        $pompier         = new Core\Entity\Pompier('DUBUC Kevin', 'mat001', Mockery::mock('SDIS62\Core\Ops\Entity\Centre')->makePartial());
        $another_pompier = new Core\Entity\Pompier('BILLET Kelly', 'mat002', Mockery::mock('SDIS62\Core\Ops\Entity\Centre')->makePartial());

        $garde = new Core\Entity\PlageHoraire\GardePlageHoraire(
            self::$object,
            $pompier,
            Datetime::createFromFormat('Y-m-d H:i:s', '2015-08-14 00:00:00'),
            Datetime::createFromFormat('Y-m-d H:i:s', '2015-08-17 00:00:00')
        );

        $garde = new Core\Entity\PlageHoraire\GardePlageHoraire(
            self::$object,
            $another_pompier,
            Datetime::createFromFormat('Y-m-d H:i:s', '2015-08-14 00:00:00'),
            Datetime::createFromFormat('Y-m-d H:i:s', '2015-08-17 00:00:00')
        );

        try {
            $dispo = new Core\Entity\PlageHoraire\DispoPlageHoraire(
                self::$object,
                $pompier,
                Datetime::createFromFormat('Y-m-d H:i:s', '2015-08-14 00:00:00'),
                Datetime::createFromFormat('Y-m-d H:i:s', '2015-08-17 00:00:00')
            );
        } catch (Core\Exception\InvalidDateException $e) {
            return;
        }

        $this->fail('Exception must be throw');
    }

    public function test_if_it_remove_dispos_when_garde_is_equals_dispo()
    {
        $pompier = new Core\Entity\Pompier('DUBUC Kevin', 'mat001', Mockery::mock('SDIS62\Core\Ops\Entity\Centre')->makePartial());

        $dispo = new Core\Entity\PlageHoraire\DispoPlageHoraire(
            self::$object,
            $pompier,
            Datetime::createFromFormat('Y-m-d H:i:s', '2015-08-14 00:00:00'),
            Datetime::createFromFormat('Y-m-d H:i:s', '2015-08-17 00:00:00')
        );

        $garde = new Core\Entity\PlageHoraire\GardePlageHoraire(
            self::$object,
            $pompier,
            Datetime::createFromFormat('Y-m-d H:i:s', '2015-08-14 00:00:00'),
            Datetime::createFromFormat('Y-m-d H:i:s', '2015-08-17 00:00:00')
        );

        $this->assertCount(0, $pompier->getDispos());
        $this->assertCount(1, $pompier->getGardes());
    }

    public function test_if_it_transform_two_dispos_with_garde_between()
    {
        $pompier = new Core\Entity\Pompier('DUBUC Kevin', 'mat001', Mockery::mock('SDIS62\Core\Ops\Entity\Centre')->makePartial());

        $dispo = new Core\Entity\PlageHoraire\DispoPlageHoraire(
            self::$object,
            $pompier,
            Datetime::createFromFormat('d-m-Y H:i:s', '10-02-2015 15:00:00'),
            Datetime::createFromFormat('d-m-Y H:i:s', '10-02-2015 18:00:00')
        );

        $garde = new Core\Entity\PlageHoraire\GardePlageHoraire(
            self::$object,
            $pompier,
            Datetime::createFromFormat('d-m-Y H:i:s', '10-02-2015 16:00:00'),
            Datetime::createFromFormat('d-m-Y H:i:s', '10-02-2015 17:00:00')
        );

        $this->assertCount(2, $pompier->getDispos());

        return;

        $this->assertEquals(Datetime::createFromFormat('d-m-Y H:i', '15-02-2015 14:00'), self::$object->getPompier()->getDispos()[2]->getStart());
        $this->assertEquals(Datetime::createFromFormat('d-m-Y H:i', '15-02-2015 15:00'), self::$object->getPompier()->getDispos()[2]->getEnd());
    }

    public function test_if_it_throw_an_exception_if_garde_is_in_another_garde()
    {
        $pompier         = new Core\Entity\Pompier('DUBUC Kevin', 'mat001', Mockery::mock('SDIS62\Core\Ops\Entity\Centre')->makePartial());
        $another_pompier = new Core\Entity\Pompier('BILLET Kelly', 'mat002', Mockery::mock('SDIS62\Core\Ops\Entity\Centre')->makePartial());

        $garde = new Core\Entity\PlageHoraire\GardePlageHoraire(
            self::$object,
            $pompier,
            Datetime::createFromFormat('Y-m-d H:i:s', '2015-08-14 00:00:00'),
            Datetime::createFromFormat('Y-m-d H:i:s', '2015-08-17 00:00:00')
        );

        $garde = new Core\Entity\PlageHoraire\GardePlageHoraire(
            self::$object,
            $another_pompier,
            Datetime::createFromFormat('Y-m-d H:i:s', '2015-08-14 00:00:00'),
            Datetime::createFromFormat('Y-m-d H:i:s', '2015-08-17 00:00:00')
        );

        try {
            $garde = new Core\Entity\PlageHoraire\GardePlageHoraire(
                self::$object,
                $pompier,
                Datetime::createFromFormat('Y-m-d H:i:s', '2015-08-14 00:00:00'),
                Datetime::createFromFormat('Y-m-d H:i:s', '2015-08-17 00:00:00')
            );
        } catch (Core\Exception\InvalidDateException $e) {
            return;
        }

        $this->fail('Exception must be throw');
    }
}
