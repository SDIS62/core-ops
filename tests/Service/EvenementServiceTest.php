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
        $repository_evenement    = Mockery::mock('SDIS62\Core\Ops\Repository\EvenementRepositoryInterface')->makePartial();
        $repository_intervention = Mockery::mock('SDIS62\Core\Ops\Repository\InterventionRepositoryInterface')->makePartial();
        $repository_engagement   = Mockery::mock('SDIS62\Core\Ops\Repository\EngagementRepositoryInterface')->makePartial();
        $service                 = new Core\Service\EvenementService($repository_evenement, $repository_intervention, $repository_engagement);

        // Prepare ..
        $repository_evenement->shouldReceive('find')->with(1)->andReturn(true)->once();

        // Test!
        $this->assertTrue($service->find(1));
    }

    public function test_if_it_delete()
    {
        // Init ..
        $repository_evenement    = Mockery::mock('SDIS62\Core\Ops\Repository\EvenementRepositoryInterface')->makePartial();
        $repository_intervention = Mockery::mock('SDIS62\Core\Ops\Repository\InterventionRepositoryInterface')->makePartial();
        $repository_engagement   = Mockery::mock('SDIS62\Core\Ops\Repository\EngagementRepositoryInterface')->makePartial();
        $service                 = new Core\Service\EvenementService($repository_evenement, $repository_intervention, $repository_engagement);

        // Prepare ..
        $evenement = Mockery::mock('SDIS62\Core\Ops\Entity\Evenement');
        $repository_evenement->shouldReceive('find')->with(1)->andReturn($evenement)->once();
        $repository_evenement->shouldReceive('find')->with(2)->andReturn(null)->once();
        $repository_evenement->shouldReceive('delete')->with($evenement)->once();

        // Test!
        $this->assertEquals($evenement, $service->delete(1));
        $this->assertNull($service->delete(2));
    }

    public function test_if_it_create_for_intervention()
    {
        // Init ..
        $repository_evenement    = Mockery::mock('SDIS62\Core\Ops\Repository\EvenementRepositoryInterface')->makePartial();
        $repository_intervention = Mockery::mock('SDIS62\Core\Ops\Repository\InterventionRepositoryInterface')->makePartial();
        $repository_engagement   = Mockery::mock('SDIS62\Core\Ops\Repository\EngagementRepositoryInterface')->makePartial();
        $service                 = new Core\Service\EvenementService($repository_evenement, $repository_intervention, $repository_engagement);

        // Prepare ..
        $data               = ['intervention' => 1, 'description' => 'Description', 'date' => new Datetime('2015-12-01 15:00')];
        $intervention       = new Core\Entity\Intervention(new Core\Entity\Sinistre('Feu de'));
        $evenement_expected = new Core\Entity\Evenement('Description', new Datetime('2015-12-01 15:00'));
        $repository_evenement->shouldReceive('save')->once();
        $repository_intervention->shouldReceive('find')->with(1)->andReturn($intervention)->once();
        $repository_intervention->shouldReceive('find')->with(2)->andReturn(null)->once();

        // Test!
        $this->assertEquals($evenement_expected, $service->create('intervention', $data));
        $this->assertNull($service->create('intervention', ['intervention' => 2, 'description' => 'Description']));
        $this->assertNull($service->create('dsqdqsd', ['intervention' => 1, 'description' => 'Description']));
    }

    public function test_if_it_create_for_engagement()
    {
        // Init ..
        $repository_evenement    = Mockery::mock('SDIS62\Core\Ops\Repository\EvenementRepositoryInterface')->makePartial();
        $repository_intervention = Mockery::mock('SDIS62\Core\Ops\Repository\InterventionRepositoryInterface')->makePartial();
        $repository_engagement   = Mockery::mock('SDIS62\Core\Ops\Repository\EngagementRepositoryInterface')->makePartial();
        $service                 = new Core\Service\EvenementService($repository_evenement, $repository_intervention, $repository_engagement);

        // Prepare ..
        $data               = ['engagement' => 1, 'description' => 'Description', 'date' => new Datetime('2015-12-01 15:00')];
        $intervention       = Mockery::mock('SDIS62\Core\Ops\Entity\Intervention')->makePartial();
        $materiel           = Mockery::mock('SDIS62\Core\Ops\Entity\Materiel')->makePartial();
        $pompier            = Mockery::mock('SDIS62\Core\Ops\Entity\Pompier')->makePartial();
        $engagement         = new Core\Entity\Engagement\PompierEngagement($intervention, $materiel, $pompier);
        $evenement_expected = new Core\Entity\Evenement('Description', new Datetime('2015-12-01 15:00'));
        $repository_evenement->shouldReceive('save')->once();
        $repository_engagement->shouldReceive('find')->with(1)->andReturn($engagement)->once();
        $repository_engagement->shouldReceive('find')->with(2)->andReturn(null)->once();

        // Test!
        $this->assertEquals($evenement_expected, $service->create('engagement', $data));
        $this->assertNull($service->create('engagement', ['engagement' => 2, 'description' => 'Description']));
        $this->assertNull($service->create('dsqdqsd', ['intervention' => 1, 'description' => 'Description']));
    }

    public function tearDown()
    {
        parent::tearDown();
        Mockery::close();
    }
}
