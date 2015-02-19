<?php

namespace SDIS62\Core\Ops\Service;

use SDIS62\Core\Ops\Entity\Sinistre;
use SDIS62\Core\Ops\Repository\SinistreRepositoryInterface;

class SinistreService
{
    /**
     * Initialisation du service avec les repository utilisés.
     *
     * @param SDIS62\Core\Ops\Repository\SinistreRepositoryInterface $sinistre_repository
     */
    public function __construct(SinistreRepositoryInterface $sinistre_repository)
    {
        $this->sinistre_repository = $sinistre_repository;
    }

    /**
     * Retourne un ensemble de sinistre.
     *
     * @param int $count Par défaut: 20
     * @param int $page  Par défaut: 1
     *
     * @return SDIS62\Core\User\Entity\Sinistre[]
     */
    public function getAll($count = 20, $page = 1)
    {
        return $this->sinistre_repository->getAll($count, $page);
    }

    /**
     * Retourne un sinistre correspondant à l'id spécifié.
     *
     * @param mixed $id_sinistre
     *
     * @return SDIS62\Core\Ops\Entity\Sinistre
     */
    public function find($id_sinistre)
    {
        return $this->sinistre_repository->find($id_sinistre);
    }

    /**
     * Sauvegarde d'un sinistre.
     *
     * @param array $data
     * @param array $id_sinistre Optionnel
     *
     * @return SDIS62\Core\Ops\Entity\Sinistre
     */
    public function save($data, $id_sinistre = null)
    {
        $sinistre = empty($id_sinistre) ? new Sinistre($data['name']) : $this->sinistre_repository->find($id_sinistre);

        if (!empty($data['name'])) {
            $sinistre->setName($data['name']);
        }

        $this->sinistre_repository->save($sinistre);

        return $sinistre;
    }

    /**
     * Suppression d'un sinistre.
     *
     * @param mixed $id_sinistre
     *
     * @return SDIS62\Core\Ops\Entity\Sinistre
     */
    public function delete($id_sinistre)
    {
        $sinistre = $this->find($id_sinistre);

        if (empty($sinistre)) {
            return;
        }

        $this->sinistre_repository->delete($sinistre);

        return $sinistre;
    }
}
