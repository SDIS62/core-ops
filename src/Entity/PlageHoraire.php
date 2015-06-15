<?php

namespace SDIS62\Core\Ops\Entity;

use Datetime;
use Exception;
use SDIS62\Core\Common\Entity\IdentityTrait;

class PlageHoraire
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
     * Ajout d'une plage horaire.
     *
     * @param Datetime                       $start   Le format peut être d-m-Y H:i
     * @param Datetime                       $end     Le format peut être d-m-Y H:i
     */
    public function __construct($start, $end)
    {
        if ($start instanceof Datetime) {
            $this->start = $start;
        } else {
            $this->start = DateTime::createFromFormat('d-m-Y H:i', (string) $start);
        }

        if ($end instanceof Datetime) {
            $this->end = $end;
        } else {
            $this->end = DateTime::createFromFormat('d-m-Y H:i', (string) $end);
        }

        if ($this->start->diff($this->end)->invert == 1) {
            throw new Exception('Events usually start before they end');
        }
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
     * Check si le Datetime est contenu dans la plage horaire
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
     * Retourne vrai si la plage horaire est contenu dans la place horaire actuelle
     *
     * @param PlageHoraire $plage
     * @param bool            $strict
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
}
