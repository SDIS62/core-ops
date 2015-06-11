<?php

namespace SDIS62\Core\Ops\Repository;

use SDIS62\Core\Ops\Entity\Commune;

interface CommuneRepositoryInterface
{
    /**
     * Retourne l'ensemble des communes.
     *
     * @param int $count Par défaut: 20
     * @param int $page  Par défaut: 1
     *
     * @return SDIS62\Core\User\Entity\Commune[]
     */
    public function getAll($count = 20, $page = 1);

    /**
     * Retourne une commune correspondant au numéro insee spécifié.
     *
     * @param string $numinsee
     *
     * @return SDIS62\Core\Ops\Entity\Commune
     */
    public function find($numinsee);

    /**
     * Sauvegarde d'une commune.
     *
     * @param  SDIS62\Core\Ops\Entity\Commune
     */
    public function save(Commune &$commune);

    /**
     * Suppression d'une commune.
     *
     * @param  SDIS62\Core\Ops\Entity\Commune
     */
    public function delete(Commune &$commune);
}
