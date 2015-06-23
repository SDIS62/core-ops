<?php

namespace SDIS62\Core\Ops\Entity;

use Datetime;

class Coordinates
{
    /**
     * Latitude.
     *
     * @var double
     */
    protected $latitude;

    /**
     * Longitude.
     *
     * @var double
     */
    protected $longitude;

    /**
     * Timestamp.
     *
     * @var Datetime
     */
    protected $date;

    /**
     * Création d'une coordonnée.
     *
     * @param float $x
     * @param float $y
     * @param Datetime $date
     */
    public function __construct($latitude, $longitude, Datetime $date = null)
    {
        $this->setCoordinates($latitude, $longitude, $date);
    }

    /**
     * Set the value of Point Y.
     *
     * @param float $x
     * @param float $y
     * @param Datetime $date
     *
     * @return self
     */
    public function setCoordinates($latitude, $longitude, Datetime $date = null)
    {
        $this->latitude = $latitude;
        $this->longitude = $longitude;
        $this->date = empty($date) ? new Datetime() : $date;

        return $this;
    }

    /**
     * Get the value of Point X.
     *
     * @return float
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * Get the value of Point Y.
     *
     * @return float
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * Get the value of Timestamp.
     *
     * @return Datetime
     */
    public function getDate()
    {
        return $this->date;
    }

}
