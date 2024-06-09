<?php

namespace ScoRugby\Contact\Model;

class Organisation {

    protected ?int $id = null;
    protected ?string $nom = null;
    protected Adresse $adresse;
    protected ?string $etat = 'A';

    public function __construct() {
        $this->adresse = new Adresse();
    }

    public function getId(): ?int {
        return $this->id;
    }

    public function getAdresse(): Adresse {
        return $this->adresse;
    }

    public function getNom(): ?string {
        return $this->nom;
    }

    public function setNom(string $nom): self {
        $this->nom = $nom;

        return $this;
    }

    public function getEtat(): ?string {
        return $this->etat;
    }

    public function setEtat(string $etat): self {
        $this->etat = $etat;

        return $this;
    }
}
