<?php

namespace ScoRugby\Core\Core\Model;

trait TaxonomyTrait {

    public function getId() {
        return $this->id;
    }

    public function getCode(): ?string {
        return $this->code;
    }

    public function setCode($code): self {
        $this->code = strtolower($code);
        return $this;
    }

    public function getLibelle(): ?string {
        return $this->libelle;
    }

    public function setLibelle($libelle): self {
        $this->libelle = $libelle;
        return $this;
    }

    public function getDescription(): ?string {
        return $this->description;
    }

    public function setDescription($description): self {
        $this->description = $description;
        return $this;
    }

    public function __toString(): string {
        return (string) $this->getLibelle();
    }

}
