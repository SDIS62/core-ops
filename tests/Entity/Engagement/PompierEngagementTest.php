<?php

namespace SDIS62\Core\Ops\Test\Entity;

use SDIS62\Core\Ops as Core;
use PHPUnit_Framework_TestCase;

class PompierEngagementTest extends PHPUnit_Framework_TestCase
{
    protected static $object;

    public function setUp()
    {
        $sinistre     = new Core\Entity\Sinistre('Feu de');
        $intervention = new Core\Entity\Intervention($sinistre);
        $commune      = new Core\Entity\Commune('Arras', '62001');
        $centre       = new Core\Entity\Centre($commune, 'CIS Arras');
        $materiel     = new Core\Entity\Materiel($centre, 'VSAV1');
        $pompier      = new Core\Entity\Pompier('DUBUC Kevin', 'mat001', $centre);

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

    public function test_if_it_have_a_materiel()
    {
        $this->assertInstanceOf('SDIS62\Core\Ops\Entity\Materiel', self::$object->getMateriel());
    }

    public function test_if_it_have_a_type_pompier()
    {
        $this->assertEquals('pompier', self::$object->getType());
    }

    public function test_if_it_have_a_specialites_engagees()
    {
        $sinistre     = new Core\Entity\Sinistre('Feu de');
        $intervention = new Core\Entity\Intervention($sinistre);
        $commune      = new Core\Entity\Commune('Arras', '62001');
        $centre       = new Core\Entity\Centre($commune, 'CIS Arras');
        $materiel     = new Core\Entity\Materiel($centre, 'VSAV1');

        $engagement = new Core\Entity\Engagement\PompierEngagement($intervention, $materiel, new Core\Entity\Pompier('DUBUC Kevin', 'mat001', $centre));
        $this->assertCount(0, $engagement->getSpecialitesEngagees());

        $engagement = new Core\Entity\Engagement\PompierEngagement($intervention, $materiel, new Core\Entity\Pompier\SpecialistePompier('DUBUC Kevin', 'mat001', $centre));
        $this->assertCount(0, $engagement->getSpecialitesEngagees());

        $engagement = new Core\Entity\Engagement\PompierEngagement($intervention, $materiel, new Core\Entity\Pompier\SpecialistePompier('DUBUC Kevin', 'mat001', $centre), ['urt']);
        $this->assertCount(0, $engagement->getSpecialitesEngagees());

        $specialiste = new Core\Entity\Pompier\SpecialistePompier('DUBUC Kevin', 'mat001', $centre);
        $specialiste->setSpecialites(['urt', 'grimp']);
        $engagement = new Core\Entity\Engagement\PompierEngagement($intervention, $materiel, $specialiste, ['urt']);
        $this->assertCount(1, $engagement->getSpecialitesEngagees());
        $this->assertEquals('urt', $engagement->getSpecialitesEngagees()[0]);
    }
}
