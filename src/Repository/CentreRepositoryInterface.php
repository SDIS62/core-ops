<?php

namespace SDIS62\Core\Ops\Repository;

use SDIS62\Core\Ops\Entity\Centre;

interface CentreRepositoryInterface
{
    /**
     * Retourne un ensemble de CIS.
     *
     * @param int $count Par défaut: 20
     * @param int $page  Par défaut: 1
     *
     * @return SDIS62\Core\User\Entity\Centre[]
     */
    public function getAll($count = 20, $page = 1);

    /**
     * Retourne un CIS correspondant à l'id spécifié.
     *
     * @param mixed $id_centre
     *
     * @return SDIS62\Core\Ops\Entity\Centre
     */
    public function find($id_centre);

    /**
     * Retourne des CIS correspondant au nom spécifié.
     *
     * @param string $name
     * @param int    $count Par défaut: 20
     * @param int    $page  Par défaut: 1
     *
     * @return SDIS62\Core\Ops\Entity\Centre[]
     */
    public function findAllByName($name, $count = 20, $page = 1);

    /**
     * Sauvegarde d'un centre.
     *
     * @param  SDIS62\Core\Ops\Entity\Centre
     */
    public function save(Centre & $centre);

    /**
     * Suppression d'un centre.
     *
     * @param  SDIS62\Core\Ops\Entity\Centre
     */
    public function delete(Centre & $centre);
}
