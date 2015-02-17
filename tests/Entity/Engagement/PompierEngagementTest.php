<?php

namespace SDIS62\Core\Ops\Test\Entity;

use Datetime;
use SDIS62\Core\Ops as Core;
use PHPUnit_Framework_TestCase;

class PompierEngagementTest extends PHPUnit_Framework_TestCase
{
    protected static $object;

    public function setUp()
    {
        $sinistre = new Core\Entity\Sinistre("Feu de");
        $intervention = new Core\Entity\Intervention($sinistre);
        $centre = new Core\Entity\Centre("CIS Arras");
        $materiel = new Core\Entity\Materiel($centre, "VSAV1");
        $pompier = new Core\Entity\Pompier("DUBUC Kevin", "mat001", $centre);

        self::$object = new Core\Entity\Engagement\PompierEngagement($intervention, $materiel, $pompier);
    }

    public function test_if_it_is_initializable()
    {
        $this->assertInstanceOf('SDIS62\Core\Ops\Entity\Engagement\PompierEngagement', self::$object);
    }

    public function test_if_it_have_a_pompier()
    {
        $this->assertInstanceOf('SDIS62\Core\Ops\Entity\Pompier', self::$object->getPompier());
    }

    public function test_if_it_have_a_type_pompier()
    {
        $this->assertEquals('pompier', self::$object->getType());
    }
}
