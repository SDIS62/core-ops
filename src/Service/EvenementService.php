<?php

namespace SDIS62\Core\Ops\Service;

use SDIS62\Core\Ops\Entity\Evenement;
use SDIS62\Core\Ops\Repository\EvenementRepositoryInterface;
use SDIS62\Core\Ops\Repository\EngagementRepositoryInterface;
use SDIS62\Core\Ops\Repository\InterventionRepositoryInterface;

class EvenementService
{
    /**
     * Initialisation du service avec les repository utilisés
     *
     * @param SDIS62\Core\Ops\Repository\EvenementRepositoryInterface    $evenement_repository
     * @param SDIS62\Core\Ops\Repository\InterventionRepositoryInterface $intervention_repository
     */
    public function __construct(EvenementRepositoryInterface $evenement_repository,
                                InterventionRepositoryInterface $intervention_repository,
                                EngagementRepositoryInterface $engagement_repository
    ) {
        $this->evenement_repository = $evenement_repository;
        $this->intervention_repository = $intervention_repository;
        $this->engagement_repository = $engagement_repository;
    }

    /**
     * Retourne un évenement
     *
     * @param  mixed                            $id_evenement
     * @return SDIS62\Core\Ops\Entity\Evenement
     */
    public function find($id_evenement)
    {
        return $this->evenement_repository->find($id_evenement);
    }

    /**
     * Création d'un evenement sur une intervention
     *
     * @param  string                           $type
     * @param  array                            $data
     * @return SDIS62\Core\Ops\Entity\Evenement
     */
    public function create($type, $data)
    {
        $evenement = new Evenement($data['description'], array_key_exists('date', $data) ? $data['date'] : null);

        switch ($type) {
            case 'intervention':
                $object = $this->intervention_repository->find($data['intervention']);
                break;
            case 'engagement':
                $object = $this->engagement_repository->find($data['engagement']);
                break;
        }

        if (empty($object)) {
            return;
        }

        $object->addEvenement($evenement);

        $this->evenement_repository->save($evenement);

        return $evenement;
    }

    /**
     * Suppression d'un evenement
     *
     * @param  mixed                            $id_evenement
     * @return SDIS62\Core\Ops\Entity\Evenement
     */
    public function delete($id_evenement)
    {
        $evenement = $this->find($id_evenement);

        if (empty($evenement)) {
            return;
        }

        $this->evenement_repository->delete($evenement);

        return $evenement;
    }
}
