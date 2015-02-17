<?php

namespace SDIS62\Core\Ops\Repository;

use SDIS62\Core\Ops\Entity\Evenement;

interface EvenementRepositoryInterface
{
    /**
     * Retourne un évenement
     *
     * @param  mixed                            $id_evenement
     * @return SDIS62\Core\Ops\Entity\Evenement
     */
    public function find($id_evenement);

    /**
     * Sauvegarde d'un évenement
     *
     * @param  SDIS62\Core\Ops\Entity\Evenement
     */
    public function save(Evenement & $evenement);

    /**
     * Suppression d'un évenement
     *
     * @param  SDIS62\Core\Ops\Entity\Evenement
     */
    public function delete(Evenement & $evenement);
}
