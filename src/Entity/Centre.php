<?php

namespace SDIS62\Core\Ops\Entity;

use SDIS62\Core\Common\Entity\IdentityTrait;
use Doctrine\Common\Collections\ArrayCollection;

class Centre
{
    use IdentityTrait;

    /**
     * Nom du centre.
     *
     * @var string
     */
    protected $name;

    /**
     * Classement du centre.
     *
     * @var string
     */
    protected $classement;

    /**
     * Matériels du centre.
     *
     * @var SDIS62\Core\Ops\Entity\Materiel[]
     */
    protected $materiels;

    /**
     * Pompiers du centre.
     *
     * @var SDIS62\Core\Ops\Entity\Pompier[]
     */
    protected $pompiers;

    /**
     * Commune du centre.
     *
     * @var SDIS62\Core\Ops\Entity\Commune
     */
    protected $commune;

    /**
     * Création d'un centre.
     *
     * @param string name
     */
    public function __construct(Commune $commune, $name, $classement = 'CSP')
    {
        $this->name       = $name;
        $this->classement = $classement;
        $this->commune    = $commune;
        $this->commune->addCentre($this);
        $this->materiels = new ArrayCollection();
        $this->pompiers  = new ArrayCollection();
    }

    /**
     * Get the value of Nom du centre.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of Nom du centre.
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
     * Get the value of Matériels du centre.
     *
     * @return SDIS62\Core\Ops\Entity\Materiel[]
     */
    public function getMateriels()
    {
        return $this->materiels;
    }

    /**
     * Ajoute un matériel au centre.
     *
     * @param SDIS62\Core\Ops\Entity\Materiel $materiel
     *
     * @return self
     */
    public function addMateriel(Materiel $materiel)
    {
        $this->materiels[] = $materiel;

        return $this;
    }

    /**
     * Retourne les pompiers.
     *
     * @return SDIS62\Core\Ops\Entity\Pompier[]
     */
    public function getPompiers()
    {
        return $this->pompiers;
    }

    /**
     * Ajoute un pompier au centre.
     *
     * @param SDIS62\Core\Ops\Entity\Pompier $pompier
     *
     * @return self
     */
    public function addPompier(Pompier $pompier)
    {
        $this->pompiers[] = $pompier;

        return $this;
    }

    /**
     * Get the value of commune du centre.
     *
     * @return SDIS62\Core\Ops\Entity\Commune
     */
    public function getCommune()
    {
        return $this->commune;
    }

    /**
     * Get the value of Classement du centre.
     *
     * @return string
     */
    public function getClassement()
    {
        return $this->classement;
    }

    /**
     * Set the value of Classement du centre.
     *
     * @param string classement
     *
     * @return self
     */
    public function setClassement($classement)
    {
        $this->classement = $classement;

        return $this;
    }
}
