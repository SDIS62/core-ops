<?php

namespace SDIS62\Core\Ops\Repository;

use SDIS62\Core\Ops\Entity\Intervention;

interface InterventionRepositoryInterface
{
    /**
     * Retourne les interventions.
     *
     * @param int $count Par défaut: 20
     * @param int $page  Par défaut: 1
     *
     * @return SDIS62\Core\Ops\Entity\Intervention[]
     */
    public function getAll($count = 20, $page = 1);

    /**
     * Retourne une intervention correspondant à l'id spécifié.
     *
     * @param mixed $id_intervention
     *
     * @return SDIS62\Core\Ops\Entity\Intervention
     */
    public function find($id_intervention);

    /**
     * Retourne les interventions se trouvant dans un rayon de 500m (par défaut) des coordonnées.
     *
     * @param float $lat
     * @param float $lon
     * @param int $distance
     *
     * @return SDIS62\Core\Ops\Entity\Intervention[]
     */
    public function findAllByDistance($lat, $lon, $distance = 500);

    /**
     * Sauvegarde d'une intervention.
     *
     * @param  SDIS62\Core\Ops\Entity\Intervention
     */
    public function save(Intervention &$intervention);

    /**
     * Suppression d'une intervention.
     *
     * @param  SDIS62\Core\Ops\Entity\Intervention
     */
    public function delete(Intervention &$intervention);
}
