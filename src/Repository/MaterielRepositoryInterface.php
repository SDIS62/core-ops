<?php

namespace SDIS62\Core\Ops\Repository;

use SDIS62\Core\Ops\Entity\Materiel;

interface MaterielRepositoryInterface
{
    /**
     * Retourne un matériel correspondant à l'id spécifié
     *
     * @param  mixed                          $id_materiel
     * @return SDIS62\Core\Ops\Entity\Materiel
     */
    public function find($id_materiel);

    /**
     * Sauvegarde d'un matériel
     *
     * @param  SDIS62\Core\Ops\Entity\Materiel
     */
    public function save(Materiel & $materiel);

    /**
     * Suppression d'une matériel
     *
     * @param  SDIS62\Core\Ops\Entity\Materiel
     */
    public function delete(Materiel & $materiel);
}
