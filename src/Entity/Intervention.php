<?php

namespace SDIS62\Core\Ops\Entity;

use Datetime;
use SDIS62\Core\Common\Entity\IdentityTrait;
use Doctrine\Common\Collections\ArrayCollection;

class Intervention
{
    use IdentityTrait;

    /**
     * Précision sur le sinistre de l'intervention.
     *
     * @var string
     */
    protected $precision;

    /**
     * Observations.
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
     * Date de création.
     *
     * @var Datetime
     */
    protected $created;

    /**
     * Date de mise à jour.
     *
     * @var Datetime
     */
    protected $updated;

    /**
     * Date de fin.
     *
     * @var Datetime
     */
    protected $ended;

    /**
     * Sinistre de l'intervention.
     *
     * @var SDIS62\Core\Ops\Entity\Sinistre
     */
    protected $sinistre;

    /**
     * Engagements sur l'intervention.
     *
     * @var SDIS62\Core\Ops\Entity\Engagement[]
     */
    protected $engagements;

    /**
     * Evenements particuliers de l'intervention.
     *
     * @var SDIS62\Core\Ops\Entity\Evenement[]
     */
    protected $evenements;

    /**
     * Coordonnées de l'intervention.
     *
     * @var SDIS62\Core\Ops\Entity\Coordinates
     */
    protected $coordinates;

    /**
     * Adresse de l'intervention.
     *
     * @var string
     */
    protected $address;

    /**
     * Commune ou se place l'intervention.
     *
     * @var SDIS62\Core\Ops\Entity\Commune
     */
    protected $commune;

    /**
     * Création d'une intervention.
     */
    public function __construct(Sinistre $sinistre)
    {
        $this->setSinistre($sinistre);
        $this->created     = new Datetime('NOW');
        $this->evenements  = new ArrayCollection();
        $this->engagements = new ArrayCollection();
    }

    /**
     * Get the value of Précision sur le sinistre de l'intervention.
     *
     * @return string
     */
    public function getPrecision()
    {
        return $this->precision;
    }

    /**
     * Set the value of Précision sur le sinistre de l'intervention.
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
     * Get the value of Observations.
     *
     * @return string
     */
    public function getObservations()
    {
        return $this->observations;
    }

    /**
     * Set the value of Observations.
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
        $this->important = $important === true;

        return $this;
    }

    /**
     * Get the value of Date de création.
     *
     * @return Datetime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Get the value of Date de mise à jour.
     *
     * @return Datetime|null
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * Set the value of Date de mise à jour (la date doit être supérieure à la date de création).
     *
     * @param Datetime|string updated Format d-m-Y H:i:s
     *
     * @return self
     */
    public function setUpdated($updated)
    {
        $updated = $updated instanceof Datetime ? $updated : DateTime::createFromFormat('d-m-Y H:i:s', (string) $updated);

        if ($updated > $this->created) {
            $this->updated = $updated;
        }

        return $this;
    }

    /**
     * Get the value of Date de fin.
     *
     * @return Datetime|null
     */
    public function getEnded()
    {
        return $this->ended;
    }

    /**
     * Set the value of Date de fin (la date doit être supérieure à la date de création et de mise à jour)
     * Met fin à tous les engagements.
     *
     * @param Datetime|string ended Format d-m-Y H:i:s
     *
     * @return self
     */
    public function setEnded($ended)
    {
        $ended = $ended instanceof Datetime ? $ended : DateTime::createFromFormat('d-m-Y H:i:s', (string) $ended);

        if ($ended > $this->created && (empty($this->updated) || $ended >= $this->updated)) {
            $this->ended = $ended;

            foreach ($this->engagements as $engagement) {
                $engagement->setEnded($ended);
            }
        }

        return $this;
    }

    /**
     * Retourne vrai si l'intervention est terminée.
     *
     * @return bool
     */
    public function isEnded()
    {
        return !empty($this->ended);
    }

    /**
     * Get the value of Sinistre de l'intervention.
     *
     * @return SDIS62\Core\Ops\Entity\Sinistre
     */
    public function getSinistre()
    {
        return $this->sinistre;
    }

    /**
     * Set the value of Sinistre de l'intervention.
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
     * Get the value of Engagements sur l'intervention.
     *
     * @return SDIS62\Core\Ops\Entity\Engagement[]
     */
    public function getEngagements()
    {
        return $this->engagements;
    }

    /**
     * Ajoute un engagement à l'intervention.
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
     * Get the value of Evenements particuliers de l'intervention.
     *
     * @return SDIS62\Core\Ops\Entity\Evenement[]
     */
    public function getEvenements()
    {
        if (count($this->evenements) == 0) {
            return [];
        }

        $evenements = $this->evenements->toArray();

        @usort($evenements, function ($a, $b) {
            return $a->getDate()->format('U') > $b->getDate()->format('U') ? -1 : 1;
        });

        return $evenements;
    }

    /**
     * Ajoute un evenement à l'intervention.
     *
     * @param SDIS62\Core\Ops\Entity\Evenement $evenement
     *
     * @return self
     */
    public function addEvenement(Evenement $evenement)
    {
        $this->evenements[] = $evenement;

        return $this;
    }

    /**
     * Get the value of Coordonnées de l'intervention.
     *
     * @return SDIS62\Core\Ops\Entity\Coordinates
     */
    public function getCoordinates()
    {
        return $this->coordinates;
    }

    /**
     * Set the value of Coordonnées de l'intervention.
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
     * Get the value of Adresse de l'intervention.
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set the value of Adresse de l'intervention.
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
     * Get the value of Commune ou se place l'intervention.
     *
     * @return SDIS62\Core\Ops\Entity\Commune
     */
    public function getCommune()
    {
        return $this->commune;
    }

    /**
     * Set the value of Commune ou se place l'intervention.
     *
     * @param SDIS62\Core\Ops\Entity\Commune commune
     *
     * @return self
     */
    public function setCommune(Commune $commune)
    {
        $this->commune = $commune;

        return $this;
    }
}
