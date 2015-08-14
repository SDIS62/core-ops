<?php

namespace SDIS62\Core\Ops\Entity\Service;

use Mockery;
use Datetime;
use SDIS62\Core\Ops as Core;
use PHPUnit_Framework_TestCase;

class PlageHoraireServiceTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        // Init ..
        $this->repository_planning     = Mockery::mock('SDIS62\Core\Ops\Repository\PlanningRepositoryInterface')->makePartial();
        $this->repository_plagehoraire = Mockery::mock('SDIS62\Core\Ops\Repository\PlageHoraireRepositoryInterface')->makePartial();
        $this->repository_pompier      = Mockery::mock('SDIS62\Core\Ops\Repository\PompierRepositoryInterface')->makePartial();
        $this->service                 = new Core\Service\PlageHoraireService($this->repository_plagehoraire, $this->repository_pompier, $this->repository_planning);
    }

    public function test_if_it_find()
    {
        // Prepare ..
        $this->repository_plagehoraire->shouldReceive('find')->with(1)->andReturn(true)->once();

        // Test!
        $this->assertTrue($this->service->find(1));
    }

    public function test_if_it_delete()
    {
        // Prepare ..
        $plagehoraire = Mockery::mock('SDIS62\Core\Ops\Entity\PlageHoraire');
        $this->repository_plagehoraire->shouldReceive('find')->with(1)->andReturn($plagehoraire)->once();
        $this->repository_plagehoraire->shouldReceive('find')->with(2)->andReturn(null)->once();
        $this->repository_plagehoraire->shouldReceive('delete')->with($plagehoraire)->once();

        // Test!
        $this->assertEquals($plagehoraire, $this->service->delete(1));
        $this->assertNull($this->service->delete(2));
    }

    public function test_if_it_create_garde()
    {
        // Prepare ..
        $data     = ['type' => 'garde', 'planning' => 1, 'pompier' => 2, 'start' => '14-08-1988 15:00', 'end' => '14-08-1988 16:00'];
        $planning = new Core\Entity\Planning('Planning');
        $pompier  = new Core\Entity\Pompier('DUBUC Kevin', 'mat001', Mockery::mock('SDIS62\Core\Ops\Entity\Centre')->makePartial());
        $start    = Datetime::createFromFormat('d-m-Y H:i', '14-08-1988 15:00');
        $end      = Datetime::createFromFormat('d-m-Y H:i', '14-08-1988 16:00');
        $this->repository_planning->shouldReceive('find')->with(1)->andReturn($planning)->once();
        $this->repository_pompier->shouldReceive('find')->with(2)->andReturn($pompier)->once();
        $this->repository_plagehoraire->shouldReceive('save')->once();
        $garde = $this->service->save($data);

        // Test!
        $this->assertEquals($pompier, $garde->getPompier());
        $this->assertEquals($planning, $garde->getPlanning());
        $this->assertEquals($start, $garde->getStart());
        $this->assertEquals($end, $garde->getEnd());
    }

    public function test_if_it_create_dispo()
    {
        // Prepare ..
        $data     = ['type' => 'dispo', 'planning' => 1, 'pompier' => 2, 'start' => '14-08-1988 15:00', 'end' => '14-08-1988 16:00'];
        $planning = new Core\Entity\Planning('Planning');
        $pompier  = new Core\Entity\Pompier('DUBUC Kevin', 'mat001', Mockery::mock('SDIS62\Core\Ops\Entity\Centre')->makePartial());
        $start    = Datetime::createFromFormat('d-m-Y H:i', '14-08-1988 15:00');
        $end      = Datetime::createFromFormat('d-m-Y H:i', '14-08-1988 16:00');
        $this->repository_planning->shouldReceive('find')->with(1)->andReturn($planning)->once();
        $this->repository_pompier->shouldReceive('find')->with(2)->andReturn($pompier)->once();
        $this->repository_plagehoraire->shouldReceive('save')->once();
        $dispo = $this->service->save($data);

        // Test!
        $this->assertEquals($pompier, $dispo->getPompier());
        $this->assertEquals($planning, $dispo->getPlanning());
        $this->assertEquals($start, $dispo->getStart());
        $this->assertEquals($end, $dispo->getEnd());
    }

    public function test_if_it_create_invalid_plage_horaire()
    {
        // Prepare ..
        $data = ['type' => 'alo', 'planning' => 1, 'pompier' => 2, 'start' => '14-08-1988 15:00', 'end' => '14-08-1988 16:00'];
        $this->repository_planning->shouldReceive('find')->with(1)->andReturn(null)->once();
        $this->repository_pompier->shouldReceive('find')->with(2)->andReturn(null)->once();

        // Test !
        try {
            $this->service->save($data);
        } catch (Core\Exception\InvalidPlageHoraireTypeException $e) {
            return;
        }
        $this->fail('Exception must be throw');
    }

    public function tearDown()
    {
        parent::tearDown();
        Mockery::close();
    }
}
