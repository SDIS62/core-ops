<?php

namespace SDIS62\Core\Ops\Entity;

use Datetime;
use Doctrine\Common\Collections\ArrayCollection;
use SDIS62\Core\Common\Entity\IdentityTrait;
use SDIS62\Core\Ops\Exception\InvalidEngagementException;

abstract class Engagement
{
    use IdentityTrait;

    /**
     * Création de l'engagement.
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
     * Fin de l'engagement.
     *
     * @var Datetime
     */
    protected $ended;

    /**
     * Evenements particuliers de l'engagement.
     *
     * @var SDIS62\Core\Ops\Entity\Evenement[]
     */
    protected $evenements;

    /**
     * Intervention concernée.
     *
     * @var SDIS62\Core\Ops\Entity\Intervention
     */
    protected $intervention;

    /**
     * Ajout d'un engagement à une intervention.
     *
     * @param SDIS62\Core\Ops\Entity\Intervention $intervention
     */
    public function __construct(Intervention $intervention)
    {
        $this->intervention = $intervention;
        $this->intervention->addEngagement($this);

        $this->evenements = new ArrayCollection();

        $this->created = new Datetime('NOW');
    }

    /**
     * Get the value of Type de l'engagement.
     *
     * @return string
     */
    final public function getType()
    {
        if (empty($this->type)) {
            throw new InvalidEngagementException(get_class($this).' doit avoir un $type');
        }

        return $this->type;
    }

    /**
     * Get the value of Création de l'engagement.
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
    public function setUpdated($updated = null)
    {
        if (empty($updated)) {
            $this->setUpdated(new Datetime());
        } else {
            $updated = $updated instanceof Datetime ? $updated : DateTime::createFromFormat('d-m-Y H:i:s', (string) $updated);
        }

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
     * Set the value of Date de fin (la date doit être supérieure à la date de création).
     *
     * @param Datetime|string ended Format d-m-Y H:i:s
     *
     * @return self
     */
    public function setEnded($ended)
    {
        $ended = $ended instanceof Datetime ? $ended : DateTime::createFromFormat('d-m-Y H:i:s', (string) $ended);

        if ($ended > $this->created) {
            $this->ended = $ended;
            $this->setUpdated();
        }

        return $this;
    }

    /**
     * Retourne vrai si l'engagement est terminée.
     *
     * @return bool
     */
    public function isEnded()
    {
        return !empty($this->ended);
    }

    /**
     * Get the value of Evenements particuliers de l'engagement.
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
            return $a->getDate()->format('U') < $b->getDate()->format('U') ? -1 : 1;
        });

        return $evenements;
    }

    /**
     * Ajoute un evenement à l'engagement.
     *
     * @param SDIS62\Core\Ops\Entity\Evenement $evenement
     *
     * @return self
     */
    public function addEvenement(Evenement $evenement)
    {
        $this->evenements[] = $evenement;

        $this->setUpdated();

        return $this;
    }

    /**
     * Get the value of Intervention.
     *
     * @return SDIS62\Core\Ops\Entity\Intervention
     */
    public function getIntervention()
    {
        return $this->intervention;
    }
}
