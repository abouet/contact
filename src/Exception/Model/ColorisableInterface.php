<?php

namespace App\Core\Model;

interface ColorisableInterface {

    public function getCouleur(): ?string;

    public function setCouleur(?string $couleur): self;

    public function hasCouleur(): bool;
}
