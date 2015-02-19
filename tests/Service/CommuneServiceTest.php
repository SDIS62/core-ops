<?php

namespace SDIS62\Core\Ops\Entity\Service;

use Mockery;
use SDIS62\Core\Ops as Core;
use PHPUnit_Framework_TestCase;

class CommuneServiceTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        // Init ..
        $this->repository_commune = Mockery::mock('SDIS62\Core\Ops\Repository\CommuneRepositoryInterface')->makePartial();
        $this->service = new Core\Service\CommuneService($this->repository_commune);
    }

    public function test_if_it_get_all()
    {
        // Prepare ..
        $this->repository_commune->shouldReceive('getAll')->with(20, 1)->andReturn(true)->once();

        // Test!
        $this->assertTrue($this->service->getAll());
    }

    public function test_if_it_find()
    {
        // Prepare ..
        $this->repository_commune->shouldReceive('find')->with('62001')->andReturn(true)->once();

        // Test!
        $this->assertTrue($this->service->find('62001'));
    }

    public function test_if_it_delete()
    {
        // Prepare ..
        $commune = Mockery::mock('SDIS62\Core\Ops\Entity\Commune');
        $this->repository_commune->shouldReceive('find')->with('62001')->andReturn($commune)->once();
        $this->repository_commune->shouldReceive('find')->with('62002')->andReturn(null)->once();
        $this->repository_commune->shouldReceive('delete')->with($commune)->once();

        // Test!
        $this->assertEquals($commune, $this->service->delete('62001'));
        $this->assertNull($this->service->delete('62002'));
    }

    public function test_if_it_create()
    {
        // Prepare ..
        $data = array('name' => 'Arras', 'numinsee' => '62001');
        $commune_expected = new Core\Entity\Commune('Arras', '62001');
        $this->repository_commune->shouldReceive('find')->with('62001')->andReturn(null)->once();
        $this->repository_commune->shouldReceive('save')->once();

        // Test!
        $this->assertEquals($commune_expected, $this->service->save($data));
    }

    public function test_if_it_update()
    {
        // Prepare ..
        $data = array('name' => 'Arras', 'numinsee' => '62001');
        $commune_updated = new Core\Entity\Commune('Bethune', '62002');
        $commune_expected = new Core\Entity\Commune('Arras', '62002');
        $this->repository_commune->shouldReceive('find')->with('62001')->andReturn($commune_updated)->once();
        $this->repository_commune->shouldReceive('save')->once();

        // Test!
        $this->assertEquals($commune_expected, $this->service->save($data));
    }

    public function tearDown()
    {
        parent::tearDown();
        Mockery::close();
    }
}
