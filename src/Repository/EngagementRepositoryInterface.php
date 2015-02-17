<?php

namespace SDIS62\Core\Ops\Repository;

use SDIS62\Core\Ops\Entity\Engagement;

interface EngagementRepositoryInterface
{
    /**
     * Retourne un engagement correspondant à l'id spécifié
     *
     * @param  mixed                          $id_engagement
     * @return SDIS62\Core\Ops\Entity\Engagement
     */
    public function find($id_engagement);

    /**
     * Sauvegarde d'un engagement
     *
     * @param  SDIS62\Core\Ops\Entity\Engagement
     */
    public function save(Engagement & $engagement);

    /**
     * Suppression d'un engagement
     *
     * @param  SDIS62\Core\Ops\Entity\Engagement
     */
    public function delete(Engagement & $engagement);
}
