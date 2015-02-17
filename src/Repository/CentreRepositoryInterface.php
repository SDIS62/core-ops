<?php

namespace SDIS62\Core\Ops\Repository;

use SDIS62\Core\Ops\Entity\Centre;

interface CentreRepositoryInterface
{
    /**
     * Retourne un ensemble de CIS
     *
     * @return SDIS62\Core\User\Entity\Centre[]
     */
    public function getAll();

    /**
     * Retourne un CIS correspondant à l'id spécifié
     *
     * @param  mixed                          $id_centre
     * @return SDIS62\Core\Ops\Entity\Centre
     */
    public function find($id_centre);

    /**
     * Retourne des CIS correspondant au nom spécifié
     *
     * @param  string                       $name
     * @return SDIS62\Core\Ops\Entity\Centre[]
     */
    public function findAllByName($name);

    /**
     * Sauvegarde d'un centre
     *
     * @param  SDIS62\Core\Ops\Entity\Centre
     */
    public function save(Centre & $centre);

    /**
     * Suppression d'un centre
     *
     * @param  SDIS62\Core\Ops\Entity\Centre
     */
    public function delete(Centre & $centre);
}
