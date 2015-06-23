<?php

namespace SDIS62\Core\Ops\Service;

use SDIS62\Core\Ops\Entity\Statut;
use SDIS62\Core\Ops\Entity\Materiel;
use SDIS62\Core\Ops\Entity\Coordinates;
use SDIS62\Core\Ops\Repository\CentreRepositoryInterface;
use SDIS62\Core\Ops\Repository\MaterielRepositoryInterface;

class MaterielService
{
    /**
     * Initialisation du service avec les repository utilisés.
     *
     * @param SDIS62\Core\Ops\Repository\MaterielRepositoryInterface $materiel_repository
     * @param SDIS62\Core\Ops\Repository\CentreRepositoryInterface   $centre_repository
     */
    public function __construct(MaterielRepositoryInterface $materiel_repository,
                                CentreRepositoryInterface $centre_repository
    ) {
        $this->materiel_repository = $materiel_repository;
        $this->centre_repository   = $centre_repository;
    }

    /**
     * Retourne un matériel correspondant à l'id spécifié.
     *
     * @param mixed $id_materiel
     *
     * @return SDIS62\Core\Ops\Entity\Materiel
     */
    public function find($id_materiel)
    {
        return $this->materiel_repository->find($id_materiel);
    }

    /**
     * Sauvegarde d'un matériel.
     *
     * @param array $data
     * @param array $id_materiel Optionnel
     *
     * @return SDIS62\Core\Ops\Entity\Centre
     */
    public function save($data, $id_materiel = null)
    {
        $centre = $this->centre_repository->find($data['centre']);

        if (empty($centre)) {
            return;
        }

        $materiel = empty($id_materiel) ? new Materiel($centre, $data['name']) : $this->materiel_repository->find($id_materiel);

        if (!empty($data['name'])) {
            $materiel->setName($data['name']);
        }

        if (array_key_exists('actif', $data)) {
            $materiel->setActif($data['actif'] === true);
        }

        if (!empty($data['centre'])) {
            $materiel->setCentre($centre);
        }

        if (!empty($data['statut'])) {
            $materiel->setStatut(Statut::getByName($data['statut']));
        }

        if (!empty($data['coordinates']) && is_array($data['coordinates']) && count($data['coordinates']) == 2) {
            $materiel->setCoordinates(new Coordinates($data['coordinates'][0], $data['coordinates'][1]));
        }

        $this->materiel_repository->save($materiel);

        return $materiel;
    }

    /**
     * Suppression d'un matériel.
     *
     * @param mixed $id_materiel
     *
     * @return SDIS62\Core\Ops\Entity\Materiel
     */
    public function delete($id_materiel)
    {
        $materiel = $this->find($id_materiel);

        if (empty($materiel)) {
            return;
        }

        $this->materiel_repository->delete($materiel);

        return $materiel;
    }
}
