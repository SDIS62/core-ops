<?php

namespace SDIS62\Core\Ops\Entity;

use Doctrine\Common\Collections\ArrayCollection;

class Commune
{
    /**
     * Code insee de la commune.
     *
     * @var string
     */
    protected $numinsee;

    /**
     * Nom de la commune.
     *
     * @var string
     */
    protected $name;

    /**
     * Centres sur la commune.
     *
     * @var SDIS62\Core\Ops\Entity\Centre[]
     */
    protected $centres;

    /**
     * Création d'une commune.
     *
     * @param string name
     * @param string numinsee
     */
    public function __construct($name, $numinsee)
    {
        $this->name = $name;
        $this->numinsee = $numinsee;
        $this->centres = new ArrayCollection();
    }

    /**
     * Get the value of Code insee de la commune.
     *
     * @return string
     */
    public function getNuminsee()
    {
        return $this->numinsee;
    }

    /**
     * Get the value of Nom de la commune.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of Nom de la commune.
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

    /**
     * Retourne les centres sur la commune.
     *
     * @return SDIS62\Core\Ops\Entity\Centre[]
     */
    public function getCentres()
    {
        return $this->centres;
    }

    /**
     * Ajoute un centre sur la commune.
     *
     * @param SDIS62\Core\Ops\Entity\Centre $centre
     *
     * @return self
     */
    public function addCentre(Centre $centre)
    {
        $this->centres[] = $centre;

        return $this;
    }
}
