<?php

namespace SDIS62\Core\Ops\Entity;

use SDIS62\Core\Ops\Entity\Garde;
use SDIS62\Core\Ops\Entity\Centre;
use SDIS62\Core\Common\Entity\IdentityTrait;

class Pompier
{
    use IdentityTrait;

    /**
    * Type
    *
    * @var string
    */
    protected $type = 'pompier';

    /**
    * Gardes du pompier
    *
    * @var SDIS62\Core\Ops\Entity\Garde[]
    */
    protected $gardes;

    /**
    * Centre dans lequel le pompier est affecté
    *
    * @var SDIS62\Core\Ops\Entity\Centre
    */
    protected $centre;

    /**
    * Matricule du pompier
    *
    * @var string
    */
    protected $matricule;

    /**
    * Nom du pompier
    *
    * @var string
    */
    protected $name;

    /**
     * Ajout d'un pompier
     *
     * @param string $name
     * @param string $matricule
     * @param SDIS62\Core\Ops\Entity\Centre $centre
     */
    public function __construct($name, $matricule, Centre $centre)
    {
        $this->setName($name);
        $this->setMatricule($matricule);
        $this->setCentre($centre);
    }

    /**
     * Get the value of Gardes du pompier
     *
     * @return SDIS62\Core\Ops\Entity\Garde[]
     */
    public function getGardes()
    {
        return $this->gardes;
    }

    /**
     * Ajoute une garde au pompier
     *
     * @param  SDIS62\Core\Ops\Entity\Garde $garde
     * @return self
     */
    public function addGarde(Garde $garde)
    {
        $this->gardes[] = $garde;

        return $this;
    }

    /**
     * Get the value of Centre dans lequel le pompier est affecté
     *
     * @return SDIS62\Core\Ops\Entity\Centre
     */
    public function getCentre()
    {
        return $this->centre;
    }

    /**
     * Set the value of Centre dans lequel le pompier est affecté
     *
     * @param SDIS62\Core\Ops\Entity\Centre centre
     *
     * @return self
     */
    public function setCentre(Centre $centre)
    {
        if(!empty($this->centre)) {
            $this->centre->getPompiers()->removeElement($this);
        }

        $this->centre = $centre;

        $this->centre->addPompier($this);

        return $this;
    }


    /**
     * Get the value of Matricule du pompier
     *
     * @return string
     */
    public function getMatricule()
    {
        return $this->matricule;
    }

    /**
     * Set the value of Matricule du pompier
     *
     * @param string matricule
     *
     * @return self
     */
    public function setMatricule($matricule)
    {
        $this->matricule = $matricule;

        return $this;
    }

    /**
     * Get the value of Nom du pompier
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of Nom du pompier
     *
     * @param string name
     *
     * @return self
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get the value of Type de pompier
     *
     * @return string
     */
    final public function getType()
    {
        return $this->type;
    }

}
