<?php

namespace SDIS62\Core\Ops\Service;

use SDIS62\Core\Ops\Entity\Dispo;
use SDIS62\Core\Ops\Repository\DispoRepositoryInterface;
use SDIS62\Core\Ops\Repository\PompierRepositoryInterface;

class DispoService
{
    /**
     * Initialisation du service avec les repository utilisés.
     *
     * @param SDIS62\Core\Ops\Repository\DispoRepositoryInterface   $dispo_repository
     * @param SDIS62\Core\Ops\Repository\PompierRepositoryInterface $pompier_repository
     */
    public function __construct(DispoRepositoryInterface $dispo_repository,
                                PompierRepositoryInterface $pompier_repository
    ) {
        $this->dispo_repository   = $dispo_repository;
        $this->pompier_repository = $pompier_repository;
    }

    /**
     * Retourne une dispo correspondant à l'id spécifié.
     *
     * @param mixed $id_dispo
     *
     * @return SDIS62\Core\Ops\Entity\Dispo
     */
    public function find($id_dispo)
    {
        return $this->dispo_repository->find($id_dispo);
    }

    /**
     * AJout d'une dispo pour un pompier.
     *
     * @param array $data
     * @param array $id_pompier
     *
     * @return SDIS62\Core\Ops\Entity\Dispo
     */
    public function create($data, $id_pompier)
    {
        $pompier = $this->pompier_repository->find($id_pompier);

        if (empty($pompier)) {
            return;
        }

        $dispo = new Dispo($pompier, $data['start'], $data['end']);

        $this->dispo_repository->save($dispo);

        return $dispo;
    }

    /**
     * Suppression d'une dispo.
     *
     * @param mixed $id_dispo
     *
     * @return SDIS62\Core\Ops\Entity\Dispo
     */
    public function delete($id_dispo)
    {
        $dispo = $this->find($id_dispo);

        if (empty($dispo)) {
            return;
        }

        $this->dispo_repository->delete($dispo);

        return $dispo;
    }
}
