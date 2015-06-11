<?php

namespace SDIS62\Core\Ops\Repository;

use SDIS62\Core\Ops\Entity\Materiel;

interface MaterielRepositoryInterface
{
    /**
     * Retourne un matériel correspondant à l'id spécifié.
     *
     * @param mixed $id_materiel
     *
     * @return SDIS62\Core\Ops\Entity\Materiel
     */
    public function find($id_materiel);

    /**
     * Retourne les matériels se trouvant dans un rayon de 500m (par défaut) des coordonnées.
     *
     * @param float $lat
     * @param float $lon
     * @param int $distance
     *
     * @return SDIS62\Core\Ops\Entity\Materiel[]
     */
    public function findAllByDistance($lat, $lon, $distance = 500);

    /**
     * Sauvegarde d'un matériel.
     *
     * @param  SDIS62\Core\Ops\Entity\Materiel
     */
    public function save(Materiel &$materiel);

    /**
     * Suppression d'une matériel.
     *
     * @param  SDIS62\Core\Ops\Entity\Materiel
     */
    public function delete(Materiel &$materiel);
}
