<?php

namespace SDIS62\Core\Ops\Test\Entity;

use Datetime;
use DateInterval;
use SDIS62\Core\Ops as Core;
use PHPUnit_Framework_TestCase;

class InterventionTest extends PHPUnit_Framework_TestCase
{
    protected static $object;

    public function setUp()
    {
        $sinistre = new Core\Entity\Sinistre("Feu de");
        self::$object = new Core\Entity\Intervention($sinistre);
    }

    public function test_if_it_have_an_id()
    {
        self::$object->setId(10);
        $this->assertEquals(10, self::$object->getId());
    }

    public function test_if_it_is_initializable()
    {
        $this->assertInstanceOf('SDIS62\Core\Ops\Entity\Intervention', self::$object);
    }

    public function test_if_it_have_a_etat()
    {
        self::$object->setEtat('En cours');
        $this->assertEquals('En cours', self::$object->getEtat());
        $this->assertInternalType('string', self::$object->getEtat());
    }

    public function test_if_it_have_a_precision()
    {
        self::$object->setPrecision('Precision intervention');
        $this->assertEquals('Precision intervention', self::$object->getPrecision());
        $this->assertInternalType('string', self::$object->getPrecision());
    }

    public function test_if_it_have_a_observations()
    {
        self::$object->setObservations('Observations intervention');
        $this->assertEquals('Observations intervention', self::$object->getObservations());
        $this->assertInternalType('string', self::$object->getObservations());
    }

    public function test_if_it_have_an_important_status()
    {
        $this->assertFalse(self::$object->isImportant());

        self::$object->setImportant(false);

        $this->assertFalse(self::$object->isImportant());

        self::$object->setImportant();

        $this->assertTrue(self::$object->isImportant());
        $this->assertInternalType('bool', self::$object->isImportant());
    }

    public function test_if_it_have_a_creation_date()
    {
        $now = new Datetime('NOW');
        $this->assertEquals($now->format('Y-m-d H:i'), self::$object->getCreated()->format('Y-m-d H:i'));
        $this->assertInstanceOf('\Datetime', self::$object->getCreated());
    }

    public function test_if_it_have_a_update_date()
    {
        $this->assertNull(self::$object->getUpdated());

        $created = self::$object->getCreated();
        self::$object->setUpdated($created);
        $this->assertNull(self::$object->getUpdated());

        $old = $created->sub(new DateInterval('PT1H'));
        self::$object->setUpdated($old);
        $this->assertNull(self::$object->getUpdated());

        $updated = new Datetime('tomorrow');
        self::$object->setUpdated($updated);
        $this->assertEquals($updated, self::$object->getUpdated());

        self::$object->setUpdated('01-01-2050 15:00:00');
        $this->assertEquals('01-01-2050 15:00:00', self::$object->getUpdated()->format('d-m-Y H:i:s'));

        $this->assertInstanceOf('\Datetime', self::$object->getUpdated());
    }

    public function test_if_it_have_a_sinistre()
    {
        $this->assertInstanceOf('SDIS62\Core\Ops\Entity\Sinistre', self::$object->getSinistre());
    }

    public function test_if_it_have_a_engagements()
    {
        $this->assertCount(0, self::$object->getEngagements());

        $centre = new Core\Entity\Centre('CIS Arras');
        $materiel = new Core\Entity\Materiel($centre, 'VSAV1');
        $pompier = new Core\Entity\Pompier('DUBUC Kévin', '0001', $centre);

        $engagement1 = new Core\Entity\Engagement\PompierEngagement(self::$object, $materiel, $pompier);
        $engagement2 = new Core\Entity\Engagement\PompierEngagement(self::$object, $materiel, $pompier);

        $this->assertCount(2, self::$object->getEngagements());
    }

    public function test_if_it_have_a_evenements()
    {
        $this->assertCount(0, self::$object->getEvenements());

        $evenement1 = new Core\Entity\Evenement(self::$object, 'Arrive sur les lieux');
        $evenement2 = new Core\Entity\Evenement(self::$object, 'Intervention terminee', '01-01-2050 15:00:00');
        $evenement3 = new Core\Entity\Evenement(self::$object, 'Secours', new Datetime('tomorrow'));

        $this->assertCount(3, self::$object->getEvenements());
        $this->assertEquals('Arrive sur les lieux', self::$object->getEvenements()[0]->getDescription());
        $this->assertEquals('Secours', self::$object->getEvenements()[1]->getDescription());
        $this->assertEquals('Intervention terminee', self::$object->getEvenements()[2]->getDescription());
    }

    public function test_if_it_have_a_numinsee()
    {
        self::$object->setNumInsee('62000');
        $this->assertEquals('62000', self::$object->getNumInsee());
        $this->assertInternalType('string', self::$object->getNumInsee());
    }

    public function test_if_it_have_a_address()
    {
        self::$object->setAddress('11 rue des acacias, 62000 Arras');
        $this->assertEquals('11 rue des acacias, 62000 Arras', self::$object->getAddress());
        $this->assertInternalType('string', self::$object->getAddress());
    }

    public function test_if_it_have_a_coordinates()
    {
        self::$object->setCoordinates(array('X', 'Y'));
        $this->assertEquals(array('X', 'Y'), self::$object->getCoordinates());

        self::$object->setCoordinates(array('X', 'Y', 'Z'));
        $this->assertEquals(array('X', 'Y'), self::$object->getCoordinates());
    }
}
