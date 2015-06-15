<?php

namespace SDIS62\Core\Ops\Entity\Service;

use Mockery;
use Datetime;
use SDIS62\Core\Ops as Core;
use PHPUnit_Framework_TestCase;

class DispoServiceTest extends PHPUnit_Framework_TestCase
{
    public function test_if_it_find()
    {
        // Init ..
        $repository_dispo   = Mockery::mock('SDIS62\Core\Ops\Repository\DispoRepositoryInterface')->makePartial();
        $repository_pompier = Mockery::mock('SDIS62\Core\Ops\Repository\PompierRepositoryInterface')->makePartial();
        $service            = new Core\Service\DispoService($repository_dispo, $repository_pompier);

        // Prepare ..
        $repository_dispo->shouldReceive('find')->with(1)->andReturn(true)->once();

        // Test!
        $this->assertTrue($service->find(1));
    }

    public function test_if_it_find_all_by_period()
    {
        // Init ..
        $repository_dispo   = Mockery::mock('SDIS62\Core\Ops\Repository\DispoRepositoryInterface')->makePartial();
        $repository_pompier = Mockery::mock('SDIS62\Core\Ops\Repository\PompierRepositoryInterface')->makePartial();
        $service            = new Core\Service\DispoService($repository_dispo, $repository_pompier);

        // Prepare ..
        $date = new Datetime();
        $repository_dispo->shouldReceive('findByPeriod')->with($date, $date)->andReturn(true)->once();

        // Test!
        $this->assertTrue($service->findByPeriod($date, $date));
    }

    public function test_if_it_delete()
    {
        // Init ..
        $repository_dispo   = Mockery::mock('SDIS62\Core\Ops\Repository\DispoRepositoryInterface')->makePartial();
        $repository_pompier = Mockery::mock('SDIS62\Core\Ops\Repository\PompierRepositoryInterface')->makePartial();
        $service            = new Core\Service\DispoService($repository_dispo, $repository_pompier);

        // Prepare ..
        $dispo = Mockery::mock('SDIS62\Core\Ops\Entity\Dispo');
        $repository_dispo->shouldReceive('find')->with(1)->andReturn($dispo)->once();
        $repository_dispo->shouldReceive('find')->with(2)->andReturn(null)->once();
        $repository_dispo->shouldReceive('delete')->with($dispo)->once();

        // Test!
        $this->assertEquals($dispo, $service->delete(1));
        $this->assertNull($service->delete(2));
    }

    public function test_if_it_create()
    {
        // Init ..
        $repository_dispo   = Mockery::mock('SDIS62\Core\Ops\Repository\DispoRepositoryInterface')->makePartial();
        $repository_pompier = Mockery::mock('SDIS62\Core\Ops\Repository\PompierRepositoryInterface')->makePartial();
        $service            = new Core\Service\DispoService($repository_dispo, $repository_pompier);

        // Prepare ..
        $data           = ['start' => new Datetime('2015-11-01 15:00'), 'end' => new Datetime('2015-12-01 15:00')];
        $pompier        = new Core\Entity\Pompier('Kevin', '00001', new Core\Entity\Centre(new Core\Entity\Commune('Arras', '62001'), 'CIS Arras'));

        $repository_dispo->shouldReceive('save')->once();
        $repository_pompier->shouldReceive('find')->with(1)->andReturn($pompier)->once();
        $repository_pompier->shouldReceive('find')->with(2)->andReturn(null)->once();

        // Test!
        $dispo = $service->create($data, 1);
        $this->assertEquals($pompier, $dispo->getPompier());
        $this->assertEquals(new Datetime('2015-11-01 15:00'), $dispo->getStart());
        $this->assertEquals(new Datetime('2015-12-01 15:00'), $dispo->getEnd());
        $this->assertNull($service->create($data, 2));
    }

    public function tearDown()
    {
        parent::tearDown();
        Mockery::close();
    }
}
