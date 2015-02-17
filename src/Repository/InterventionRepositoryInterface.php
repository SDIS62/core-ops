<?php

namespace SDIS62\Core\Ops\Repository;

use SDIS62\Core\Ops\Entity\Intervention;

interface InterventionRepositoryInterface
{
    /**
     * Retourne une intervention correspondant à l'id spécifié
     *
     * @param  mixed                          $id_intervention
     * @return SDIS62\Core\Ops\Entity\Intervention
     */
    public function find($id_intervention);

    /**
     * Retourne une intervention correspondant à l'état spécifié
     *
     * @param  string                       $etat
     * @return SDIS62\Core\Ops\Entity\Intervention[]
     */
    public function findAllByEtat($etat);

    /**
     * Sauvegarde d'une intervention
     *
     * @param  SDIS62\Core\Ops\Entity\Intervention
     */
    public function save(Intervention & $intervention);

    /**
     * Suppression d'une intervention
     *
     * @param  SDIS62\Core\Ops\Entity\Intervention
     */
    public function delete(Intervention & $intervention);
}