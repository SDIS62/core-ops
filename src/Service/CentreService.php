<?php

namespace SDIS62\Core\Ops\Service;

use SDIS62\Core\Ops\Entity\Centre;
use SDIS62\Core\Ops\Repository\CentreRepositoryInterface;

class CentreService
{
    /**
     * Initialisation du service avec les repository utilisés
     *
     * @param SDIS62\Core\Ops\Repository\CentreRepositoryInterface $centre_repository
     */
    public function __construct(CentreRepositoryInterface $centre_repository)
    {
        $this->centre_repository = $centre_repository;
    }

    /**
     * Retourne un ensemble de CIS
     *
     * @return SDIS62\Core\User\Entity\Centre[]
     */
    public function getAll()
    {
        return $this->centre_repository->getAll();
    }

    /**
     * Retourne un CIS correspondant à l'id spécifié
     *
     * @param  mixed                          $id_centre
     * @return SDIS62\Core\Ops\Entity\Centre
     */
    public function find($id_centre)
    {
        return $this->centre_repository->find($id_centre);
    }

    /**
     * Retourne des CIS correspondant au nom spécifié
     *
     * @param  string                       $name
     * @return SDIS62\Core\Ops\Entity\Centre[]
     */
    public function findAllByName($name)
    {
        return $this->centre_repository->findAllByName($name);
    }

    /**
     * Sauvegarde d'un centre
     *
     * @param  array $data
     * @param  mixed $id_centre Optionnel
     * @return SDIS62\Core\Ops\Entity\Centre
     */
    public function save($data, $id_centre = null)
    {
        $centre = empty($id_centre) ? new Centre($data['name']) : $this->centre_repository->find($id_centre);

        if (!empty($data['name'])) {
            $centre->setName($data['name']);
        }

        $this->centre_repository->save($centre);

        return $centre;
    }

    /**
     * Suppression d'un centre
     *
     * @param  mixed $id_centre
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
