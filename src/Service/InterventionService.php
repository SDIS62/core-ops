<?php

namespace SDIS62\Core\Ops\Service;

use SDIS62\Core\Ops\Entity\Intervention;
use SDIS62\Core\Ops\Repository\CommuneRepositoryInterface;
use SDIS62\Core\Ops\Repository\SinistreRepositoryInterface;
use SDIS62\Core\Ops\Repository\InterventionRepositoryInterface;

class InterventionService
{
    /**
     * Initialisation du service avec les repository utilisés
     *
     * @param SDIS62\Core\Ops\Repository\InterventionRepositoryInterface $intervention_repository
     * @param SDIS62\Core\Ops\Repository\SinistreRepositoryInterface     $sinistre_repository
     * @param SDIS62\Core\Ops\Repository\CommuneRepositoryInterface     $commune_repository
     */
    public function __construct(InterventionRepositoryInterface $intervention_repository,
                                SinistreRepositoryInterface $sinistre_repository,
                                CommuneRepositoryInterface $commune_repository
    ) {
        $this->intervention_repository = $intervention_repository;
        $this->sinistre_repository = $sinistre_repository;
        $this->commune_repository = $commune_repository;
    }

    /**
     * Retourne les interventions
     *
     * @param  int                                   $count Par défaut: 20
     * @param  int                                   $page  Par défaut: 1
     * @return SDIS62\Core\Ops\Entity\Intervention[]
     */
    public function getAll($count = 20, $page = 1)
    {
        return $this->intervention_repository->getAll($count, $page);
    }

    /**
     * Retourne une intervention correspondant à l'id spécifié
     *
     * @param  mixed                               $id_intervention
     * @return SDIS62\Core\Ops\Entity\Intervention
     */
    public function find($id_intervention)
    {
        return $this->intervention_repository->find($id_intervention);
    }

    /**
     * Sauvegarde d'une intervention
     *
     * @param  array                               $data
     * @param  array                               $id_intervention Optionnel
     * @return SDIS62\Core\Ops\Entity\Intervention
     */
    public function save($data, $id_intervention = null)
    {
        $sinistre = $this->sinistre_repository->find($data['sinistre']);

        if (empty($sinistre)) {
            return;
        }

        $intervention = empty($id_intervention) ? new Intervention($sinistre) : $this->intervention_repository->find($id_intervention);

        if (!empty($data['precision'])) {
            $intervention->setPrecision($data['precision']);
        }

        if (!empty($data['observations'])) {
            $intervention->setObservations($data['observations']);
        }

        if (!empty($data['updated'])) {
            $intervention->setUpdated($data['updated']);
        }

        if (!empty($data['ended'])) {
            $intervention->setEnded($data['ended']);
        }

        if (!empty($data['sinistre'])) {
            $intervention->setSinistre($sinistre);
        }

        if (!empty($data['coordinates'])) {
            $intervention->setCoordinates($data['coordinates']);
        }

        if (!empty($data['address'])) {
            $intervention->setAddress($data['address']);
        }

        if (array_key_exists('important', $data)) {
            $intervention->setImportant($data['important'] === true);
        }

        if (!empty($data['commune'])) {
            $intervention->setCommune($this->commune_repository->find($data['commune']));
        }

        $this->intervention_repository->save($intervention);

        return $intervention;
    }

    /**
     * Suppression d'une intervention
     *
     * @param  mixed                               $id_intervention
     * @return SDIS62\Core\Ops\Entity\Intervention
     */
    public function delete($id_intervention)
    {
        $intervention = $this->find($id_intervention);

        if (empty($intervention)) {
            return;
        }

        $this->intervention_repository->delete($intervention);

        return $intervention;
    }
}
