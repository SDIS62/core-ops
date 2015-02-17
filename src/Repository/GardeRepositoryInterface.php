<?php

namespace SDIS62\Core\Ops\Repository;

use SDIS62\Core\Ops\Entity\Garde;

interface GardeRepositoryInterface
{
    /**
     * Retourne un ensemble de gardes sur un mois
     *
     * @param  int                             $month
     * @return SDIS62\Core\User\Entity\Garde[]
     */
    public function findAllByMonth($month);

    /**
     * Retourne une garde correspondant à l'id spécifié
     *
     * @param  mixed                        $id_garde
     * @return SDIS62\Core\Ops\Entity\Garde
     */
    public function find($id_garde);

    /**
     * Sauvegarde d'une garde
     *
     * @param  SDIS62\Core\Ops\Entity\Garde
     */
    public function save(Garde & $garde);

    /**
     * Suppression d'une garde
     *
     * @param  SDIS62\Core\Ops\Entity\Garde
     */
    public function delete(Garde & $garde);
}
