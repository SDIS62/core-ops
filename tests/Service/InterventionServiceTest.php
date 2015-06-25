<?php

namespace SDIS62\Core\Ops\Entity\Service;

use Mockery;
use SDIS62\Core\Ops as Core;
use PHPUnit_Framework_TestCase;

class InterventionServiceTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        // Init ..
        $this->repository_intervention = Mockery::mock('SDIS62\Core\Ops\Repository\InterventionRepositoryInterface')->makePartial();
        $this->repository_sinistre     = Mockery::mock('SDIS62\Core\Ops\Repository\SinistreRepositoryInterface')->makePartial();
        $this->repository_commune      = Mockery::mock('SDIS62\Core\Ops\Repository\CommuneRepositoryInterface')->makePartial();
        $this->service                 = new Core\Service\InterventionService($this->repository_intervention, $this->repository_sinistre, $this->repository_commune);
    }

    public function test_if_it_find()
    {
        // Prepare ..
        $this->repository_intervention->shouldReceive('find')->with(1)->andReturn(true)->once();

        // Test!
        $this->assertTrue($this->service->find(1));
    }

    public function test_if_it_find_all_by_distance()
    {
        // Prepare ..
        $this->repository_intervention->shouldReceive('findAllByDistance')->with(50.2, 2.0, 500)->andReturn(true)->once();

        // Test!
        $this->assertTrue($this->service->findAllByDistance(50.2, 2.0));
    }

    public function test_if_it_get_all()
    {
        // Prepare ..
        $this->repository_intervention->shouldReceive('getAll')->with(20, 1)->andReturn(true)->once();

        // Test!
        $this->assertTrue($this->service->getAll());
    }

    public function test_if_it_delete()
    {
        // Prepare ..
        $intervention = Mockery::mock('SDIS62\Core\Ops\Entity\Intervention');
        $this->repository_intervention->shouldReceive('find')->with(1)->andReturn($intervention)->once();
        $this->repository_intervention->shouldReceive('find')->with(2)->andReturn(null)->once();
        $this->repository_intervention->shouldReceive('delete')->with($intervention)->once();

        // Test!
        $this->assertEquals($intervention, $this->service->delete(1));
        $this->assertNull($this->service->delete(2));
    }

    public function test_if_it_create()
    {
        // Prepare ..
        $data = [
            'sinistre'     => 1,
            'precision'    => 'medicamenteuse',
            'observations' => 'TAMED sur Arras',
            'updated'      => '15-01-2050 15:00',
            'coordinates'  => ['X', 'Y'],
            'address'      => '11 rue des acacias 62000 Arras',
            'commune'      => '62001',
            'important'    => true,
        ];
        $sinistre              = new Core\Entity\Sinistre('TA');
        $commune               = new Core\Entity\Commune('Arras', '62001');
        $intervention_expected = new Core\Entity\Intervention($sinistre);
        $intervention_expected->setPrecision('medicamenteuse');
        $intervention_expected->setObservations('TAMED sur Arras');
        $intervention_expected->setUpdated('15-01-2050 15:00');
        $intervention_expected->setCoordinates(new Core\Entity\Coordinates('X', 'Y'));
        $intervention_expected->setAddress('11 rue des acacias 62000 Arras');
        $intervention_expected->setCommune($commune);
        $intervention_expected->setImportant();
        $this->repository_sinistre->shouldReceive('find')->with(1)->andReturn($sinistre)->once();
        $this->repository_commune->shouldReceive('find')->with('62001')->andReturn($commune)->once();
        $this->repository_intervention->shouldReceive('save')->once();

        // Test!
        $this->assertEquals($intervention_expected, $this->service->save($data));
    }

    public function test_if_it_update()
    {
        // Prepare ..
        $data = [
            'sinistre'     => 2,
            'precision'    => 'medic',
            'observations' => 'TAMED sur 62000',
            'updated'      => '15-01-2060 15:00',
            'ended'        => '15-01-2061 15:00',
            'coordinates'  => ['X2', 'Y2'],
            'address'      => '85 rue des acacias 62000 Bethune',
            'commune'      => '62002',
            'important'    => false,
        ];
        $sinistre1            = new Core\Entity\Sinistre('TA');
        $commune1             = new Core\Entity\Commune('Arras', '62001');
        $intervention_updated = new Core\Entity\Intervention($sinistre1);
        $intervention_updated->setPrecision('medicamenteuse');
        $intervention_updated->setObservations('TAMED sur Arras');
        $intervention_updated->setUpdated('15-01-2050 15:00');
        $intervention_updated->setCoordinates(new Core\Entity\Coordinates('X2', 'Y2'));
        $intervention_updated->setAddress('11 rue des acacias 62000 Arras');
        $intervention_updated->setCommune($commune1);
        $intervention_updated->setImportant();
        $sinistre2             = new Core\Entity\Sinistre('Feu de');
        $commune2              = new Core\Entity\Commune('Bethune', '62002');
        $intervention_expected = new Core\Entity\Intervention($sinistre2);
        $intervention_expected->setPrecision('medic');
        $intervention_expected->setObservations('TAMED sur 62000');
        $intervention_expected->setUpdated('15-01-2060 15:00');
        $intervention_expected->setEnded('15-01-2061 15:00');
        $intervention_expected->setCoordinates(new Core\Entity\Coordinates('X2', 'Y2'));
        $intervention_expected->setAddress('85 rue des acacias 62000 Bethune');
        $intervention_expected->setCommune($commune2);
        $intervention_expected->setImportant(false);
        $this->repository_sinistre->shouldReceive('find')->with(2)->andReturn($sinistre2)->once();
        $this->repository_sinistre->shouldReceive('find')->with(3)->andReturn(null)->once();
        $this->repository_commune->shouldReceive('find')->with('62002')->andReturn($commune2)->once();
        $this->repository_intervention->shouldReceive('find')->with(15)->andReturn($intervention_updated)->once();
        $this->repository_intervention->shouldReceive('save')->once();

        // Test!
        $this->assertEquals($intervention_expected, $this->service->save($data, 15));
        $this->assertNull($this->service->save(['sinistre' => 3], 15));
    }

    public function tearDown()
    {
        parent::tearDown();
        Mockery::close();
    }
}
