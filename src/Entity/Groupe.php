<?php

namespace ScoRugby\Contact\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ScoRugby\Core\Entity\EntityInterface;
use ScoRugby\Contact\Model\Groupe as BaseGroupe;

#[ORM\Entity(repositoryClass: GroupeRepository::class)]
//#[ORM\Table(schema: "club")]
class Groupe extends BaseGroupe implements EntityInterface {

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 20)]
    private ?string $libelle = null;

    #[ORM\OneToMany(mappedBy: 'groupe', targetEntity: GroupeContact::class, orphanRemoval: true)]
    private Collection $contacts;

    public function __construct() {
        $this->contacts = new ArrayCollection();
    }

    /**
     * @return Collection<int, Contact>
     */
    public function getContacts(): Collection {
        return $this->contacts;
    }

    public function addContact(Contact $contact): self {
        if (!$this->contacts->contains($contact)) {
            $this->contacts->add($contact);
        }

        return $this;
    }

    public function removeContact(Contact $contact): self {
        $this->contacts->removeElement($contact);

        return $this;
    }
}
