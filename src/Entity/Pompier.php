<?php

namespace SDIS62\Core\Ops\Entity;

use libphonenumber\PhoneNumberUtil;
use libphonenumber\PhoneNumberFormat;
use Doctrine\Common\Collections\ArrayCollection;
use SDIS62\Core\Ops\Entity\Engagement\PompierEngagement;
use SDIS62\Core\Ops\Exception\InvalidPhoneNumberException;

class Pompier
{
    /**
     * Type.
     *
     * @var string
     */
    protected $type = 'pompier';

    /**
     * Gardes du pompier.
     *
     * @var SDIS62\Core\Ops\Entity\Garde[]
     */
    protected $gardes;

    /**
     * Disponibilités du pompier.
     *
     * @var SDIS62\Core\Ops\Entity\Dispo[]
     */
    protected $dispos;

    /**
     * Centre dans lequel le pompier est affecté.
     *
     * @var SDIS62\Core\Ops\Entity\Centre
     */
    protected $centre;

    /**
     * Matricule du pompier.
     *
     * @var string
     */
    protected $matricule;

    /**
     * Engagement du pompier.
     *
     * @var SDIS62\Core\Ops\Entity\Engagement\PompierEngagement[]
     */
    protected $engagements;

    /**
     * Grade.
     *
     * @var string
     */
    protected $grade;

    /**
     * Nom du pompier.
     *
     * @var string
     */
    protected $name;

    /**
     * Numéro de téléphone.
     *
     * @var string
     */
    protected $phone_number;

    /**
     * Ajout d'un pompier.
     *
     * @param string                        $name
     * @param string                        $matricule
     * @param SDIS62\Core\Ops\Entity\Centre $centre
     */
    public function __construct($name, $matricule, Centre $centre)
    {
        $this->matricule = $matricule;
        $this->setName($name);
        $this->setCentre($centre);
        $this->engagements = new ArrayCollection();
        $this->gardes      = new ArrayCollection();
        $this->dispos      = new ArrayCollection();
    }

    /**
     * Get the value of Gardes du pompier.
     *
     * @return SDIS62\Core\Ops\Entity\Garde[]
     */
    public function getGardes()
    {
        return $this->gardes;
    }

    /**
     * Ajoute une garde au pompier.
     *
     * @param SDIS62\Core\Ops\Entity\Garde $garde
     *
     * @return self
     */
    public function addGarde(Garde $garde)
    {
        $this->gardes[] = $garde;

        return $this;
    }

    /**
     * Get the value of Dispos du pompier.
     *
     * @return SDIS62\Core\Ops\Entity\Dispo[]
     */
    public function getDispos()
    {
        return $this->dispos;
    }

    /**
     * Ajoute une dispo au pompier.
     *
     * @param SDIS62\Core\Ops\Entity\Dispo $dispo
     *
     * @return self
     */
    public function addDispo(Dispo $dispo)
    {
        $this->dispos[] = $dispo;

        return $this;
    }

    /**
     * Get the value of Centre dans lequel le pompier est affecté.
     *
     * @return SDIS62\Core\Ops\Entity\Centre
     */
    public function getCentre()
    {
        return $this->centre;
    }

    /**
     * Set the value of Centre dans lequel le pompier est affecté.
     *
     * @param SDIS62\Core\Ops\Entity\Centre centre
     *
     * @return self
     */
    public function setCentre(Centre $centre)
    {
        if (!empty($this->centre)) {
            $this->centre->getPompiers()->removeElement($this);
        }

        $this->centre = $centre;

        $this->centre->addPompier($this);

        return $this;
    }

    /**
     * Get the value of Matricule du pompier.
     *
     * @return string
     */
    public function getMatricule()
    {
        return $this->matricule;
    }

    /**
     * Get the value of Nom du pompier.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of Nom du pompier.
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
     * Get the value of Grade du pompier.
     *
     * @return string
     */
    public function getGrade()
    {
        return $this->grade;
    }

    /**
     * Set the value of Grade du pompier.
     *
     * @param string grade
     *
     * @return self
     */
    public function setGrade($grade)
    {
        $this->grade = $grade;

        return $this;
    }

    /**
     * Get the value of Liste des engagements du pompier.
     *
     * @return SDIS62\Core\Ops\Entity\Engagement\PompierEngagement[]
     */
    public function getEngagements()
    {
        return $this->engagements;
    }

    /**
     * Ajoute un engagement au pompier.
     *
     * @param SDIS62\Core\Ops\Entity\Engagement\PompierEngagement $engagement
     *
     * @return self
     */
    public function addEngagement(PompierEngagement $engagement)
    {
        $this->engagements[] = $engagement;

        return $this;
    }

    /**
     * Le matériel est il actuellement engagé ?
     *
     * @return bool
     */
    public function isEngage()
    {
        foreach ($this->engagements as $engagement) {
            if (!$engagement->isEnded()) {
                return true;
            }
        }

        return false;
    }

    /**
     * Get the value of Type de pompier.
     *
     * @return string
     */
    final public function getType()
    {
        return $this->type;
    }

    /**
     * Get the value of Numéro de téléphone.
     *
     * @return string
     */
    public function getPhoneNumber()
    {
        return $this->phone_number;
    }

    /**
     * Set the value of Numéro de téléphone.
     *
     * @param string|null $phone_number
     *
     * @throws InvalidPhoneNumberException
     *
     * @return self
     */
    public function setPhoneNumber($phone_number)
    {
        $phone_util          = PhoneNumberUtil::getInstance();
        $phone_number_parsed = $phone_util->parse($phone_number, 'FR');
        if (!$phone_util->isValidNumber($phone_number_parsed)) {
            throw new InvalidPhoneNumberException('Format du numéro de téléphone professionnel incorrect.');
        }
        $this->phone_number = $phone_util->format($phone_number_parsed, PhoneNumberFormat::NATIONAL);

        return $this;
    }
}
