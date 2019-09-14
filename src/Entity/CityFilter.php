<?php

namespace App\Entity;

class CityFilter
{
    /** @var string */
    protected $city;

    public function getCity()
    {
        return $this->city;
    }

    public function setCity($city)
    {
        $this->city = $city;
    }

}