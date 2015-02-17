<?php

namespace SDIS62\Core\Ops\Entity;

use Datetime;
use SDIS62\Core\Ops\Entity\Sinistre;
use SDIS62\Core\Ops\Entity\Evenement;
use SDIS62\Core\Ops\Entity\Engagement;
use SDIS62\Core\Common\Entity\IdentityTrait;
use Doctrine\Common\Collections\ArrayCollection;

class Intervention
{
    use IdentityTrait;

    /**
    * Etat de l'intervention
    *
    * @var string
    */
    protected $etat;

    /**
    * Précision sur le sinistre de l'intervention
    *
    * @var string
    */
    protected $precision;

    /**
    * Observations
    *
    * @var string
    */
    protected $observations;

    /**
    * L'intervention est elle importante ?
    *
    * @var bool
    */
    protected $important;

    /**
    * Date de création
    *
    * @var Datetime
    */
    protected $created;

    /**
    * Date de mise à jour
    *
    * @var Datetime
    */
    protected $updated;

    /**
    * Sinistre de l'intervention
    *
    * @var SDIS62\Core\Ops\Entity\Sinistre
    */
    protected $sinistre;

    /**
    * Engagements sur l'intervention
    *
    * @var SDIS62\Core\Ops\Entity\Engagement[]
    */
    protected $engagements;

    /**
    * Evenements particuliers de l'intervention
    *
    * @var SDIS62\Core\Ops\Entity\Evenement[]
    */
    protected $evenements;

    /**
    * Coordonnées de l'intervention ([x,y])
    *
    * @var array
    */
    protected $coordinates;

    /**
    * Adresse de l'intervention
    *
    * @var string
    */
    protected $address;

    /**
    * Numéro INSEE de la commune ou se trouve l'intervention
    *
    * @var string
    */
    protected $numinsee;

    /**
     * Création d'une intervention
     *
     */
    public function __construct(Sinistre $sinistre)
    {
        $this->setSinistre($sinistre);
        $this->created = new Datetime('NOW');
        $this->evenements = new ArrayCollection();
        $this->engagements = new ArrayCollection();
    }

    /**
     * Get the value of Etat de l'intervention
     *
     * @return string
     */
    public function getEtat()
    {
        return $this->etat;
    }

    /**
     * Set the value of Etat de l'intervention
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
     * Get the value of Précision sur le sinistre de l'intervention
     *
     * @return string
     */
    public function getPrecision()
    {
        return $this->precision;
    }

    /**
     * Set the value of Précision sur le sinistre de l'intervention
     *
     * @param string precision
     *
     * @return self
     */
    public function setPrecision($precision)
    {
        $this->precision = $precision;

        return $this;
    }

    /**
     * Get the value of Observations
     *
     * @return string
     */
    public function getObservations()
    {
        return $this->observations;
    }

    /**
     * Set the value of Observations
     *
     * @param string observations
     *
     * @return self
     */
    public function setObservations($observations)
    {
        $this->observations = $observations;

        return $this;
    }

    /**
     * Get the value of L'intervention est elle importante ?
     *
     * @return bool
     */
    public function isImportant()
    {
        return $this->important === true;
    }

    /**
     * Set the value of L'intervention est elle importante ?
     *
     * @param bool important
     *
     * @return self
     */
    public function setImportant($important = true)
    {
        $this->important = $important;

        return $this;
    }

    /**
     * Get the value of Date de création
     *
     * @return Datetime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Get the value of Date de mise à jour
     *
     * @return Datetime|null
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * Set the value of Date de mise à jour (la date doit être supérieure à la date de création)
     *
     * @param Datetime|string updated Format d-m-Y H:i:s
     *
     * @return self
     */
    public function setUpdated($updated)
    {
        $updated = $updated instanceof Datetime ? $updated : DateTime::createFromFormat('d-m-Y H:i:s', (string) $updated);

        if($updated > $this->created) {
            $this->updated = $updated;
        }

        return $this;
    }

    /**
     * Get the value of Sinistre de l'intervention
     *
     * @return SDIS62\Core\Ops\Entity\Sinistre
     */
    public function getSinistre()
    {
        return $this->sinistre;
    }

    /**
     * Set the value of Sinistre de l'intervention
     *
     * @param SDIS62\Core\Ops\Entity\Sinistre sinistre
     *
     * @return self
     */
    public function setSinistre(Sinistre $sinistre)
    {
        $this->sinistre = $sinistre;

        return $this;
    }

    /**
     * Get the value of Engagements sur l'intervention
     *
     * @return SDIS62\Core\Ops\Entity\Engagement[]
     */
    public function getEngagements()
    {
        return $this->engagements;
    }

    /**
     * Ajoute un engagement à l'intervention
     *
     * @param  SDIS62\Core\Ops\Entity\Engagement $engagement
     * @return self
     */
    public function addEngagement(Engagement $engagement)
    {
        $this->engagements[] = $engagement;

        return $this;
    }

    /**
     * Get the value of Evenements particuliers de l'intervention
     *
     * @return SDIS62\Core\Ops\Entity\Evenement[]
     */
    public function getEvenements()
    {
        if (count($this->evenements) == 0) {
            return array();
        }

        $evenements = $this->evenements->toArray();

        @usort($evenements, function ($a, $b) {
            return $a->getDate()->format('U') < $b->getDate()->format('U') ? -1 : 1;
        });

        return $evenements;
    }

    /**
     * Ajoute un evenement à l'intervention
     *
     * @param  SDIS62\Core\Ops\Entity\Evenement $evenement
     * @return self
     */
    public function addEvenement(Evenement $evenement)
    {
        $this->evenements[] = $evenement;

        return $this;
    }

    /**
     * Get the value of Coordonnées de l'intervention ([x,y])
     *
     * @return array
     */
    public function getCoordinates()
    {
        return $this->coordinates;
    }

    /**
     * Set the value of Coordonnées de l'intervention ([x,y])
     *
     * @param array coordinates
     *
     * @return self
     */
    public function setCoordinates(array $coordinates)
    {
        if(count($coordinates) != 2) {
            return;
        }

        $this->coordinates = $coordinates;

        return $this;
    }


    /**
     * Get the value of Adresse de l'intervention
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set the value of Adresse de l'intervention
     *
     * @param string address
     *
     * @return self
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get the value of Numéro INSEE de la commune ou se trouve l'intervention
     *
     * @return string
     */
    public function getNuminsee()
    {
        return $this->numinsee;
    }

    /**
     * Set the value of Numéro INSEE de la commune ou se trouve l'intervention
     *
     * @param string numinsee
     *
     * @return self
     */
    public function setNuminsee($numinsee)
    {
        $this->numinsee = $numinsee;

        return $this;
    }

}
