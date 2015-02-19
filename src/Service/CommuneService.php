<?php

namespace SDIS62\Core\Ops\Service;

use SDIS62\Core\Ops\Entity\Commune;
use SDIS62\Core\Ops\Repository\CommuneRepositoryInterface;

class CommuneService
{
    /**
     * Initialisation du service avec les repository utilisés.
     *
     * @param SDIS62\Core\Ops\Repository\CommuneRepositoryInterface $commune_repository
     */
    public function __construct(CommuneRepositoryInterface $commune_repository)
    {
        $this->commune_repository = $commune_repository;
    }

    /**
     * Retourne un ensemble de communes.
     *
     * @param int $count Par défaut: 20
     * @param int $page  Par défaut: 1
     *
     * @return SDIS62\Core\User\Entity\Commune[]
     */
    public function getAll($count = 20, $page = 1)
    {
        return $this->commune_repository->getAll($count, $page);
    }

    /**
     * Retourne une commune via son numéro insee.
     *
     * @param string $numinsee
     *
     * @return SDIS62\Core\Ops\Entity\Commune
     */
    public function find($numinsee)
    {
        return $this->commune_repository->find($numinsee);
    }

    /**
     * Sauvegarde d'une commune.
     *
     * @param array $data
     *
     * @return SDIS62\Core\Ops\Entity\Commune
     */
    public function save($data)
    {
        $commune = $this->commune_repository->find($data['numinsee']);

        if (empty($commune)) {
            $commune = new Commune($data['name'], $data['numinsee']);
        }

        if (!empty($data['name'])) {
            $commune->setName($data['name']);
        }

        $this->commune_repository->save($commune);

        return $commune;
    }

    /**
     * Suppression d'une commune.
     *
     * @param string $numinsee
     *
     * @return SDIS62\Core\Ops\Entity\Commune
     */
    public function delete($numinsee)
    {
        $commune = $this->find($numinsee);

        if (empty($commune)) {
            return;
        }

        $this->commune_repository->delete($commune);

        return $commune;
    }
}
