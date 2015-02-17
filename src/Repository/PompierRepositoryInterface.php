<?php

namespace SDIS62\Core\Ops\Repository;

use SDIS62\Core\Ops\Entity\Pompier;

interface PompierRepositoryInterface
{
    /**
     * Retourne un pompier correspondant à l'id spécifié
     *
     * @param  mixed                          $id_pompier
     * @return SDIS62\Core\Ops\Entity\Pompier
     */
    public function find($id_pompier);

    /**
     * Retourne un pompier correspondant au nom spécifié
     *
     * @param  string                       $name
     * @return SDIS62\Core\Ops\Entity\Pompier
     */
    public function findAllByName($name);

    /**
     * Sauvegarde d'un pompier
     *
     * @param  SDIS62\Core\Ops\Entity\Pompier
     */
    public function save(Pompier & $pompier);

    /**
     * Suppression d'un pompier
     *
     * @param  SDIS62\Core\Ops\Entity\Pompier
     */
    public function delete(Pompier & $pompier);
}
