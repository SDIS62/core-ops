<?php

namespace SDIS62\Core\Ops\Entity;

use Datetime;
use SDIS62\Core\Common\Entity\IdentityTrait;

class Garde
{
    use IdentityTrait;

    /**
     * Pompier concerné.
     *
     * @var SDIS62\Core\Ops\Entity\Pompier
     */
    protected $pompier;

    /**
     * Début de la garde.
     *
     * @var Datetime
     */
    protected $start;

    /**
     * Fin de la garde.
     *
     * @var Datetime
     */
    protected $end;

    /**
     * Ajout d'une garde à un spécialiste.
     *
     * @param SDIS62\Core\Ops\Entity\Pompier $pompier
     * @param Datetime                       $start   Le format peut être d-m-Y H:i
     * @param Datetime                       $end     Le format peut être d-m-Y H:i
     */
    public function __construct(Pompier $pompier, $start, $end)
    {
        $this->pompier = $pompier;
        $this->pompier->addGarde($this);

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
     * Get the value of Pompier concerné.
     *
     * @return SDIS62\Core\Ops\Entity\Pompier
     */
    public function getPompier()
    {
        return $this->pompier;
    }
}
