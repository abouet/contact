<?php

namespace ScoRugby\Contact\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use ScoRugby\Core\Model\GroupeInterface;

class Groupe implements GroupeInterface {

    private ?int $id = null;
    private ?string $libelle = null;
    private Collection $contacts;

    public function __construct() {
        $this->contacts = new ArrayCollection();
    }

    public function getId(): ?int {
        return $this->id;
    }

    public function getLibelle(): ?string {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self {
        $this->libelle = $libelle;

        return $this;
    }

    /**
     * @return Collection<int, GroupeContact>
     */
    public function getContacts(): Collection {
        return $this->contacts;
    }

    public function addContact(GroupeContact $contact): self {
        if (!$this->contacts->contains($contact)) {
            $this->contacts->add($contact);
            $contact->setGroupe($this);
        }

        return $this;
    }

    public function removeContact(GroupeContact $contact): self {
        if ($this->contacts->removeElement($contact)) {
            // set the owning side to null (unless already changed)
            if ($contact->getGroupe() === $this) {
                $contact->setGroupe(null);
            }
        }

        return $this;
    }
}
