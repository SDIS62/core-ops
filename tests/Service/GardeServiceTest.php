<?php

namespace SDIS62\Core\Ops\Entity\Service;

use Mockery;
use Datetime;
use SDIS62\Core\Ops as Core;
use PHPUnit_Framework_TestCase;

class GardeServiceTest extends PHPUnit_Framework_TestCase
{
    public function test_if_it_find_all_by_month()
    {
        // Init ..
        $repository_garde = Mockery::mock('SDIS62\Core\Ops\Repository\GardeRepositoryInterface')->makePartial();
        $repository_pompier = Mockery::mock('SDIS62\Core\Ops\Repository\PompierRepositoryInterface')->makePartial();
        $service = new Core\Service\GardeService($repository_garde, $repository_pompier);

        // Prepare ..
        $repository_garde->shouldReceive('findAllByMonth')->with(12)->andReturn(true)->once();

        // Test!
        $this->assertTrue($service->findAllByMonth(12));
    }

    public function test_if_it_find()
    {
        // Init ..
        $repository_garde = Mockery::mock('SDIS62\Core\Ops\Repository\GardeRepositoryInterface')->makePartial();
        $repository_pompier = Mockery::mock('SDIS62\Core\Ops\Repository\PompierRepositoryInterface')->makePartial();
        $service = new Core\Service\GardeService($repository_garde, $repository_pompier);

        // Prepare ..
        $repository_garde->shouldReceive('find')->with(1)->andReturn(true)->once();

        // Test!
        $this->assertTrue($service->find(1));
    }

    public function test_if_it_delete()
    {
        // Init ..
        $repository_garde = Mockery::mock('SDIS62\Core\Ops\Repository\GardeRepositoryInterface')->makePartial();
        $repository_pompier = Mockery::mock('SDIS62\Core\Ops\Repository\PompierRepositoryInterface')->makePartial();
        $service = new Core\Service\GardeService($repository_garde, $repository_pompier);

        // Prepare ..
        $garde = Mockery::mock('SDIS62\Core\Ops\Entity\Garde');
        $repository_garde->shouldReceive('find')->with(1)->andReturn($garde)->once();
        $repository_garde->shouldReceive('find')->with(2)->andReturn(null)->once();
        $repository_garde->shouldReceive('delete')->with($garde)->once();

        // Test!
        $this->assertEquals($garde, $service->delete(1));
        $this->assertNull($service->delete(2));
    }

    public function test_if_it_create()
    {
        // Init ..
        $repository_garde = Mockery::mock('SDIS62\Core\Ops\Repository\GardeRepositoryInterface')->makePartial();
        $repository_pompier = Mockery::mock('SDIS62\Core\Ops\Repository\PompierRepositoryInterface')->makePartial();
        $service = new Core\Service\GardeService($repository_garde, $repository_pompier);

        // Prepare ..
        $data = array('debut' => new Datetime('2015-11-01 15:00'), 'fin' => new Datetime('2015-12-01 15:00'));
        $pompier = new Core\Entity\Pompier('Kevin', '00001', new Core\Entity\Centre('CIS Arras'));
        $garde_expected = new Core\Entity\Garde($pompier, '01-11-2015 15:00', '01-12-2015 15:00');
        $repository_garde->shouldReceive('save')->once();
        $repository_pompier->shouldReceive('find')->with(1)->andReturn($pompier)->once();
        $repository_pompier->shouldReceive('find')->with(2)->andReturn(null)->once();

        // Test!
        $this->assertEquals($garde_expected, $service->create($data, 1));
        $this->assertNull($service->create($data, 2));
    }

    public function tearDown()
    {
        parent::tearDown();
        Mockery::close();
    }
}