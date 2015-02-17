<?php

namespace SDIS62\Core\Ops\Entity;

use Datetime;
use SDIS62\Core\Ops\Entity\Materiel;
use SDIS62\Core\Ops\Entity\Intervention;
use SDIS62\Core\Common\Entity\IdentityTrait;
use SDIS62\Core\Ops\Exception\InvalidEngagementException;

abstract class Engagement
{
    use IdentityTrait;

    /**
    * Date de l'engagement
    *
    * @var Datetime
    */
    protected $date;

    /**
    * Etat de l'engagement
    *
    * @var string
    */
    protected $etat;

    /**
    * Matériel engagé
    *
    * @var SDIS62\Core\Ops\Entity\Materiel
    */
    protected $materiel;

    /**
    * Intervention concernée
    *
    * @var SDIS62\Core\Ops\Entity\Intervention
    */
    protected $intervention;

    /**
     * Ajout d'un engagement à une intervention
     *
     * @param SDIS62\Core\Ops\Entity\Materiel $materiel
     * @param SDIS62\Core\Ops\Entity\Intervention $intervention
     */
    public function __construct(Intervention $intervention, Materiel $materiel)
    {
        $this->intervention = $intervention;
        $this->intervention->addEngagement($this);

        $this->materiel = $materiel;

        $this->date = new Datetime('NOW');
    }

    /**
     * Get the value of Type de l'engagement
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
     * Get the value of Date de l'engagement
     *
     * @return Datetime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Get the value of Etat de l'engagement
     *
     * @return string
     */
    public function getEtat()
    {
        return $this->etat;
    }

    /**
     * Set the value of Etat de l'engagement
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
     * Get the value of Matériel engagé
     *
     * @return SDIS62\Core\Ops\Entity\Materiel
     */
    public function getMateriel()
    {
        return $this->materiel;
    }

    /**
     * Get the value of Intervention
     *
     * @return SDIS62\Core\Ops\Entity\Intervention
     */
    public function getIntervention()
    {
        return $this->intervention;
    }

}
