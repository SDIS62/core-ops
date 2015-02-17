<?php

namespace SDIS62\Core\Ops\Entity;

use Datetime;
use SDIS62\Core\Common\Entity\IdentityTrait;

class Garde
{
    use IdentityTrait;

    /**
     * Pompier concerné
     *
     * @var SDIS62\Core\Ops\Entity\Pompier
     */
    protected $pompier;

    /**
     * Début de la garde
     *
     * @var Datetime
     */
    protected $debut;

    /**
     * Fin de la garde
     *
     * @var Datetime
     */
    protected $fin;

    /**
     * Ajout d'une garde à un spécialiste
     *
     * @param SDIS62\Core\Ops\Entity\Pompier $pompier
     * @param Datetime                       $debut   Le format peut être d-m-Y H:i
     * @param Datetime                       $fin     Le format peut être d-m-Y H:i
     */
    public function __construct(Pompier $pompier, $debut, $fin)
    {
        $this->pompier = $pompier;
        $this->pompier->addGarde($this);

        if ($debut instanceof Datetime) {
            $this->debut = $debut;
        } else {
            $this->debut = DateTime::createFromFormat('d-m-Y H:i', (string) $debut);
        }

        if ($fin instanceof Datetime) {
            $this->fin = $fin;
        } else {
            $this->fin = DateTime::createFromFormat('d-m-Y H:i', (string) $fin);
        }
    }

    /**
     * Get the value of Début de la garde
     *
     * @return Datetime
     */
    public function getDebut()
    {
        return $this->debut;
    }

    /**
     * Get the value of Fin de la garde
     *
     * @return Datetime
     */
    public function getFin()
    {
        return $this->fin;
    }

    /**
     * Get the value of Pompier concerné
     *
     * @return SDIS62\Core\Ops\Entity\Pompier
     */
    public function getPompier()
    {
        return $this->pompier;
    }
}
