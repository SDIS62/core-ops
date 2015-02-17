<?php

namespace SDIS62\Core\Ops\Entity\Service;

use Mockery;
use SDIS62\Core\Ops as Core;
use PHPUnit_Framework_TestCase;

class EngagementServiceTest extends PHPUnit_Framework_TestCase
{
    public function test_if_it_find()
    {
        // Init ..
        $repository_engagement = Mockery::mock('SDIS62\Core\Ops\Repository\EngagementRepositoryInterface')->makePartial();
        $repository_materiel = Mockery::mock('SDIS62\Core\Ops\Repository\MaterielRepositoryInterface')->makePartial();
        $repository_intervention = Mockery::mock('SDIS62\Core\Ops\Repository\InterventionRepositoryInterface')->makePartial();
        $repository_pompier = Mockery::mock('SDIS62\Core\Ops\Repository\PompierRepositoryInterface')->makePartial();
        $service = new Core\Service\EngagementService($repository_engagement, $repository_materiel, $repository_intervention, $repository_pompier);

        // Prepare ..
        $repository_engagement->shouldReceive('find')->with(1)->andReturn(true)->once();

        // Test!
        $this->assertTrue($service->find(1));
    }

    public function test_if_it_delete()
    {
        // Init ..
        $repository_engagement = Mockery::mock('SDIS62\Core\Ops\Repository\EngagementRepositoryInterface')->makePartial();
        $repository_materiel = Mockery::mock('SDIS62\Core\Ops\Repository\MaterielRepositoryInterface')->makePartial();
        $repository_intervention = Mockery::mock('SDIS62\Core\Ops\Repository\InterventionRepositoryInterface')->makePartial();
        $repository_pompier = Mockery::mock('SDIS62\Core\Ops\Repository\PompierRepositoryInterface')->makePartial();
        $service = new Core\Service\EngagementService($repository_engagement, $repository_materiel, $repository_intervention, $repository_pompier);

        // Prepare ..
        $engagement = Mockery::mock('SDIS62\Core\Ops\Entity\Engagement');
        $repository_engagement->shouldReceive('find')->with(1)->andReturn($engagement)->once();
        $repository_engagement->shouldReceive('find')->with(2)->andReturn(null)->once();
        $repository_engagement->shouldReceive('delete')->with($engagement)->once();

        // Test!
        $this->assertEquals($engagement, $service->delete(1));
        $this->assertNull($service->delete(2));
    }

    public function test_if_it_create()
    {
        // Init ..
        $repository_engagement = Mockery::mock('SDIS62\Core\Ops\Repository\EngagementRepositoryInterface')->makePartial();
        $repository_materiel = Mockery::mock('SDIS62\Core\Ops\Repository\MaterielRepositoryInterface')->makePartial();
        $repository_intervention = Mockery::mock('SDIS62\Core\Ops\Repository\InterventionRepositoryInterface')->makePartial();
        $repository_pompier = Mockery::mock('SDIS62\Core\Ops\Repository\PompierRepositoryInterface')->makePartial();
        $service = new Core\Service\EngagementService($repository_engagement, $repository_materiel, $repository_intervention, $repository_pompier);

        // Prepare ..
        $data = array('type' => 'pompier', 'materiel' => 1, 'intervention' => 2015, 'pompier' => 2, 'etat' => 'En cours');
        $intervention = Mockery::mock('SDIS62\Core\Ops\Entity\Intervention')->makePartial();
        $materiel = Mockery::mock('SDIS62\Core\Ops\Entity\Materiel')->makePartial();
        $pompier = Mockery::mock('SDIS62\Core\Ops\Entity\Pompier')->makePartial();
        $engagement_expected = new Core\Entity\Engagement\PompierEngagement($intervention, $materiel, $pompier);

        $repository_intervention->shouldReceive('find')->with(2015)->andReturn($intervention)->twice();
        $repository_materiel->shouldReceive('find')->with(1)->andReturn($materiel)->once();
        $repository_pompier->shouldReceive('find')->with(2)->andReturn($pompier)->once();
        $repository_engagement->shouldReceive('save')->once();

        // Test!
        $this->assertEquals($engagement_expected, $service->save($data));
        try {
            $service->save(array('type' => 'alo',  'materiel' => 1, 'intervention' => 2015, 'pompier' => 2));
        } catch (Core\Exception\InvalidEngagementException $e) {
            return;
        }
        $this->fail('Exception must be throw');
    }

    public function test_if_it_update()
    {
        $repository_engagement = Mockery::mock('SDIS62\Core\Ops\Repository\EngagementRepositoryInterface')->makePartial();
        $repository_materiel = Mockery::mock('SDIS62\Core\Ops\Repository\MaterielRepositoryInterface')->makePartial();
        $repository_intervention = Mockery::mock('SDIS62\Core\Ops\Repository\InterventionRepositoryInterface')->makePartial();
        $repository_pompier = Mockery::mock('SDIS62\Core\Ops\Repository\PompierRepositoryInterface')->makePartial();
        $service = new Core\Service\EngagementService($repository_engagement, $repository_materiel, $repository_intervention, $repository_pompier);

        // Prepare ..
        $data = array('id' => 1, 'etat' => 'Termine');
        $intervention = Mockery::mock('SDIS62\Core\Ops\Entity\Intervention')->makePartial();
        $materiel = Mockery::mock('SDIS62\Core\Ops\Entity\Materiel')->makePartial();
        $pompier = Mockery::mock('SDIS62\Core\Ops\Entity\Pompier')->makePartial();
        $engagement_updated = new Core\Entity\Engagement\PompierEngagement($intervention, $materiel, $pompier);
        $engagement_expected = $engagement_updated;

        $repository_engagement->shouldReceive('find')->with(1)->andReturn($engagement_updated)->once();
        $repository_engagement->shouldReceive('save')->once();

        // Test!
        $this->assertEquals($engagement_expected, $service->save($data, 1));
    }

    public function tearDown()
    {
        parent::tearDown();
        Mockery::close();
    }
}
