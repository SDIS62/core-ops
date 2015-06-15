<?php

namespace SDIS62\Core\Ops\Entity;

use Exception;

class Garde extends PlageHoraire
{
    /**
     * Pompier concerné.
     *
     * @var SDIS62\Core\Ops\Entity\Pompier
     */
    protected $pompier;

    /**
     * Ajout d'une garde à un spécialiste.
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
                throw new Exception('Une garde existe aux dates de la garde à ajouter');
            }
        }

        // Contrôles des dispo existantes (si une garde est posé sur une dispo, on la transforme)
        foreach ($pompier->getDispos() as $dispo) {
            if ($dispo->includes($this, false)) {
                $pompier->getDispos()->removeElement($dispo);
                if ($dispo->getStart() < $this->getStart()) {
                    new Dispo($pompier, $dispo->getStart(), $this->getStart());
                }
                if ($dispo->getEnd() > $this->getEnd()) {
                    new Dispo($pompier, $this->getEnd(), $dispo->getEnd());
                }
            }
        }

        // Affectation du pompier
        $this->pompier = $pompier;
        $this->pompier->addGarde($this);
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
