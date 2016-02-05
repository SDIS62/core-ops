<?php

namespace SDIS62\Core\Ops\Test\Entity\Pompier;

use PHPUnit_Framework_TestCase;
use SDIS62\Core\Ops as Core;

class SpecialistePompierTest extends PHPUnit_Framework_TestCase
{
    protected static $object;

    public function setUp()
    {
        $commune      = new Core\Entity\Commune('Arras', '62001');
        $centre       = new Core\Entity\Centre($commune, 'CIS Arras');
        self::$object = new Core\Entity\Pompier\SpecialistePompier('DUBUC Kevin', 'mat001', $centre);
    }

    public function test_if_it_is_initializable()
    {
        $this->assertInstanceOf('SDIS62\Core\Ops\Entity\Pompier', self::$object);
        $this->assertInstanceOf('SDIS62\Core\Ops\Entity\Pompier\SpecialistePompier', self::$object);
    }

    public function test_if_it_have_specialites()
    {
        $this->assertCount(0, self::$object->getSpecialites());

        self::$object->setSpecialites(['CDC', 'CDG']);

        $this->assertCount(2, self::$object->getSpecialites());
    }

    public function test_if_it_have_a_type_specialiste()
    {
        $this->assertEquals('specialiste', self::$object->getType());
    }
}
