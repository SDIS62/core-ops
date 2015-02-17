<?php

namespace SDIS62\Core\Ops\Entity\Service;

use Mockery;
use SDIS62\Core\Ops as Core;
use PHPUnit_Framework_TestCase;

class InterventionServiceTest extends PHPUnit_Framework_TestCase
{
    public function test_if_it_find()
    {
        // Init ..
        $repository_intervention = Mockery::mock('SDIS62\Core\Ops\Repository\InterventionRepositoryInterface')->makePartial();
        $repository_sinistre = Mockery::mock('SDIS62\Core\Ops\Repository\SinistreRepositoryInterface')->makePartial();
        $service = new Core\Service\InterventionService($repository_intervention, $repository_sinistre);

        // Prepare ..
        $repository_intervention->shouldReceive('find')->with(1)->andReturn(true)->once();

        // Test!
        $this->assertTrue($service->find(1));
    }

    public function test_if_it_get_all()
    {
        // Init ..
        $repository_intervention = Mockery::mock('SDIS62\Core\Ops\Repository\InterventionRepositoryInterface')->makePartial();
        $repository_sinistre = Mockery::mock('SDIS62\Core\Ops\Repository\SinistreRepositoryInterface')->makePartial();
        $service = new Core\Service\InterventionService($repository_intervention, $repository_sinistre);

        // Prepare ..
        $repository_intervention->shouldReceive('getAll')->with(20, 1)->andReturn(true)->once();

        // Test!
        $this->assertTrue($service->getAll());
    }

    public function test_if_it_delete()
    {
        // Init ..
        $repository_intervention = Mockery::mock('SDIS62\Core\Ops\Repository\InterventionRepositoryInterface')->makePartial();
        $repository_sinistre = Mockery::mock('SDIS62\Core\Ops\Repository\SinistreRepositoryInterface')->makePartial();
        $service = new Core\Service\InterventionService($repository_intervention, $repository_sinistre);

        // Prepare ..
        $intervention = Mockery::mock('SDIS62\Core\Ops\Entity\Intervention');
        $repository_intervention->shouldReceive('find')->with(1)->andReturn($intervention)->once();
        $repository_intervention->shouldReceive('find')->with(2)->andReturn(null)->once();
        $repository_intervention->shouldReceive('delete')->with($intervention)->once();

        // Test!
        $this->assertEquals($intervention, $service->delete(1));
        $this->assertNull($service->delete(2));
    }

    public function test_if_it_create()
    {
        // Init ..
        $repository_intervention = Mockery::mock('SDIS62\Core\Ops\Repository\InterventionRepositoryInterface')->makePartial();
        $repository_sinistre = Mockery::mock('SDIS62\Core\Ops\Repository\SinistreRepositoryInterface')->makePartial();
        $service = new Core\Service\InterventionService($repository_intervention, $repository_sinistre);

        // Prepare ..
        $data = array(
            'sinistre' => 1,
            'precision' => 'medicamenteuse',
            'observations' => 'TAMED sur Arras',
            'updated' => '15-01-2050 15:00',
            'coordinates' => array('X', 'Y'),
            'address' => '11 rue des acacias 62000 Arras',
            'numinsee' => '62000',
            'important' => true,
        );
        $sinistre = new Core\Entity\Sinistre('TA');
        $intervention_expected = new Core\Entity\Intervention($sinistre);
        $intervention_expected->setPrecision('medicamenteuse');
        $intervention_expected->setObservations('TAMED sur Arras');
        $intervention_expected->setUpdated('15-01-2050 15:00');
        $intervention_expected->setCoordinates(array('X', 'Y'));
        $intervention_expected->setAddress('11 rue des acacias 62000 Arras');
        $intervention_expected->setNumInsee('62000');
        $intervention_expected->setImportant();
        $repository_sinistre->shouldReceive('find')->with(1)->andReturn($sinistre)->once();
        $repository_intervention->shouldReceive('save')->once();

        // Test!
        $this->assertEquals($intervention_expected, $service->save($data));
    }

    public function test_if_it_update()
    {
        // Init ..
        $repository_intervention = Mockery::mock('SDIS62\Core\Ops\Repository\InterventionRepositoryInterface')->makePartial();
        $repository_sinistre = Mockery::mock('SDIS62\Core\Ops\Repository\SinistreRepositoryInterface')->makePartial();
        $service = new Core\Service\InterventionService($repository_intervention, $repository_sinistre);

        // Prepare ..
        $data = array(
            'sinistre' => 2,
            'precision' => 'medic',
            'observations' => 'TAMED sur 62000',
            'updated' => '15-01-2060 15:00',
            'ended' => '15-01-2061 15:00',
            'coordinates' => array('X2', 'Y2'),
            'address' => '85 rue des acacias 62000 Arras',
            'numinsee' => '62001',
            'important' => false,
        );
        $sinistre1 = new Core\Entity\Sinistre('TA');
        $intervention_updated = new Core\Entity\Intervention($sinistre1);
        $intervention_updated->setPrecision('medicamenteuse');
        $intervention_updated->setObservations('TAMED sur Arras');
        $intervention_updated->setUpdated('15-01-2050 15:00');
        $intervention_updated->setCoordinates(array('X', 'Y'));
        $intervention_updated->setAddress('11 rue des acacias 62000 Arras');
        $intervention_updated->setNumInsee('62000');
        $intervention_updated->setImportant();
        $sinistre2 = new Core\Entity\Sinistre('Feu de');
        $intervention_expected = new Core\Entity\Intervention($sinistre2);
        $intervention_expected->setPrecision('medic');
        $intervention_expected->setObservations('TAMED sur 62000');
        $intervention_expected->setUpdated('15-01-2060 15:00');
        $intervention_expected->setEnded('15-01-2061 15:00');
        $intervention_expected->setCoordinates(array('X2', 'Y2'));
        $intervention_expected->setAddress('85 rue des acacias 62000 Arras');
        $intervention_expected->setNumInsee('62001');
        $intervention_expected->setImportant(false);
        $repository_sinistre->shouldReceive('find')->with(2)->andReturn($sinistre2)->once();
        $repository_sinistre->shouldReceive('find')->with(3)->andReturn(null)->once();
        $repository_intervention->shouldReceive('find')->with(15)->andReturn($intervention_updated)->once();
        $repository_intervention->shouldReceive('save')->once();

        // Test!
        $this->assertEquals($intervention_expected, $service->save($data, 15));
        $this->assertNull($service->save(array('sinistre' => 3), 15));
    }

    public function tearDown()
    {
        parent::tearDown();
        Mockery::close();
    }
}
