<?php

namespace SDIS62\Core\Ops\Entity;

use Exception;

class Dispo extends PlageHoraire
{
    /**
     * Pompier concerné.
     *
     * @var SDIS62\Core\Ops\Entity\Pompier
     */
    protected $pompier;

    /**
     * Ajout d'une disponibilité à un pompier.
     *
     * @param SDIS62\Core\Ops\Entity\Pompier $pompier
     * @param Datetime                       $start   Le format peut être d-m-Y H:i
     * @param Datetime                       $end     Le format peut être d-m-Y H:i
     */
    public function __construct(Pompier $pompier, $start, $end)
    {
        parent::__construct($start, $end);

        // Contrôles des gardes existantes (une dispo ne peut pas être ajoutée sur une garde)
        foreach ($pompier->getGardes() as $garde) {
            if ($garde->includes($this, false)) {
                throw new Exception('Une garde existe aux dates de la dispo');
            }
        }

        // Contrôles des dispo existantes (une dispo ne peut pas être ajoutée sur une autre dispo)
        foreach ($pompier->getDispos() as $dispo) {
            if ($dispo->includes($this, false)) {
                throw new Exception('Une disponibilité existe aux dates de la dispo');
            }
        }

        // Affectation du pompier
        $this->pompier = $pompier;
        $this->pompier->addDispo($this);
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
