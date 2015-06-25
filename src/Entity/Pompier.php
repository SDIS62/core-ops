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
     * Inscription dans les plannings du pompier.
     *
     * @var SDIS62\Core\Ops\Entity\PlageHoraire[]
     */
    protected $plages_horaires;

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
     * Etat du pompier.
     *
     * @var SDIS62\Core\Ops\Entity\Statut
     */
    protected $statut;

    /**
     * Profesionnel ?
     *
     * @var bool
     */
    protected $is_pro;

    /**
     * Coordonnées du pompier.
     *
     * @var SDIS62\Core\Ops\Entity\Coordinates
     */
    protected $coordinates;

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
        $this->plages_horaires = new ArrayCollection();
        $this->statut = Statut::DISPONIBLE();
        $this->is_pro = true;
    }

    /**
     * Get the value of Plannings du pompier.
     *
     * @return SDIS62\Core\Ops\Entity\Planning[]
     */
    public function getPlannings()
    {
        $plannings = [];

        foreach($this->plages_horaires as $plage_horaire) {
            if(!in_array($plage_horaire->getPlanning(), $plannings)) {
                $plannings[] = $plage_horaire->getPlanning();
            }
        }

        return $plannings;
    }

    /**
     * Get the value of Plages horaires
     *
     * @return SDIS62\Core\Ops\Entity\PlageHoraire[]
     */
    public function getPlagesHoraires()
    {
        return $this->plages_horaires;
    }

    /**
     * Get the value of Gardes
     *
     * @return SDIS62\Core\Ops\Entity\PlageHoraire\Garde[]
     */
    public function getGardes()
    {
        $gardes = [];

        foreach($this->plages_horaires as $plage_horaire) {
            if($plage_horaire instanceof PlageHoraire\GardePlageHoraire) {
                $gardes[] = $plage_horaire;
            }
        }

        return $gardes;
    }

    /**
     * Get the value of Dispos
     *
     * @return SDIS62\Core\Ops\Entity\PlageHoraire\Dispo[]
     */
    public function getDispos()
    {
        $dispos = [];

        foreach($this->plages_horaires as $plage_horaire) {
            if($plage_horaire instanceof PlageHoraire\DispoPlageHoraire) {
                $dispos[] = $plage_horaire;
            }
        }

        return $dispos;
    }

    /**
     * Ajout d'une plage horaire.
     *
     * @param SDIS62\Core\Ops\Entity\PlageHoraire $plage_horaire
     * @return self
     *
     */
    public function addPlageHoraire(PlageHoraire $plage_horaire)
    {
        $this->plages_horaires->add($plage_horaire);

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

    /**
     * Get the value of Etat du pompier.
     *
     * @return SDIS62\Core\Ops\Entity\Statut
     */
    public function getStatut()
    {
        return $this->statut instanceof Statut ? $this->statut : Statut::get($this->statut);
    }

    /**
     * Set the value of Etat du pompier.
     *
     * @param SDIS62\Core\Ops\Entity\Statut statut
     *
     * @return self
     */
    public function setStatut(Statut $statut)
    {
        $this->statut = $statut;

        return $this;
    }

    /**
     * Get the value of Pro ou volontaire ?
     *
     * @return bool
     */
    public function isPro()
    {
        return $this->is_pro == true;
    }

    /**
     * Set the value of Pro ou volontaire ?
     *
     * @param bool is_pro
     *
     * @return self
     */
    public function setPro($value = true)
    {
        $this->is_pro = $value == true;

        return $this;
    }

    /**
     * Get the value of Coordonnées du pompier.
     *
     * @return SDIS62\Core\Ops\Entity\Coordinates
     */
    public function getCoordinates()
    {
        return $this->coordinates;
    }

    /**
     * Set the value of Coordonnées du pompier.
     *
     * @param SDIS62\Core\Ops\Entity\Coordinates $coordinates
     *
     * @return self
     */
    public function setCoordinates(Coordinates $coordinates)
    {
        $this->coordinates = $coordinates;

        return $this;
    }

}
