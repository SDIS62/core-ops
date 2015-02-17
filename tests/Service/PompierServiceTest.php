<?php

namespace SDIS62\Core\Ops\Entity\Service;

use Mockery;
use SDIS62\Core\Ops as Core;
use PHPUnit_Framework_TestCase;

class PompierServiceTest extends PHPUnit_Framework_TestCase
{
    public function test_if_it_find()
    {
        // Init ..
        $repository_pompier = Mockery::mock('SDIS62\Core\Ops\Repository\PompierRepositoryInterface')->makePartial();
        $repository_centre = Mockery::mock('SDIS62\Core\Ops\Repository\CentreRepositoryInterface')->makePartial();
        $service = new Core\Service\PompierService($repository_pompier, $repository_centre);

        // Prepare ..
        $repository_pompier->shouldReceive('find')->with(1)->andReturn(true)->once();

        // Test!
        $this->assertTrue($service->find(1));
    }

    public function test_if_it_find_all_by_name()
    {
        // Init ..
        $repository_pompier = Mockery::mock('SDIS62\Core\Ops\Repository\PompierRepositoryInterface')->makePartial();
        $repository_centre = Mockery::mock('SDIS62\Core\Ops\Repository\CentreRepositoryInterface')->makePartial();
        $service = new Core\Service\PompierService($repository_pompier, $repository_centre);

        // Prepare ..
        $repository_pompier->shouldReceive('findAllByName')->with('test')->andReturn(true)->once();

        // Test!
        $this->assertTrue($service->findAllByName('test'));
    }

    public function test_if_it_delete()
    {
        // Init ..
        $repository_pompier = Mockery::mock('SDIS62\Core\Ops\Repository\PompierRepositoryInterface')->makePartial();
        $repository_centre = Mockery::mock('SDIS62\Core\Ops\Repository\CentreRepositoryInterface')->makePartial();
        $service = new Core\Service\PompierService($repository_pompier, $repository_centre);

        // Prepare ..
        $pompier = Mockery::mock('SDIS62\Core\Ops\Entity\Pompier');
        $repository_pompier->shouldReceive('find')->with(1)->andReturn($pompier)->once();
        $repository_pompier->shouldReceive('find')->with(2)->andReturn(null)->once();
        $repository_pompier->shouldReceive('delete')->with($pompier)->once();

        // Test!
        $this->assertEquals($pompier, $service->delete(1));
        $this->assertNull($service->delete(2));
    }

    public function test_if_it_create()
    {
        // Init ..
        $repository_pompier = Mockery::mock('SDIS62\Core\Ops\Repository\PompierRepositoryInterface')->makePartial();
        $repository_centre = Mockery::mock('SDIS62\Core\Ops\Repository\CentreRepositoryInterface')->makePartial();
        $service = new Core\Service\PompierService($repository_pompier, $repository_centre);

        // Prepare ..
        $data = array('centre' => 1, 'type' => 'pompier', 'name' => 'Kevin', 'matricule' => '00001');
        $centre = new Core\Entity\Centre('CIS Arras');
        $pompier_expected = new Core\Entity\Pompier('Kevin', '00001', $centre);
        $repository_centre->shouldReceive('find')->with(1)->andReturn($centre)->once();
        $repository_pompier->shouldReceive('save')->once();

        // Test!
        $this->assertEquals($pompier_expected, $service->save($data));
    }

    public function test_if_it_create_specialiste()
    {
        // Init ..
        $repository_pompier = Mockery::mock('SDIS62\Core\Ops\Repository\PompierRepositoryInterface')->makePartial();
        $repository_centre = Mockery::mock('SDIS62\Core\Ops\Repository\CentreRepositoryInterface')->makePartial();
        $service = new Core\Service\PompierService($repository_pompier, $repository_centre);

        // Prepare ..
        $data = array('centre' => 1, 'type' => 'specialiste', 'specialites' => array('A', 'B'), 'name' => 'Kevin', 'matricule' => '00001');
        $centre = new Core\Entity\Centre('CIS Arras');
        $pompier_expected = new Core\Entity\Pompier\SpecialistePompier('Kevin', '00001', $centre);
        $pompier_expected->setSpecialites(array('A', 'B'));
        $repository_centre->shouldReceive('find')->with(1)->andReturn($centre)->once();
        $repository_pompier->shouldReceive('save')->once();

        // Test!
        $this->assertEquals($pompier_expected, $service->save($data));
    }

    public function test_if_it_create_invalid_pompier()
    {
        // Init ..
        $repository_pompier = Mockery::mock('SDIS62\Core\Ops\Repository\PompierRepositoryInterface')->makePartial();
        $repository_centre = Mockery::mock('SDIS62\Core\Ops\Repository\CentreRepositoryInterface')->makePartial();
        $service = new Core\Service\PompierService($repository_pompier, $repository_centre);

        // Prepare ..
        $data = array('type' => 'alo',  'centre' => 1);
        $centre = new Core\Entity\Centre('CIS Arras');
        $repository_centre->shouldReceive('find')->with(1)->andReturn($centre)->once();

        // Test !
        try {
            $service->save($data);
        } catch (Core\Exception\InvalidPompierException $e) {
            return;
        }
        $this->fail('Exception must be throw');
    }

    public function test_if_it_create_with_invalid_centre()
    {
        // Init ..
        $repository_pompier = Mockery::mock('SDIS62\Core\Ops\Repository\PompierRepositoryInterface')->makePartial();
        $repository_centre = Mockery::mock('SDIS62\Core\Ops\Repository\CentreRepositoryInterface')->makePartial();
        $service = new Core\Service\PompierService($repository_pompier, $repository_centre);

        // Prepare ..
        $data = array('centre' => 3, 'type' => 'pompier', 'name' => 'Kevin', 'matricule' => '00001');
        $repository_centre->shouldReceive('find')->with(3)->andReturn(null)->once();

        // Test!
        $this->assertNull($service->save($data));
    }

    public function test_if_it_update()
    {
        // Init ..
        $repository_pompier = Mockery::mock('SDIS62\Core\Ops\Repository\PompierRepositoryInterface')->makePartial();
        $repository_centre = Mockery::mock('SDIS62\Core\Ops\Repository\CentreRepositoryInterface')->makePartial();
        $service = new Core\Service\PompierService($repository_pompier, $repository_centre);

        // Prepare ..
        $data = array('centre' => 2, 'type' => 'pompier', 'name' => 'Kelly', 'matricule' => '00002');
        $centre1 = new Core\Entity\Centre('CIS Arras');
        $centre2 = new Core\Entity\Centre('CIS Bethune');
        $pompier_updated = new Core\Entity\Pompier('Kevin', '00001', $centre1);
        $pompier_expected = new Core\Entity\Pompier('Kelly', '00002', $centre2);
        $repository_centre->shouldReceive('find')->with(2)->andReturn($centre2)->once();
        $repository_pompier->shouldReceive('find')->with(15)->andReturn($pompier_updated)->once();
        $repository_pompier->shouldReceive('save')->once();

        // Test!
        $this->assertEquals($pompier_expected, $service->save($data, 15));
    }

    public function tearDown()
    {
        parent::tearDown();
        Mockery::close();
    }
}
