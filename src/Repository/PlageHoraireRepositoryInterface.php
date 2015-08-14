<?php

namespace SDIS62\Core\Ops\Repository;

use SDIS62\Core\Ops\Entity\PlageHoraire;

interface PlageHoraireRepositoryInterface
{
    /**
     * Retourne une plage horaire correspondant à l'id spécifié.
     *
     * @param mixed $id_plage_horaire
     *
     * @return SDIS62\Core\Ops\Entity\PlageHoraire
     */
    public function find($id_plage_horaire);

    /**
     * Sauvegarde d'une plage horaire.
     *
     * @param  SDIS62\Core\Ops\Entity\PlageHoraire
     */
    public function save(PlageHoraire &$plage_horaire);

    /**
     * Suppression d'une plage horaire.
     *
     * @param  SDIS62\Core\Ops\Entity\PlageHoraire
     */
    public function delete(PlageHoraire &$plage_horaire);
}
