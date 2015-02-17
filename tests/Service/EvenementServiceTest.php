<?php

namespace SDIS62\Core\Ops\Entity\Service;

use Mockery;
use Datetime;
use SDIS62\Core\Ops as Core;
use PHPUnit_Framework_TestCase;

class EvenementServiceTest extends PHPUnit_Framework_TestCase
{
    public function test_if_it_find()
    {
        // Init ..
        $repository_evenement = Mockery::mock('SDIS62\Core\Ops\Repository\EvenementRepositoryInterface')->makePartial();
        $repository_intervention = Mockery::mock('SDIS62\Core\Ops\Repository\InterventionRepositoryInterface')->makePartial();
        $service = new Core\Service\EvenementService($repository_evenement, $repository_intervention);

        // Prepare ..
        $repository_evenement->shouldReceive('find')->with(1)->andReturn(true)->once();

        // Test!
        $this->assertTrue($service->find(1));
    }

    public function test_if_it_delete()
    {
        // Init ..
        $repository_evenement = Mockery::mock('SDIS62\Core\Ops\Repository\EvenementRepositoryInterface')->makePartial();
        $repository_intervention = Mockery::mock('SDIS62\Core\Ops\Repository\InterventionRepositoryInterface')->makePartial();
        $service = new Core\Service\EvenementService($repository_evenement, $repository_intervention);

        // Prepare ..
        $evenement = Mockery::mock('SDIS62\Core\Ops\Entity\Evenement');
        $repository_evenement->shouldReceive('find')->with(1)->andReturn($evenement)->once();
        $repository_evenement->shouldReceive('find')->with(2)->andReturn(null)->once();
        $repository_evenement->shouldReceive('delete')->with($evenement)->once();

        // Test!
        $this->assertEquals($evenement, $service->delete(1));
        $this->assertNull($service->delete(2));
    }

    public function test_if_it_create()
    {
        // Init ..
        $repository_evenement = Mockery::mock('SDIS62\Core\Ops\Repository\EvenementRepositoryInterface')->makePartial();
        $repository_intervention = Mockery::mock('SDIS62\Core\Ops\Repository\InterventionRepositoryInterface')->makePartial();
        $service = new Core\Service\EvenementService($repository_evenement, $repository_intervention);

        // Prepare ..
        $data = array('description' => 'Description', 'date' => new Datetime('2015-12-01 15:00'));
        $intervention = new Core\Entity\Intervention(new Core\Entity\Sinistre('Feu de'));
        $evenement_expected = new Core\Entity\Evenement($intervention, 'Description', new Datetime('2015-12-01 15:00'));
        $repository_evenement->shouldReceive('save')->once();
        $repository_intervention->shouldReceive('find')->with(1)->andReturn($intervention)->once();
        $repository_intervention->shouldReceive('find')->with(2)->andReturn(null)->once();

        // Test!
        $this->assertEquals($evenement_expected, $service->create($data, 1));
        $this->assertNull($service->create($data, 2));
    }

    public function tearDown()
    {
        parent::tearDown();
        Mockery::close();
    }
}
