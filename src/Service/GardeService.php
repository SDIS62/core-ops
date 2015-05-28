<?php

namespace SDIS62\Core\Ops\Service;

use SDIS62\Core\Ops\Entity\Garde;
use SDIS62\Core\Ops\Repository\GardeRepositoryInterface;
use SDIS62\Core\Ops\Repository\PompierRepositoryInterface;

class GardeService
{
    /**
     * Initialisation du service avec les repository utilisés.
     *
     * @param SDIS62\Core\Ops\Repository\GardeRepositoryInterface   $garde_repository
     * @param SDIS62\Core\Ops\Repository\PompierRepositoryInterface $pompier_repository
     */
    public function __construct(GardeRepositoryInterface $garde_repository,
                                PompierRepositoryInterface $pompier_repository
    ) {
        $this->garde_repository = $garde_repository;
        $this->pompier_repository = $pompier_repository;
    }

    /**
     * Retourne un ensemble de gardes en cours.
     *
     *
     * @return SDIS62\Core\User\Entity\Garde[]
     */
    public function getAllCurrent()
    {
        return $this->garde_repository->getAllCurrent();
    }

    /**
     * Retourne un ensemble de gardes sur un mois.
     *
     * @param int $month
     *
     * @return SDIS62\Core\User\Entity\Garde[]
     */
    public function findAllByMonth($month)
    {
        return $this->garde_repository->findAllByMonth($month);
    }

    /**
     * Retourne une garde correspondant à l'id spécifié.
     *
     * @param mixed $id_garde
     *
     * @return SDIS62\Core\Ops\Entity\Garde
     */
    public function find($id_garde)
    {
        return $this->garde_repository->find($id_garde);
    }

    /**
     * AJout d'une garde pour un pompier.
     *
     * @param array $data
     * @param array $id_pompier
     *
     * @return SDIS62\Core\Ops\Entity\Centre
     */
    public function create($data, $id_pompier)
    {
        $pompier = $this->pompier_repository->find($id_pompier);

        if (empty($pompier)) {
            return;
        }

        $garde = new Garde($pompier, $data['start'], $data['end']);

        $this->garde_repository->save($garde);

        return $garde;
    }

    /**
     * Suppression d'une garde.
     *
     * @param mixed $id_garde
     *
     * @return SDIS62\Core\Ops\Entity\Garde
     */
    public function delete($id_garde)
    {
        $garde = $this->find($id_garde);

        if (empty($garde)) {
            return;
        }

        $this->garde_repository->delete($garde);

        return $garde;
    }
}
