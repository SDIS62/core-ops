<?php

namespace SDIS62\Core\Ops\Entity\Service;

use Mockery;
use SDIS62\Core\Ops as Core;
use PHPUnit_Framework_TestCase;

class CentreServiceTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        // Init ..
        $this->repository_centre  = Mockery::mock('SDIS62\Core\Ops\Repository\CentreRepositoryInterface')->makePartial();
        $this->repository_commune = Mockery::mock('SDIS62\Core\Ops\Repository\CommuneRepositoryInterface')->makePartial();
        $this->service            = new Core\Service\CentreService($this->repository_centre, $this->repository_commune);
    }

    public function test_if_it_get_all()
    {
        // Prepare ..
        $this->repository_centre->shouldReceive('getAll')->with(20, 1)->andReturn(true)->once();

        // Test!
        $this->assertTrue($this->service->getAll());
    }

    public function test_if_it_find()
    {
        // Prepare ..
        $this->repository_centre->shouldReceive('find')->with(1)->andReturn(true)->once();

        // Test!
        $this->assertTrue($this->service->find(1));
    }

    public function test_if_it_find_all_by_name()
    {
        // Prepare ..
        $this->repository_centre->shouldReceive('findAllByName')->with('test', 20, 1)->andReturn(true)->once();

        // Test!
        $this->assertTrue($this->service->findAllByName('test'));
    }

    public function test_if_it_delete()
    {
        // Prepare ..
        $centre = Mockery::mock('SDIS62\Core\Ops\Entity\Centre');
        $this->repository_centre->shouldReceive('find')->with(1)->andReturn($centre)->once();
        $this->repository_centre->shouldReceive('find')->with(2)->andReturn(null)->once();
        $this->repository_centre->shouldReceive('delete')->with($centre)->once();

        // Test!
        $this->assertEquals($centre, $this->service->delete(1));
        $this->assertNull($this->service->delete(2));
    }

    public function test_if_it_create()
    {
        // Prepare ..
        $data            = ['name' => 'CIS Arras', 'commune' => '62001'];
        $commune         = new Core\Entity\Commune('Arras', '62001');
        $centre_expected = new Core\Entity\Centre($commune, 'CIS Arras');
        $this->repository_commune->shouldReceive('find')->with('62001')->andReturn($commune)->once();
        $this->repository_commune->shouldReceive('find')->with('62002')->andReturn(null)->once();
        $this->repository_centre->shouldReceive('save')->once();

        // Test!
        $this->assertEquals($centre_expected, $this->service->save($data));
        $this->assertNull($this->service->save(['name' => 'CIS Arras', 'commune' => '62002']));
    }

    public function test_if_it_update()
    {
        // Prepare ..
        $data            = ['name' => 'CIS Bethune'];
        $commune         = new Core\Entity\Commune('Arras', '62001');
        $centre_updated  = new Core\Entity\Centre($commune, 'CIS Arras');
        $centre_expected = new Core\Entity\Centre($commune, 'CIS Bethune');
        $this->repository_centre->shouldReceive('find')->with(1)->andReturn($centre_updated)->once();
        $this->repository_centre->shouldReceive('find')->with(2)->andReturn(null)->once();
        $this->repository_centre->shouldReceive('save')->once();

        // Test!
        $this->assertEquals($centre_expected, $this->service->save($data, 1));
        $this->assertNull($this->service->save($data, 2));
    }

    public function tearDown()
    {
        parent::tearDown();
        Mockery::close();
    }
}
