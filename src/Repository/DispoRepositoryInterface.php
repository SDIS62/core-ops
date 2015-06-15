<?php

namespace SDIS62\Core\Ops\Repository;

use SDIS62\Core\Ops\Entity\Dispo;

interface DispoRepositoryInterface
{
    /**
     * Retourne une dispo correspondant à l'id spécifié.
     *
     * @param mixed $id_dispo
     *
     * @return SDIS62\Core\Ops\Entity\Dispo
     */
    public function find($id_dispo);

    /**
     * Sauvegarde d'une dispo.
     *
     * @param  SDIS62\Core\Ops\Entity\Dispo
     */
    public function save(Dispo &$dispo);

    /**
     * Suppression d'une dispo.
     *
     * @param  SDIS62\Core\Ops\Entity\Dispo
     */
    public function delete(Dispo &$dispo);
}
