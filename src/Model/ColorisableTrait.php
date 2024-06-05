<?php

namespace ScoRugby\Core\Model;

trait ColorisableTrait {

//    protected $couleur;

    public function getCouleur(): ?string {
        return $this->couleur;
    }

    public function setCouleur(?string $couleur): self {
        $this->couleur = $couleur;
    }

    public function hasCouleur(): bool {
        return (bool) !is_null($this->getColor());
    }

}
