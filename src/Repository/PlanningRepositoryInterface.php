<?php

namespace SDIS62\Core\Ops\Repository;

use Datetime;
use SDIS62\Core\Ops\Entity\Planning;

interface PlanningRepositoryInterface
{
    /**
     * Retourne un planning à l'id spécifié.
     *
     * @param mixed $id_planning
     *
     * @return SDIS62\Core\Ops\Entity\Planning
     */
    public function find($id_planning);

    /**
     * Retourne le planning entre les dates données.
     *
     * @param mixed    $id_planning
     * @param Datetime $start
     * @param Datetime $end
     *
     * @return SDIS62\Core\User\Entity\Planning
     */
    public function findByPeriod($id_planning, Datetime $start, Datetime $end);

    /**
     * Sauvegarde d'un planning.
     *
     * @param  SDIS62\Core\Ops\Entity\Planning
     */
    public function save(Planning &$planning);

    /**
     * Suppression d'un planning.
     *
     * @param  SDIS62\Core\Ops\Entity\Planning
     */
    public function delete(Planning &$planning);
}
