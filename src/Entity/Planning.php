<?php

namespace SDIS62\Core\Ops\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use SDIS62\Core\Common\Entity\IdentityTrait;
use SDIS62\Core\Ops\Exception\InvalidDateException;

class Planning
{
    use IdentityTrait;

    /**
     * Nom du planning.
     *
     * @var string
     */
    protected $name;

    /**
     * Plages Horaires.
     *
     * @var SDIS62\Core\Ops\Entity\PlageHoraire[]
     */
    protected $plages_horaires;

    /**
     * Création d'un planning.
     *
     * @param string $name
     */
    public function __construct($name)
    {
        $this->name            = $name;
        $this->plages_horaires = new ArrayCollection();
    }

    /**
     * Ajout d'une plage horaire.
     *
     * @param SDIS62\Core\Ops\Entity\PlageHoraire $plage_horaire
     *
     * @return self
     */
    public function addPlageHoraire(PlageHoraire $plage_horaire)
    {
        // Règles d'ajout
        if ($plage_horaire instanceof PlageHoraire\GardePlageHoraire) {
            // Contrôles des gardes existantes (une dispo ne peut pas être ajoutée sur une garde)
            foreach ($plage_horaire->getPompier()->getGardes() as $garde) {
                if ($garde->includes($plage_horaire, false)) {
                    throw new InvalidDateException('Une garde existe aux dates de la garde à ajouter');
                }
            }
            // Contrôles des dispo existantes (si une garde est posé sur une dispo, on la transforme)
            foreach ($plage_horaire->getPompier()->getDispos() as $dispo) {
                if ($dispo->includes($plage_horaire, false)) {
                    $plage_horaire->getPompier()->getPlagesHoraires()->removeElement($dispo);
                    if ($dispo->getStart() < $plage_horaire->getStart()) {
                        new PlageHoraire\DispoPlageHoraire($this, $plage_horaire->getPompier(), $dispo->getStart(), $plage_horaire->getStart());
                    }
                    if ($dispo->getEnd() > $plage_horaire->getEnd()) {
                        new PlageHoraire\DispoPlageHoraire($this, $plage_horaire->getPompier(), $plage_horaire->getEnd(), $dispo->getEnd());
                    }
                }
            }
        } elseif ($plage_horaire instanceof PlageHoraire\DispoPlageHoraire) {
            // Contrôles des gardes existantes (une dispo ne peut pas être ajoutée sur une garde)
            foreach ($plage_horaire->getPompier()->getGardes() as $garde) {
                if ($garde->includes($plage_horaire, false)) {
                    throw new InvalidDateException('Une garde existe aux dates de la dispo');
                }
            }
            // Contrôles des dispo existantes (une dispo ne peut pas être ajoutée sur une autre dispo)
            foreach ($plage_horaire->getPompier()->getDispos() as $dispo) {
                if ($dispo->includes($plage_horaire, false)) {
                    throw new InvalidDateException('Une disponibilité existe aux dates de la dispo');
                }
            }
        }

        $this->plages_horaires->add($plage_horaire);

        return $this;
    }

    /**
     * Récupération des plages horaires du planning.
     *
     * @return SDIS62\Core\Ops\Entity\PlageHoraire[]
     */
    public function getPlagesHoraires()
    {
        return $this->plages_horaires;
    }

    /**
     * Get the value of Gardes.
     *
     * @return SDIS62\Core\Ops\Entity\PlageHoraire\Garde[]
     */
    public function getGardes()
    {
        $gardes = [];

        foreach ($this->plages_horaires as $plage_horaire) {
            if ($plage_horaire instanceof PlageHoraire\GardePlageHoraire) {
                $gardes[] = $plage_horaire;
            }
        }

        return $gardes;
    }

    /**
     * Get the value of Dispos.
     *
     * @return SDIS62\Core\Ops\Entity\PlageHoraire\Dispo[]
     */
    public function getDispos()
    {
        $dispos = [];

        foreach ($this->plages_horaires as $plage_horaire) {
            if ($plage_horaire instanceof PlageHoraire\GardePlageHoraire) {
                $dispos[] = $plage_horaire;
            }
        }

        return $dispos;
    }

    /**
     * Get the value of Nom du planning.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of Nom du planning.
     *
     * @param string name
     *
     * @return self
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }
}
