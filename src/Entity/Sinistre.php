<?php

namespace SDIS62\Core\Ops\Entity;

use SDIS62\Core\Common\Entity\IdentityTrait;

class Sinistre
{
    use IdentityTrait;

    /**
     * Nom du sinistre.
     *
     * @var string
     */
    protected $name;

    /**
     * Ajout d'un sinistre.
     *
     * @param string $name
     */
    public function __construct($name)
    {
        $this->name = $name;
    }

    /**
     * Get the value of Nom du sinistre.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of Nom du sinistre.
     *
     * @param string name
     *
     * @return self
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }
}
