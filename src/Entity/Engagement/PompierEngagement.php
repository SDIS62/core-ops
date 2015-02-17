<?php

namespace SDIS62\Core\Ops\Entity\Engagement;

use SDIS62\Core\Ops\Entity\Pompier;
use SDIS62\Core\Ops\Entity\Materiel;
use SDIS62\Core\Ops\Entity\Engagement;
use SDIS62\Core\Ops\Entity\Intervention;

class PompierEngagement extends Engagement
{
    /**
     * Type
     *
     * @var string
     */
    protected $type = 'pompier';

    /**
     * Pompier associé
     *
     * @var SDIS62\Core\Ops\Entity\Pompier
     */
    protected $pompier;

    /**
     * Matériel engagé
     *
     * @var SDIS62\Core\Ops\Entity\Materiel
     */
    protected $materiel;

    /**
     * Ajout d'un engagement de type pompier à une intervention
     *
     * @param SDIS62\Core\Ops\Entity\Intervention $intervention
     * @param SDIS62\Core\Ops\Entity\Materiel     $materiel
     * @param SDIS62\Core\Ops\Entity\Pompier      $pompier
     */
    public function __construct(Intervention $intervention, Materiel $materiel, Pompier $pompier)
    {
        $this->pompier = $pompier;
        $this->pompier->addEngagement($this);

        $this->materiel = $materiel;
        $this->materiel->addEngagement($this);

        parent::__construct($intervention, $materiel);
    }

    /**
     * Get the value of Pompier associé
     *
     * @return SDIS62\Core\Ops\Entity\Pompier
     */
    public function getPompier()
    {
        return $this->pompier;
    }

    /**
     * Get the value of Matériel engagé
     *
     * @return SDIS62\Core\Ops\Entity\Materiel
     */
    public function getMateriel()
    {
        return $this->materiel;
    }
}
