<?php

namespace SDIS62\Core\Ops\Entity\Service;

use Datetime;
use Mockery;
use PHPUnit_Framework_TestCase;
use SDIS62\Core\Ops as Core;

class PlanningServiceTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        // Init ..
        $this->repository_planning = Mockery::mock('SDIS62\Core\Ops\Repository\PlanningRepositoryInterface')->makePartial();
        $this->service             = new Core\Service\PlanningService($this->repository_planning);
    }

    public function test_if_it_find()
    {
        // Prepare ..
        $this->repository_planning->shouldReceive('find')->with(1)->andReturn(true)->once();

        // Test!
        $this->assertTrue($this->service->find(1));
    }

    public function test_if_it_find_by_period()
    {
        // Prepare ..
        $date = new Datetime();
        $this->repository_planning->shouldReceive('findByPeriod')->with(1, $date, $date)->andReturn(true)->once();

        // Test!
        $this->assertTrue($this->service->findByPeriod(1, $date, $date));
    }

    public function test_if_it_delete()
    {
        // Prepare ..
        $planning = Mockery::mock('SDIS62\Core\Ops\Entity\Planning');
        $this->repository_planning->shouldReceive('find')->with(1)->andReturn($planning)->once();
        $this->repository_planning->shouldReceive('find')->with(2)->andReturn(null)->once();
        $this->repository_planning->shouldReceive('delete')->with($planning)->once();

        // Test!
        $this->assertEquals($planning, $this->service->delete(1));
        $this->assertNull($this->service->delete(2));
    }

    public function test_if_it_create()
    {
        // Prepare ..
        $data              = ['name' => 'Planning OPS'];
        $planning_expected = new Core\Entity\Planning('Planning OPS');
        $this->repository_planning->shouldReceive('save')->once();

        // Test!
        $this->assertEquals($planning_expected, $this->service->save($data));
    }

    public function test_if_it_update()
    {
        // Prepare ..
        $data              = ['name' => 'Planning Astreinte'];
        $planning_updated  = new Core\Entity\Planning('Planning OPS');
        $planning_expected = new Core\Entity\Planning('Planning Astreinte');
        $this->repository_planning->shouldReceive('find')->with(1)->andReturn($planning_updated)->once();
        $this->repository_planning->shouldReceive('save')->once();

        // Test!
        $this->assertEquals($planning_expected, $this->service->save($data, 1));
    }

    public function tearDown()
    {
        parent::tearDown();
        Mockery::close();
    }
}
