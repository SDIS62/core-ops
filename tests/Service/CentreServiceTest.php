<?php

namespace SDIS62\Core\Ops\Entity\Service;

use Mockery;
use SDIS62\Core\Ops as Core;
use PHPUnit_Framework_TestCase;

class CentreServiceTest extends PHPUnit_Framework_TestCase
{
    public function test_if_it_get_all()
    {
        // Init ..
        $repository_centre = Mockery::mock('SDIS62\Core\Ops\Repository\CentreRepositoryInterface')->makePartial();
        $service = new Core\Service\CentreService($repository_centre);

        // Prepare ..
        $repository_centre->shouldReceive('getAll')->andReturn(true)->once();

        // Test!
        $this->assertTrue($service->getAll());
    }

    public function test_if_it_find()
    {
        // Init ..
        $repository_centre = Mockery::mock('SDIS62\Core\Ops\Repository\CentreRepositoryInterface')->makePartial();
        $service = new Core\Service\CentreService($repository_centre);

        // Prepare ..
        $repository_centre->shouldReceive('find')->with(1)->andReturn(true)->once();

        // Test!
        $this->assertTrue($service->find(1));
    }

    public function test_if_it_find_all_by_name()
    {
        // Init ..
        $repository_centre = Mockery::mock('SDIS62\Core\Ops\Repository\CentreRepositoryInterface')->makePartial();
        $service = new Core\Service\CentreService($repository_centre);

        // Prepare ..
        $repository_centre->shouldReceive('findAllByName')->with('test')->andReturn(true)->once();

        // Test!
        $this->assertTrue($service->findAllByName('test'));
    }

    public function test_if_it_delete()
    {
        // Init ..
        $repository_centre = Mockery::mock('SDIS62\Core\Ops\Repository\CentreRepositoryInterface')->makePartial();
        $service = new Core\Service\CentreService($repository_centre);

        // Prepare ..
        $centre = Mockery::mock('SDIS62\Core\Ops\Entity\Centre');
        $repository_centre->shouldReceive('find')->with(1)->andReturn($centre)->once();
        $repository_centre->shouldReceive('find')->with(2)->andReturn(null)->once();
        $repository_centre->shouldReceive('delete')->with($centre)->once();

        // Test!
        $this->assertEquals($centre, $service->delete(1));
        $this->assertNull($service->delete(2));
    }

    public function test_if_it_create()
    {
        // Init ..
        $repository_centre = Mockery::mock('SDIS62\Core\Ops\Repository\CentreRepositoryInterface')->makePartial();
        $service = new Core\Service\CentreService($repository_centre);

        // Prepare ..
        $data = array('name' => 'CIS Arras');
        $centre_expected = new Core\Entity\Centre('CIS Arras');
        $repository_centre->shouldReceive('save')->once();

        // Test!
        $this->assertEquals($centre_expected, $service->save($data));
    }

    public function test_if_it_update()
    {
        // Init ..
        $repository_centre = Mockery::mock('SDIS62\Core\Ops\Repository\CentreRepositoryInterface')->makePartial();
        $service = new Core\Service\CentreService($repository_centre);

        // Prepare ..
        $data = array('name' => 'CIS Bethune');
        $centre_updated = new Core\Entity\Centre('CIS Arras');
        $centre_expected = new Core\Entity\Centre('CIS Bethune');
        $repository_centre->shouldReceive('find')->with(1)->andReturn($centre_updated)->once();
        $repository_centre->shouldReceive('save')->once();

        // Test!
        $this->assertEquals($centre_expected, $service->save($data, 1));
    }

    public function tearDown()
    {
        parent::tearDown();
        Mockery::close();
    }
}
