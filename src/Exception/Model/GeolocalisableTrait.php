<?php

namespace ScoRugby\Core\Model;

trait GeolocalisableTrait {

    protected $latitude = null;
    protected $longitude = null;

    public function getLatitude(): ?string {
        return $this->latitude;
    }

    public function setLatitude($latitude): self {
        $this->latitude = $latitude;
        return $this;
    }

    public function getLongitude(): ?string {
        return $this->longitude;
    }

    public function setLongitude($longitude): self {
        $this->longitude = $longitude;
        return $this;
    }

    public function getCoordonnees(): ?string {
        if ($this->isGeolocalisable()) {
            return $this->getLongitude() . ',' . $this->getLatitude();
        } else {
            return null;
        }
    }

    public function isGeolocalisable(): bool {
        return (null !== $this->getLongitude() & null !== $this->getLatitude());
    }

}
