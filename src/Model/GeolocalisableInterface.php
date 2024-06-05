<?php

namespace ScoRugby\Core\Model;

interface GeolocalisableInterface {

    public function getLatitude(): ?string;

    public function setLatitude($latitude): self;

    public function getLongitude(): ?string;

    public function setLongitude($longitude): self;

    public function getCoordonnees(): ?string;
}
