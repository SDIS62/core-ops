<?php

namespace SDIS62\Core\Ops\Repository;

use SDIS62\Core\Ops\Entity\Engagement;

interface EngagementRepositoryInterface
{
    /**
     * Retourne un engagement correspondant à l'id spécifié.
     *
     * @param mixed $id_engagement
     *
     * @return SDIS62\Core\Ops\Entity\Engagement
     */
    public function find($id_engagement);

    /**
     * Retourne les engagements se trouvant dans un rayon de 500m (par défaut) des coordonnées.
     *
     * @param float $lat
     * @param float $lon
     * @param int   $distance
     *
     * @return SDIS62\Core\Ops\Entity\Engagement[]
     */
    public function findAllByDistance($lat, $lon, $distance = 500);

    /**
     * Sauvegarde d'un engagement.
     *
     * @param  SDIS62\Core\Ops\Entity\Engagement
     */
    public function save(Engagement &$engagement);

    /**
     * Suppression d'un engagement.
     *
     * @param  SDIS62\Core\Ops\Entity\Engagement
     */
    public function delete(Engagement &$engagement);
}
