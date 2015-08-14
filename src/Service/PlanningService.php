<?php

namespace SDIS62\Core\Ops\Service;

use Datetime;
use SDIS62\Core\Ops\Entity\Planning;
use SDIS62\Core\Ops\Repository\PlanningRepositoryInterface;

class PlanningService
{
    /**
     * Initialisation du service avec les repository utilisés.
     *
     * @param SDIS62\Core\Ops\Repository\PlanningRepositoryInterface $planning_repository
     */
    public function __construct(PlanningRepositoryInterface $planning_repository)
    {
        $this->planning_repository = $planning_repository;
    }

    /**
     * Retourne un planning à l'id spécifié.
     *
     * @param mixed $id_planning
     *
     * @return SDIS62\Core\Ops\Entity\Planning
     */
    public function find($id_planning)
    {
        return $this->planning_repository->find($id_planning);
    }

    /**
     * Retourne le planning entre les dates données.
     *
     * @param mixed    $id_planning
     * @param Datetime $start
     * @param Datetime $end
     *
     * @return SDIS62\Core\User\Entity\Planning
     */
    public function findByPeriod($id_planning, Datetime $start, Datetime $end)
    {
        return $this->planning_repository->findByPeriod($id_planning, $start, $end);
    }

    /**
     * Sauvegarde du planning.
     *
     * @param array $data
     * @param array $id_planning
     *
     * @return SDIS62\Core\Ops\Entity\Planning
     */
    public function save($data, $id_planning = null)
    {
        $planning = empty($id_planning) ? new Planning($data['name']) : $this->planning_repository->find($id_planning);

        if (!empty($data['name'])) {
            $planning->setName($data['name']);
        }

        $this->planning_repository->save($planning);

        return $planning;
    }

    /**
     * Suppression d'un planning.
     *
     * @param mixed $id_planning
     *
     * @return SDIS62\Core\Ops\Entity\Planning
     */
    public function delete($id_planning)
    {
        $planning = $this->find($id_planning);

        if (empty($planning)) {
            return;
        }

        $this->planning_repository->delete($planning);

        return $planning;
    }
}
