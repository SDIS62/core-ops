<?php

namespace SDIS62\Core\Ops\Entity\Pompier;

use SDIS62\Core\Ops\Entity\Pompier;

class SpecialistePompier extends Pompier
{
    /**
     * Type.
     *
     * @var string
     */
    protected $type = 'specialiste';

    /**
     * Spécialités.
     *
     * @var array
     */
    protected $specialites;

    /**
     * Get the value of Spécialités.
     *
     * @return array
     */
    public function getSpecialites()
    {
        return empty($this->specialites) ? [] : array_values($this->specialites);
    }

    /**
     * Set the value of Spécialités.
     *
     * @param array specialites
     *
     * @return self
     */
    public function setSpecialites(array $specialites)
    {
        $this->specialites = $specialites;

        return $this;
    }
}
