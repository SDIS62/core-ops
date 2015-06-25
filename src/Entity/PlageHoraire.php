<?php

namespace SDIS62\Core\Ops\Entity;

use Datetime;
use SDIS62\Core\Common\Entity\IdentityTrait;
use SDIS62\Core\Ops\Exception\InvalidDateException;
use SDIS62\Core\Ops\Exception\InvalidPlageHoraireTypeException;

abstract class PlageHoraire
{
    use IdentityTrait;

    /**
     * Début de la plage horaire.
     *
     * @var Datetime
     */
    protected $start;

    /**
     * Fin de la plage horaire.
     *
     * @var Datetime
     */
    protected $end;

    /**
     * Planning.
     *
     * @var SDIS62\Core\Ops\Entity\Planning
     */
    protected $planning;

    /**
     * Pompier concerné.
     *
     * @var SDIS62\Core\Ops\Entity\Pompier
     */
    protected $pompier;

    /**
     * Ajout d'une plage horaire.
     *
     * @param SDIS62\Core\Ops\Entity\Planning $planning
     * @param SDIS62\Core\Ops\Entity\Pompier $pompier
     * @param Datetime $start
     * @param Datetime $end
     */
    public function __construct(Planning $planning, Pompier $pompier, Datetime $start, Datetime $end)
    {
        $this->start = $start;
        $this->end = $end;

        if ($this->start->diff($this->end)->invert == 1) {
            throw new InvalidDateException('Events usually start before they end');
        }

        $this->planning = $planning;
        $this->pompier = $pompier;

        $this->planning->addPlageHoraire($this);
        $this->pompier->addPlageHoraire($this);
    }

    /**
     * Get the value of Début de la garde.
     *
     * @return Datetime
     */
    public function getStart()
    {
        return $this->start;
    }

    /**
     * Get the value of Fin de la garde.
     *
     * @return Datetime
     */
    public function getEnd()
    {
        return $this->end;
    }

    /**
     * Check si le Datetime est contenu dans la plage horaire.
     *
     * @param DateTime $date
     *
     * @return bool
     */
    public function contains(DateTime $date)
    {
        return $this->start <= $date && $date < $this->end;
    }

    /**
     * Retourne vrai si la plage horaire est contenu dans la place horaire actuelle.
     *
     * @param PlageHoraire $plage
     * @param bool         $strict
     *
     * @return bool
     */
    public function includes(PlageHoraire $plage, $strict = true)
    {
        if (true === $strict) {
            return $this->getStart() <= $plage->getStart() && $this->getEnd() >= $plage->getEnd();
        }

        return
            $this->includes($plage, true) ||
            $plage->includes($this, true) ||
            $this->contains($plage->getStart()) ||
            $this->contains($plage->getEnd())
        ;
    }

    /**
     * Get the value of Type.
     *
     * @return string
     */
    final public function getType()
    {
        if (empty($this->type)) {
            throw new InvalidPlageHoraireTypeException(get_class($this).' doit avoir un $type');
        }

        return $this->type;
    }

    /**
     * Get the value of Pompier concerné.
     *
     * @return SDIS62\Core\Ops\Entity\Pompier
     */
    public function getPompier()
    {
        return $this->pompier;
    }

    /**
     * Get the value of Planning.
     *
     * @return SDIS62\Core\Ops\Entity\Planning
     */
    public function getPlanning()
    {
        return $this->planning;
    }

}
