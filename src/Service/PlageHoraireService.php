<?php

namespace SDIS62\Core\Ops\Service;

use Datetime;
use SDIS62\Core\Ops\Entity\PlageHoraire;
use SDIS62\Core\Ops\Repository\PompierRepositoryInterface;
use SDIS62\Core\Ops\Repository\PlanningRepositoryInterface;
use SDIS62\Core\Ops\Repository\PlageHoraireRepositoryInterface;
use SDIS62\Core\Ops\Exception\InvalidPlageHoraireTypeException;

class PlageHoraireService
{
    /**
     * Initialisation du service avec les repository utilisés.
     *
     * @param SDIS62\Core\Ops\Repository\PlageHoraireRepositoryInterface $plagehoraire_repository
     * @param SDIS62\Core\Ops\Repository\PompierRepositoryInterface      $pompier_repository
     * @param SDIS62\Core\Ops\Repository\PlanningRepositoryInterface     $planning_repository
     */
    public function __construct(PlageHoraireRepositoryInterface $plagehoraire_repository,
                                PompierRepositoryInterface $pompier_repository,
                                PlanningRepositoryInterface $planning_repository
    ) {
        $this->plagehoraire_repository = $plagehoraire_repository;
        $this->pompier_repository      = $pompier_repository;
        $this->planning_repository     = $planning_repository;
    }

    /**
     * Retourne une plage horaire correspondant à l'id spécifié.
     *
     * @param mixed $id_plage_horaire
     *
     * @return SDIS62\Core\Ops\Entity\PlageHoraire
     */
    public function find($id_plage_horaire)
    {
        return $this->plagehoraire_repository->find($id_plage_horaire);
    }

    /**
     * Sauvegarde d'une plage horaire.
     *
     * @param array $data
     *
     * @return SDIS62\Core\Ops\Entity\PlageHoraire
     */
    public function save(array $data)
    {
        $planning = $this->planning_repository->find($data['planning']);
        $pompier  = $this->pompier_repository->find($data['pompier']);
        $start    = DateTime::createFromFormat('d-m-Y H:i', (string) $data['start']);
        $end      = DateTime::createFromFormat('d-m-Y H:i', (string) $data['end']);

        switch ($data['type']) {
            case 'garde' :
                $plage_horaire = new PlageHoraire\GardePlageHoraire($planning, $pompier, $start, $end);
                break;
            case 'dispo' :
                $plage_horaire = new PlageHoraire\DispoPlageHoraire($planning, $pompier, $start, $end);
                break;
            default:
                throw new InvalidPlageHoraireTypeException();
        }

        $this->plagehoraire_repository->save($plage_horaire);

        return $plage_horaire;
    }

    /**
     * Suppression d'une plage horaire.
     *
     * @param mixed $id_plage_horaire
     */
    public function delete($id_plage_horaire)
    {
        $plage_horaire = $this->find($id_plage_horaire);

        if (empty($plage_horaire)) {
            return;
        }

        $this->plagehoraire_repository->delete($plage_horaire);

        return $plage_horaire;
    }
}
