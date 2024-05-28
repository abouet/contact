<?php

namespace ScoRugby\ContactBundle\Entity;

use App\Entity\Evenement\Calendrier;
//!!use App\Entity\Club\Fonction;
//!!use ScoRugby\ContactBundle\Repository\GroupeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ScoRugby\CoreBundle\Entity\EntityInterface;

#[ORM\Entity(repositoryClass: GroupeRepository::class)]
//#[ORM\Table(schema: "club")]
class Groupe implements EntityInterface {

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 20)]
    private ?string $libelle = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $emailList = null;

    #[ORM\OneToMany(mappedBy: 'groupe', targetEntity: GroupeContact::class, orphanRemoval: true)]
    private Collection $contacts;

    #[ORM\ManyToOne(inversedBy: 'groupes')]
    private ?Fonction $fonction = null;

    #[ORM\ManyToOne(inversedBy: 'groupes')]
    private ?Calendrier $calendrier = null;

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

    public function getEmailList(): ?string {
        return $this->emailList;
    }

    public function setEmailList(?string $emailList): self {
        $this->emailList = $emailList;

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

    public function getFonction(): ?Fonction
    {
        return $this->fonction;
    }

    public function setFonction(?Fonction $fonction): static
    {
        $this->fonction = $fonction;

        return $this;
    }

    public function getCalendrier(): ?Calendrier
    {
        return $this->calendrier;
    }

    public function setCalendrier(?Calendrier $calendrier): static
    {
        $this->calendrier = $calendrier;

        return $this;
    }
}
