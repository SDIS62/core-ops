<?php

namespace SDIS62\Core\Ops\Service;

use SDIS62\Core\Ops\Entity\Pompier;
use SDIS62\Core\Ops\Exception\InvalidPompierException;
use SDIS62\Core\Ops\Repository\CentreRepositoryInterface;
use SDIS62\Core\Ops\Repository\PompierRepositoryInterface;

class PompierService
{
    /**
     * Initialisation du service avec les repository utilisés
     *
     * @param SDIS62\Core\Ops\Repository\PompierRepositoryInterface $pompier_repository
     * @param SDIS62\Core\Ops\Repository\CentreRepositoryInterface  $centre_repository
     */
    public function __construct(PompierRepositoryInterface $pompier_repository,
                                CentreRepositoryInterface $centre_repository
    ) {
        $this->pompier_repository = $pompier_repository;
        $this->centre_repository = $centre_repository;
    }

    /**
     * Retourne un pompier correspondant à l'id spécifié
     *
     * @param  mixed                          $id_pompier
     * @return SDIS62\Core\Ops\Entity\Pompier
     */
    public function find($id_pompier)
    {
        return $this->pompier_repository->find($id_pompier);
    }

    /**
     * Retourne un pompier correspondant au nom spécifié
     *
     * @param  string                         $name
     * @param  int                            $count Par défaut: 20
     * @param  int                            $page  Par défaut: 1
     * @return SDIS62\Core\Ops\Entity\Pompier
     */
    public function findAllByName($name, $count = 20, $page = 1)
    {
        return $this->pompier_repository->findAllByName($name, $count, $page);
    }

    /**
     * Sauvegarde d'un pompier
     *
     * @param  array                          $data
     * @param  array                          $id_pompier Optionnel
     * @return SDIS62\Core\Ops\Entity\Pompier
     */
    public function save($data, $id_pompier = null)
    {
        $centre = $this->centre_repository->find($data['centre']);

        if (empty($centre)) {
            return;
        }

        if (empty($id_pompier)) {
            switch ($data['type']) {
                case 'pompier' :
                    $pompier = new Pompier($data['name'], $data['matricule'], $centre);
                    break;
                case 'specialiste' :
                    $pompier = new Pompier\SpecialistePompier($data['name'], $data['matricule'], $centre);
                    break;
                default:
                    throw new InvalidPompierException();
            }
        } else {
            $pompier = $this->pompier_repository->find($id_pompier);
        }

        if (!empty($data['centre'])) {
            $pompier->setCentre($centre);
        }

        if (!empty($data['matricule'])) {
            $pompier->setMatricule($data['matricule']);
        }
        if (!empty($data['name'])) {
            $pompier->setName($data['name']);
        }

        if (!empty($data['specialites'])) {
            $pompier->setSpecialites($data['specialites']);
        }

        $this->pompier_repository->save($pompier);

        return $pompier;
    }

    /**
     * Suppression d'un pompier
     *
     * @param  mixed                          $id_pompier
     * @return SDIS62\Core\Ops\Entity\Pompier
     */
    public function delete($id_pompier)
    {
        $pompier = $this->find($id_pompier);

        if (empty($pompier)) {
            return;
        }

        $this->pompier_repository->delete($pompier);

        return $pompier;
    }
}
