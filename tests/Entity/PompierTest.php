<?php

namespace SDIS62\Core\Ops\Test\Entity;

use Datetime;
use SDIS62\Core\Ops as Core;
use PHPUnit_Framework_TestCase;

class PompierTest extends PHPUnit_Framework_TestCase
{
    protected static $object;

    public function setUp()
    {
        $commune = new Core\Entity\Commune('Arras', '62001');
        $centre = new Core\Entity\Centre($commune, "CIS Arras");
        self::$object = new Core\Entity\Pompier("DUBUC Kevin", "mat001", $centre);
    }
    public function test_if_it_is_initializable()
    {
        $this->assertInstanceOf('SDIS62\Core\Ops\Entity\Pompier', self::$object);
    }

    public function test_if_it_have_a_name()
    {
        $this->assertEquals('DUBUC Kevin', self::$object->getName());
        $this->assertInternalType('string', self::$object->getName());
    }

    public function test_if_it_have_a_matricule()
    {
        $this->assertEquals('mat001', self::$object->getMatricule());
        $this->assertInternalType('string', self::$object->getMatricule());
    }

    public function test_if_it_have_a_centre()
    {
        $this->assertInstanceOf('SDIS62\Core\Ops\Entity\Centre', self::$object->getCentre());

        $ancien_centre = self::$object->getCentre();
        $commune = new Core\Entity\Commune('Bethune', '62002');
        $nouveau_centre = new Core\Entity\Centre($commune, "CIS Bethune");

        self::$object->setCentre($nouveau_centre);

        $this->assertCount(0, $ancien_centre->getPompiers());
        $this->assertCount(1, $nouveau_centre->getPompiers());
        $this->assertEquals('CIS Bethune', self::$object->getCentre()->getName());
        $this->assertInstanceOf('SDIS62\Core\Ops\Entity\Centre', self::$object->getCentre());
    }

    public function test_if_it_have_gardes()
    {
        $garde1 = new Core\Entity\Garde(self::$object, '14-02-2015 15:00', '14-02-2015 18:00');
        $garde2 = new Core\Entity\Garde(self::$object, '15-02-2015 15:00', '15-02-2015 18:00');

        $this->assertCount(2, self::$object->getGardes());
    }

    public function test_if_it_have_engagements()
    {
        $this->assertCount(0, self::$object->getEngagements());
        $this->assertFalse(self::$object->isEngage());

        $intervention = new Core\Entity\Intervention(new Core\Entity\Sinistre('Feu de'));
        $commune = new Core\Entity\Commune('Arras', '62001');
        $centre = new Core\Entity\Centre($commune, 'CIS Arras');
        $materiel = new Core\Entity\Materiel($centre, 'VSAV1');

        $engagement1 = new Core\Entity\Engagement\PompierEngagement($intervention, $materiel, self::$object);
        $engagement2 = new Core\Entity\Engagement\PompierEngagement($intervention, $materiel, self::$object);

        $this->assertCount(2, self::$object->getEngagements());
        $this->assertTrue(self::$object->isEngage());

        $intervention->setEnded(new Datetime('tomorrow'));

        $this->assertFalse(self::$object->isEngage());
    }

    public function test_if_it_have_a_type_pompier()
    {
        $this->assertEquals('pompier', self::$object->getType());
    }
}
