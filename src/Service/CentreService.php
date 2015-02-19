<?php

namespace SDIS62\Core\Ops\Service;

use SDIS62\Core\Ops\Entity\Centre;
use SDIS62\Core\Ops\Repository\CentreRepositoryInterface;
use SDIS62\Core\Ops\Repository\CommuneRepositoryInterface;

class CentreService
{
    /**
     * Initialisation du service avec les repository utilisés.
     *
     * @param SDIS62\Core\Ops\Repository\CentreRepositoryInterface  $centre_repository
     * @param SDIS62\Core\Ops\Repository\CommuneRepositoryInterface $commune_repository
     */
    public function __construct(CentreRepositoryInterface $centre_repository,
                                CommuneRepositoryInterface $commune_repository
    ) {
        $this->centre_repository = $centre_repository;
        $this->commune_repository = $commune_repository;
    }

    /**
     * Retourne un ensemble de CIS.
     *
     * @param int $count Par défaut: 20
     * @param int $page  Par défaut: 1
     *
     * @return SDIS62\Core\User\Entity\Centre[]
     */
    public function getAll($count = 20, $page = 1)
    {
        return $this->centre_repository->getAll($count, $page);
    }

    /**
     * Retourne un CIS correspondant à l'id spécifié.
     *
     * @param mixed $id_centre
     *
     * @return SDIS62\Core\Ops\Entity\Centre
     */
    public function find($id_centre)
    {
        return $this->centre_repository->find($id_centre);
    }

    /**
     * Retourne des CIS correspondant au nom spécifié.
     *
     * @param string $name
     * @param int    $count Par défaut: 20
     * @param int    $page  Par défaut: 1
     *
     * @return SDIS62\Core\Ops\Entity\Centre[]
     */
    public function findAllByName($name, $count = 20, $page = 1)
    {
        return $this->centre_repository->findAllByName($name, $count, $page);
    }

    /**
     * Sauvegarde d'un centre.
     *
     * @param array $data
     * @param mixed $id_centre Optionnel
     *
     * @return SDIS62\Core\Ops\Entity\Centre
     */
    public function save($data, $id_centre = null)
    {
        if (empty($id_centre)) {
            $commune = $this->commune_repository->find($data['commune']);

            if (empty($commune)) {
                return;
            }

            $centre = new Centre($commune, $data['name']);
        } else {
            $centre = $this->centre_repository->find($id_centre);
        }

        if (empty($centre)) {
            return;
        }

        if (!empty($data['name'])) {
            $centre->setName($data['name']);
        }

        $this->centre_repository->save($centre);

        return $centre;
    }

    /**
     * Suppression d'un centre.
     *
     * @param mixed $id_centre
     *
     * @return SDIS62\Core\Ops\Entity\Centre
     */
    public function delete($id_centre)
    {
        $centre = $this->find($id_centre);

        if (empty($centre)) {
            return;
        }

        $this->centre_repository->delete($centre);

        return $centre;
    }
}
