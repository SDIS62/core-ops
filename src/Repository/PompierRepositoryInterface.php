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
     * @param  int                               $count Par défaut: 20
     * @param  int                               $page  Par défaut: 1
     * @return SDIS62\Core\Ops\Entity\Pompier
     */
    public function findAllByName($name, $count = 20, $page = 1);

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
