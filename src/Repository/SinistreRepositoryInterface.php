<?php

namespace SDIS62\Core\Ops\Repository;

use SDIS62\Core\Ops\Entity\Sinistre;

interface SinistreRepositoryInterface
{
    /**
     * Retourne un ensemble de sinistre
     *
     * @return SDIS62\Core\User\Entity\Sinistre[]
     */
    public function getAll();

    /**
     * Retourne un sinistre correspondant à l'id spécifié
     *
     * @param  mixed                          $id_sinistre
     * @return SDIS62\Core\Ops\Entity\Sinistre
     */
    public function find($id_sinistre);

    /**
     * Sauvegarde d'un sinistre
     *
     * @param  SDIS62\Core\Ops\Entity\Sinistre
     */
    public function save(Sinistre & $sinistre);

    /**
     * Suppression d'un sinistre
     *
     * @param  SDIS62\Core\Ops\Entity\Sinistre
     */
    public function delete(Sinistre & $sinistre);
}
