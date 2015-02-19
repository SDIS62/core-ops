<?php

namespace SDIS62\Core\Ops\Entity\Service;

use Mockery;
use SDIS62\Core\Ops as Core;
use PHPUnit_Framework_TestCase;

class PompierServiceTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        // Init ..
        $this->repository_pompier = Mockery::mock('SDIS62\Core\Ops\Repository\PompierRepositoryInterface')->makePartial();
        $this->repository_centre = Mockery::mock('SDIS62\Core\Ops\Repository\CentreRepositoryInterface')->makePartial();
        $this->service = new Core\Service\PompierService($this->repository_pompier, $this->repository_centre);
    }

    public function test_if_it_find()
    {
        // Prepare ..
        $this->repository_pompier->shouldReceive('find')->with('mat001')->andReturn(true)->once();

        // Test!
        $this->assertTrue($this->service->find('mat001'));
    }

    public function test_if_it_find_all_by_name()
    {
        // Prepare ..
        $this->repository_pompier->shouldReceive('findAllByName')->with('test', 20, 1)->andReturn(true)->once();

        // Test!
        $this->assertTrue($this->service->findAllByName('test'));
    }

    public function test_if_it_delete()
    {
        // Prepare ..
        $pompier = Mockery::mock('SDIS62\Core\Ops\Entity\Pompier');
        $this->repository_pompier->shouldReceive('find')->with(1)->andReturn($pompier)->once();
        $this->repository_pompier->shouldReceive('find')->with(2)->andReturn(null)->once();
        $this->repository_pompier->shouldReceive('delete')->with($pompier)->once();

        // Test!
        $this->assertEquals($pompier, $this->service->delete(1));
        $this->assertNull($this->service->delete(2));
    }

    public function test_if_it_create()
    {
        // Prepare ..
        $data = array('centre' => 1, 'type' => 'pompier', 'name' => 'Kevin', 'matricule' => '00001');
        $commune = new Core\Entity\Commune('Arras', '62001');
        $centre = new Core\Entity\Centre($commune, 'CIS Arras');
        $pompier_expected = new Core\Entity\Pompier('Kevin', '00001', $centre);
        $this->repository_centre->shouldReceive('find')->with(1)->andReturn($centre)->twice();
        $this->repository_pompier->shouldReceive('find')->with('00001')->andReturn(null)->once();
        $this->repository_pompier->shouldReceive('save')->once();

        // Test!
        $this->assertEquals($pompier_expected, $this->service->save($data));
    }

    public function test_if_it_create_specialiste()
    {
        // Prepare ..
        $data = array('centre' => 1, 'type' => 'specialiste', 'specialites' => array('A', 'B'), 'name' => 'Kevin', 'matricule' => '00001');
        $commune = new Core\Entity\Commune('Arras', '62001');
        $centre = new Core\Entity\Centre($commune, 'CIS Arras');
        $pompier_expected = new Core\Entity\Pompier\SpecialistePompier('Kevin', '00001', $centre);
        $pompier_expected->setSpecialites(array('A', 'B'));
        $this->repository_centre->shouldReceive('find')->with(1)->andReturn($centre)->twice();
        $this->repository_pompier->shouldReceive('find')->with('00001')->andReturn(null)->once();
        $this->repository_pompier->shouldReceive('save')->once();

        // Test!
        $this->assertEquals($pompier_expected, $this->service->save($data));
    }

    public function test_if_it_create_invalid_pompier()
    {
        // Prepare ..
        $data = array('type' => 'alo',  'centre' => 1);
        $commune = new Core\Entity\Commune('Arras', '62001');
        $centre = new Core\Entity\Centre($commune, 'CIS Arras');
        $this->repository_centre->shouldReceive('find')->with(1)->andReturn($centre)->once();

        // Test !
        try {
            $this->service->save($data);
        } catch (Core\Exception\InvalidPompierException $e) {
            return;
        }
        $this->fail('Exception must be throw');
    }

    public function test_if_it_create_with_invalid_centre()
    {
        // Prepare ..
        $data = array('centre' => 3, 'type' => 'pompier', 'name' => 'Kevin', 'matricule' => '00001');
        $this->repository_pompier->shouldReceive('find')->with('00001')->andReturn(null)->once();
        $this->repository_centre->shouldReceive('find')->with(3)->andReturn(null)->once();

        // Test!
        $this->assertNull($this->service->save($data));
    }

    public function test_if_it_update()
    {
        // Prepare ..
        $data = array('centre' => 2, 'type' => 'pompier', 'name' => 'Kelly', 'matricule' => '00001');
        $commune = new Core\Entity\Commune('Arras', '62001');
        $centre1 = new Core\Entity\Centre($commune, 'CIS Arras');
        $centre2 = new Core\Entity\Centre($commune, 'CIS Bethune');
        $pompier_updated = new Core\Entity\Pompier('Kevin', '00001', $centre1);
        $pompier_expected = new Core\Entity\Pompier('Kelly', '00001', $centre2);
        $this->repository_centre->shouldReceive('find')->with(2)->andReturn($centre2)->once();
        $this->repository_pompier->shouldReceive('find')->with('00001')->andReturn($pompier_updated)->once();
        $this->repository_pompier->shouldReceive('save')->once();

        // Test!
        $this->assertEquals($pompier_expected, $this->service->save($data));
    }

    public function tearDown()
    {
        parent::tearDown();
        Mockery::close();
    }
}
