<?php

namespace SDIS62\Core\Ops\Service;

use SDIS62\Core\Ops\Entity\Engagement;
use SDIS62\Core\Ops\Exception\InvalidEngagementException;
use SDIS62\Core\Ops\Repository\PompierRepositoryInterface;
use SDIS62\Core\Ops\Repository\MaterielRepositoryInterface;
use SDIS62\Core\Ops\Repository\EngagementRepositoryInterface;
use SDIS62\Core\Ops\Repository\InterventionRepositoryInterface;

class EngagementService
{
    /**
     * Initialisation du service avec les repository utilisés.
     *
     * @param SDIS62\Core\Ops\Repository\EngagementRepositoryInterface   $engagement_repository
     * @param SDIS62\Core\Ops\Repository\MaterielRepositoryInterface     $intervention_repository
     * @param SDIS62\Core\Ops\Repository\InterventionRepositoryInterface $intervention_repository
     * @param SDIS62\Core\Ops\Repository\PompierRepositoryInterface      $pompier_repository
     */
    public function __construct(EngagementRepositoryInterface $engagement_repository,
                                MaterielRepositoryInterface $materiel_repository,
                                InterventionRepositoryInterface $intervention_repository,
                                PompierRepositoryInterface $pompier_repository
    ) {
        $this->engagement_repository   = $engagement_repository;
        $this->materiel_repository     = $materiel_repository;
        $this->intervention_repository = $intervention_repository;
        $this->pompier_repository      = $pompier_repository;
    }

    /**
     * Retourne un engagement correspondant à l'id spécifié.
     *
     * @param mixed $id_engagement
     *
     * @return SDIS62\Core\Ops\Entity\Engagement
     */
    public function find($id_engagement)
    {
        return $this->engagement_repository->find($id_engagement);
    }

    /**
     * Retourne les engagements se trouvant dans un rayon de 500m (par défaut) des coordonnées.
     *
     * @param float $lat
     * @param float $lon
     * @param int   $distance
     *
     * @return SDIS62\Core\Ops\Entity\Engagement[]
     */
    public function findAllByDistance($lat, $lon, $distance = 500)
    {
        return $this->engagement_repository->findAllByDistance($lat, $lon, $distance);
    }

    /**
     * Sauvegarde d'un engagement.
     *
     * @param array $data
     * @param array $id_engagement Optionnel
     *
     * @return SDIS62\Core\Ops\Entity\Engagement
     */
    public function save($data, $id_engagement = null)
    {
        if (empty($id_engagement)) {
            $intervention = $this->intervention_repository->find($data['intervention']);

            switch ($data['type']) {
                case 'pompier' :
                    $materiel   = $this->materiel_repository->find($data['materiel']);
                    $pompier    = $this->pompier_repository->find($data['pompier']);
                    $engagement = new Engagement\PompierEngagement($intervention, $materiel, $pompier);
                    break;
                default:
                    throw new InvalidEngagementException();
            }
        } else {
            $engagement = $this->engagement_repository->find($data['id']);
        }

// evenements

        $this->engagement_repository->save($engagement);

        return $engagement;
    }

    /**
     * Suppression d'un engagement.
     *
     * @param mixed $id_engagement
     *
     * @return SDIS62\Core\Ops\Entity\Engagement
     */
    public function delete($id_engagement)
    {
        $engagement = $this->find($id_engagement);

        if (empty($engagement)) {
            return;
        }

        $this->engagement_repository->delete($engagement);

        return $engagement;
    }
}
