<?php
/**
 * Created by PhpStorm.
 * User: mocniak
 * Date: 03.11.16
 * Time: 22:52
 */

namespace AppBundle\Service;


class GpsLocation
{
    /**
     * @var float
     */
    private $lat;
    /**
     * @var float
     */
    private $lon;

    public function __construct(float $lat, float $lon) {

        $this->lat = $lat;
        $this->lon = $lon;
    }

    /**
     * @return float
     */
    public function getLon()
    {
        return $this->lon;
    }

    /**
     * @return float
     */
    public function getLat()
    {
        return $this->lat;
    }
}