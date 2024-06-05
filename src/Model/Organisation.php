<?php

namespace ScoRugby\Contact\Model;

use ScoRugby\Contact\Model\Adresse;

class Organisation {

    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $nom = null;

    #[ORM\Embedded(class: Adresse::class, columnPrefix: false)]
    private Adresse $adresse;

    #[ORM\Column(length: 1)]
    private ?string $etat = 'A';

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
