<?php

namespace SDIS62\Core\Ops\Repository;

use Datetime;
use SDIS62\Core\Ops\Entity\Garde;

interface GardeRepositoryInterface
{
    /**
     * Retourne un ensemble de gardes en cours.
     *
     *
     * @return SDIS62\Core\User\Entity\Garde[]
     */
    public function getAllCurrent();

    /**
     * Retourne un ensemble de gardes sur une période.
     *
     * @param Datetime $start
     * @param Datetime $end
     *
     * @return SDIS62\Core\User\Entity\Garde[]
     */
    public function findByPeriod(Datetime $start, Datetime $end);

    /**
     * Retourne une garde correspondant à l'id spécifié.
     *
     * @param mixed $id_garde
     *
     * @return SDIS62\Core\Ops\Entity\Garde
     */
    public function find($id_garde);

    /**
     * Sauvegarde d'une garde.
     *
     * @param  SDIS62\Core\Ops\Entity\Garde
     */
    public function save(Garde &$garde);

    /**
     * Suppression d'une garde.
     *
     * @param  SDIS62\Core\Ops\Entity\Garde
     */
    public function delete(Garde &$garde);
}
