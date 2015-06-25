<?php

namespace SDIS62\Core\Ops\Entity;

use SDIS62\Core\Common\Entity\IdentityTrait;
use Doctrine\Common\Collections\ArrayCollection;

class Materiel
{
    use IdentityTrait;

    /**
     * Nom du materiel.
     *
     * @var string
     */
    protected $name;

    /**
     * Centre dans lequel le matériel est affecté.
     *
     * @var SDIS62\Core\Ops\Entity\Centre
     */
    protected $centre;

    /**
     * Liste des engagements du matériel.
     *
     * @var SDIS62\Core\Ops\Entity\Engagement[]
     */
    protected $engagements;

    /**
     * Coordonnées du matériel.
     *
     * @var SDIS62\Core\Ops\Entity\Coordinates
     */
    protected $coordinates;

    /**
     * Etat du matériel.
     *
     * @var SDIS62\Core\Ops\Entity\Statut
     */
    protected $statut;

    /**
     * Ajout d'un materiel à un centre.
     *
     * @param SDIS62\Core\Ops\Entity\Centre $centre
     * @param string                        $name
     */
    public function __construct(Centre $centre, $name)
    {
        $this->name   = $name;
        $this->centre = $centre;
        $this->centre->addMateriel($this);
        $this->engagements = new ArrayCollection();
        $this->statut = Statut::DISPONIBLE();
    }

    /**
     * Get the value of Nom du materiel.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of Nom du materiel.
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
     * Get the value of Centre dans lequel le materiel est affecté.
     *
     * @return SDIS62\Core\Ops\Entity\Centre
     */
    public function getCentre()
    {
        return $this->centre;
    }

    /**
     * Set the value of Centre dans lequel le materiel est affecté.
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

    /**
     * Get the value of Liste des engagements du matériel.
     *
     * @return SDIS62\Core\Ops\Entity\Engagement[]
     */
    public function getEngagements()
    {
        return $this->engagements;
    }

    /**
     * Ajoute un engagement au matériel.
     *
     * @param SDIS62\Core\Ops\Entity\Engagement $engagement
     *
     * @return self
     */
    public function addEngagement(Engagement $engagement)
    {
        $this->engagements[] = $engagement;

        return $this;
    }

    /**
     * Le matériel est il actuellement engagé ?
     *
     * @return bool
     */
    public function isEngage()
    {
        foreach ($this->engagements as $engagement) {
            if (!$engagement->isEnded()) {
                return true;
            }
        }

        return false;
    }

    /**
     * Get the value of Coordonnées du matériel.
     *
     * @return SDIS62\Core\Ops\Entity\Coordinates
     */
    public function getCoordinates()
    {
        return $this->coordinates;
    }

    /**
     * Set the value of Coordonnées du matériel.
     *
     * @param SDIS62\Core\Ops\Entity\Coordinates $coordinates
     *
     * @return self
     */
    public function setCoordinates(Coordinates $coordinates)
    {
        $this->coordinates = $coordinates;

        return $this;
    }

    /**
     * Get the value of Etat du matériel.
     *
     * @return SDIS62\Core\Ops\Entity\Statut
     */
    public function getStatut()
    {
        return $this->statut instanceof Statut ? $this->statut : Statut::get($this->statut);
    }

    /**
     * Set the value of Etat du matériel.
     *
     * @param SDIS62\Core\Ops\Entity\Statut statut
     *
     * @return self
     */
    public function setStatut(Statut $statut)
    {
        $this->statut = $statut;

        return $this;
    }

}
