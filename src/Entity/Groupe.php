<?php

namespace ScoRugby\Contact\Entity;

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

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $emailList = null;

    #[ORM\OneToMany(mappedBy: 'groupe', targetEntity: GroupeContact::class, orphanRemoval: true)]
    private Collection $contacts;

    public function getEmailList(): ?string {
        return $this->emailList;
    }

    public function setEmailList(?string $emailList): self {
        $this->emailList = $emailList;

        return $this;
    }

    public function getFonction(): ?Fonction {
        return $this->fonction;
    }

    public function setFonction(?Fonction $fonction): static {
        $this->fonction = $fonction;

        return $this;
    }

    public function getCalendrier(): ?Calendrier {
        return $this->calendrier;
    }

    public function setCalendrier(?Calendrier $calendrier): static {
        $this->calendrier = $calendrier;

        return $this;
    }
}
