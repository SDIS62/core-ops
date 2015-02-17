<?php

namespace SDIS62\Core\Ops\Entity\Service;

use Mockery;
use SDIS62\Core\Ops as Core;
use PHPUnit_Framework_TestCase;

class SinistreServiceTest extends PHPUnit_Framework_TestCase
{
    public function test_if_it_get_all()
    {
        // Init ..
        $repository_sinistre = Mockery::mock('SDIS62\Core\Ops\Repository\SinistreRepositoryInterface')->makePartial();
        $service = new Core\Service\SinistreService($repository_sinistre);

        // Prepare ..
        $repository_sinistre->shouldReceive('getAll')->andReturn(true)->once();

        // Test!
        $this->assertTrue($service->getAll());
    }

    public function test_if_it_find()
    {
        // Init ..
        $repository_sinistre = Mockery::mock('SDIS62\Core\Ops\Repository\SinistreRepositoryInterface')->makePartial();
        $service = new Core\Service\SinistreService($repository_sinistre);

        // Prepare ..
        $repository_sinistre->shouldReceive('find')->with(1)->andReturn(true)->once();

        // Test!
        $this->assertTrue($service->find(1));
    }

    public function test_if_it_delete()
    {
        // Init ..
        $repository_sinistre = Mockery::mock('SDIS62\Core\Ops\Repository\SinistreRepositoryInterface')->makePartial();
        $service = new Core\Service\SinistreService($repository_sinistre);

        // Prepare ..
        $sinistre = Mockery::mock('SDIS62\Core\Ops\Entity\Sinistre');
        $repository_sinistre->shouldReceive('find')->with(1)->andReturn($sinistre)->once();
        $repository_sinistre->shouldReceive('find')->with(2)->andReturn(null)->once();
        $repository_sinistre->shouldReceive('delete')->with($sinistre)->once();

        // Test!
        $this->assertEquals($sinistre, $service->delete(1));
        $this->assertNull($service->delete(2));
    }

    public function test_if_it_create()
    {
        // Init ..
        $repository_sinistre = Mockery::mock('SDIS62\Core\Ops\Repository\SinistreRepositoryInterface')->makePartial();
        $service = new Core\Service\SinistreService($repository_sinistre);

        // Prepare ..
        $data = array('name' => 'Feu de');
        $sinistre_expected = new Core\Entity\Sinistre('Feu de');
        $repository_sinistre->shouldReceive('save')->once();

        // Test!
        $this->assertEquals($sinistre_expected, $service->save($data));
    }

    public function test_if_it_update()
    {
        // Init ..
        $repository_sinistre = Mockery::mock('SDIS62\Core\Ops\Repository\SinistreRepositoryInterface')->makePartial();
        $service = new Core\Service\SinistreService($repository_sinistre);

        // Prepare ..
        $data = array('name' => 'TA');
        $sinistre_updated = new Core\Entity\Sinistre('Feu de');
        $sinistre_expected = new Core\Entity\Sinistre('TA');
        $repository_sinistre->shouldReceive('find')->with(1)->andReturn($sinistre_updated)->once();
        $repository_sinistre->shouldReceive('save')->once();

        // Test!
        $this->assertEquals($sinistre_expected, $service->save($data, 1));
    }

    public function tearDown()
    {
        parent::tearDown();
        Mockery::close();
    }
}
