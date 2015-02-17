<?php

namespace SDIS62\Core\Ops\Entity;

use Datetime;
use SDIS62\Core\Common\Entity\IdentityTrait;

class Evenement
{
    use IdentityTrait;

    /**
     * Date de l'évenement
     *
     * @var Datetime|null
     */
    protected $date;

    /**
     * Description de l'évenement
     *
     * @var string
     */
    protected $description;

    /**
     * Ajout d'un evenement à une intervention
     *
     * @param SDIS62\Core\Ops\Entity\Intervention $intervention
     * @param string                              $description
     * @param Datetime|string|null                $date         Optionnel
     */
    public function __construct($description, $date = null)
    {
        if ($date instanceof Datetime) {
            $this->date = $date;
        } elseif ($date === null) {
            $this->date = new Datetime('NOW');
        } else {
            $this->date = DateTime::createFromFormat('d-m-Y H:i:s', (string) $date);
        }

        $this->description = $description;
    }

    /**
     * Get the value of Date de l'évenement
     *
     * @return Datetime|null
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Get the value of Description de l'évenement
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }
}
