<?php

namespace SDIS62\Core\Ops\Entity;

use SDIS62\Core\Common\Entity\IdentityTrait;

class Materiel
{
    use IdentityTrait;

    /**
     * Nom du materiel
     *
     * @var string
     */
    protected $name;

    /**
     * Etat du materiel
     *
     * @var string
     */
    protected $etat;

    /**
     * Centre dans lequel le matériel est affecté
     *
     * @var SDIS62\Core\Ops\Entity\Centre
     */
    protected $centre;

    /**
     * Ajout d'un materiel à un centre
     *
     * @param SDIS62\Core\Ops\Entity\Centre $centre
     * @param string                        $name
     */
    public function __construct(Centre $centre, $name)
    {
        $this->name = $name;
        $this->centre = $centre;
        $this->centre->addMateriel($this);
    }

    /**
     * Get the value of Nom du materiel
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of Nom du materiel
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
     * Get the value of Etat du materiel
     *
     * @return string
     */
    public function getEtat()
    {
        return $this->etat;
    }

    /**
     * Set the value of Etat du materiel
     *
     * @param string etat
     *
     * @return self
     */
    public function setEtat($etat)
    {
        $this->etat = $etat;

        return $this;
    }

    /**
     * Get the value of Centre dans lequel le materiel est affecté
     *
     * @return SDIS62\Core\Ops\Entity\Centre
     */
    public function getCentre()
    {
        return $this->centre;
    }

    /**
     * Set the value of Centre dans lequel le materiel est affecté
     *
     * @param SDIS62\Core\Ops\Entity\Centre centre
     *
     * @return self
     */
    public function setCentre(Centre $centre)
    {
        $this->centre = $centre;

        return $this;
    }
}
