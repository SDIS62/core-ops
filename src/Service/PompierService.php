<?php

namespace SDIS62\Core\Ops\Service;

use SDIS62\Core\Ops\Entity\Coordinates;
use SDIS62\Core\Ops\Entity\Pompier;
use SDIS62\Core\Ops\Entity\Statut;
use SDIS62\Core\Ops\Exception\InvalidPompierException;
use SDIS62\Core\Ops\Repository\CentreRepositoryInterface;
use SDIS62\Core\Ops\Repository\PompierRepositoryInterface;

class PompierService
{
    /**
     * Initialisation du service avec les repository utilisés.
     *
     * @param SDIS62\Core\Ops\Repository\PompierRepositoryInterface $pompier_repository
     * @param SDIS62\Core\Ops\Repository\CentreRepositoryInterface  $centre_repository
     */
    public function __construct(PompierRepositoryInterface $pompier_repository,
                                CentreRepositoryInterface $centre_repository
    ) {
        $this->pompier_repository = $pompier_repository;
        $this->centre_repository  = $centre_repository;
    }

    /**
     * Retourne un pompier correspondant au matricule spécifié.
     *
     * @param string $matricule
     *
     * @return SDIS62\Core\Ops\Entity\Pompier
     */
    public function find($matricule)
    {
        return $this->pompier_repository->find($matricule);
    }

    /**
     * Retourne un pompier correspondant au nom spécifié.
     *
     * @param string $name
     * @param int    $count Par défaut: 20
     * @param int    $page  Par défaut: 1
     *
     * @return SDIS62\Core\Ops\Entity\Pompier
     */
    public function findAllByName($name, $count = 20, $page = 1)
    {
        return $this->pompier_repository->findAllByName($name, $count, $page);
    }

    /**
     * Sauvegarde d'un pompier.
     *
     * @param array $data
     * @param array $id_pompier Optionnel
     *
     * @return SDIS62\Core\Ops\Entity\Pompier
     */
    public function save($data)
    {
        if (!empty($data['matricule'])) {
            $pompier = $this->pompier_repository->find($data['matricule']);
        }

        if (empty($pompier)) {
            $centre = $this->centre_repository->find($data['centre']);

            if (empty($centre)) {
                return;
            }

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
        }

        if (!empty($data['centre'])) {
            $pompier->setCentre($this->centre_repository->find($data['centre']));
        }

        if (!empty($data['name'])) {
            $pompier->setName($data['name']);
        }

        if (!empty($data['specialites'])) {
            $pompier->setSpecialites($data['specialites']);
        }

        if (!empty($data['phone_number'])) {
            $pompier->setPhoneNumber($data['phone_number']);
        }

        if (!empty($data['statut'])) {
            $pompier->setStatut(Statut::getByName($data['statut']));
        }

        if (array_key_exists('pro', $data)) {
            $pompier->setPro($data['pro'] === true);
        }

        if (!empty($data['coordinates']) && is_array($data['coordinates']) && count($data['coordinates']) >= 2) {
            $pompier->setCoordinates(new Coordinates(
                $data['coordinates'][0],
                $data['coordinates'][1],
                array_key_exists(2, $data['coordinates']) ? $data['coordinates'][2] : null
            ));
        }

        $this->pompier_repository->save($pompier);

        return $pompier;
    }

    /**
     * Suppression d'un pompier.
     *
     * @param string $matricule
     *
     * @return SDIS62\Core\Ops\Entity\Pompier
     */
    public function delete($matricule)
    {
        $pompier = $this->find($matricule);

        if (empty($pompier)) {
            return;
        }

        $this->pompier_repository->delete($pompier);

        return $pompier;
    }
}
