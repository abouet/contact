
<?php

namespace ScoRugby\Contact\Model;

class Contact implements ContactInterface {

    private ?int $id = null;
    private Adresse $adresse;
    private bool $public = false;
    private bool $listeRouge = true;
    private ?string $nom = null;
    private ?string $prenom = null;
    private ?string $genre = null;
    private ?string $note = null;

    public function getId(): ?int {
        return $this->id;
    }

    public function getAdresse(): Adresse {
        return $this->adresse;
    }

    public function setAdresse(Adresse $adresse): self {
        $this->adresse = $adresse;
        return $this;
    }

    public function isPublic(): ?bool {
        return $this->public;
    }

    public function setPublic(bool $public = true): self {
        $this->public = $public;

        return $this;
    }

    public function isListeRouge(): ?bool {
        return $this->listeRouge;
    }

    public function setListeRouge(bool $listeRouge = true): self {
        $this->listeRouge = $listeRouge;

        return $this;
    }

    public function getNom(): ?string {
        return $this->nom;
    }

    public function setNom(string $nom): self {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self {
        $this->prenom = $prenom;

        return $this;
    }

    public function getGenre(): ?string {
        return $this->genre;
    }

    public function setGenre(string $genre): self {
        $this->genre = $genre;

        return $this;
    }

    public function getNote(): ?string {
        return $this->note;
    }

    public function setNote(?string $note): self {
        $this->note = $note;

        return $this;
    }

    /* public function getPhoto(): ?Media {
      return $this->photo;
      }

      public function setPhoto(?Media $photo): self {
      $this->photo = $photo;

      return $this;
      } */

    public function __toString() {
        return sprintf('%s %s', $this->getPrenom(), $this->getNom());
    } 
}
