<?php

namespace SDIS62\Core\Ops\Entity;

use SDIS62\Core\Ops\Entity\Materiel;
use SDIS62\Core\Ops\Entity\Pompier;
use SDIS62\Core\Common\Entity\IdentityTrait;
use Doctrine\Common\Collections\ArrayCollection;

class Centre
{
    use IdentityTrait;

    /**
    * Nom du centre
    *
    * @var string
    */
    protected $name;

    /**
    * Matériels du centre
    *
    * @var SDIS62\Core\Ops\Entity\Materiel[]
    */
    protected $materiels;

    /**
    * Nom du centre
    *
    * @var SDIS62\Core\Ops\Entity\Pompier[]
    */
    protected $pompiers;

    /**
     * Création d'un centre
     *
     * @param string name
     */
    public function __construct($name)
    {
        $this->name = $name;
        $this->materiels = new ArrayCollection();
        $this->pompiers = new ArrayCollection();
    }

    /**
     * Get the value of Nom du centre
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of Nom du centre
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
     * Get the value of Matériels du centre
     *
     * @return SDIS62\Core\Ops\Entity\Materiel[]
     */
    public function getMateriels()
    {
        return $this->materiels;
    }

    /**
     * Ajoute un matériel au centre
     *
     * @param  SDIS62\Core\Ops\Entity\Materiel $materiel
     * @return self
     */
    public function addMateriel(Materiel $materiel)
    {
        $this->materiels[] = $materiel;

        return $this;
    }

    /**
     * Retourne les pompiers
     *
     * @return SDIS62\Core\Ops\Entity\Pompier[]
     */
    public function getPompiers()
    {
        return $this->pompiers;
    }

    /**
     * Ajoute un pompier au centre
     *
     * @param  SDIS62\Core\Ops\Entity\Pompier $pompier
     * @return self
     */
    public function addPompier(Pompier $pompier)
    {
        $this->pompiers[] = $pompier;

        return $this;
    }

}
