<?php

namespace ScoRugby\Contact\Entity;

use ScoRugby\Contact\Repository\GroupeContactRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use ScoRugby\Core\Entity\EntityInterface;

#[ORM\Entity(repositoryClass: GroupeContactRepository::class)]
//#[ORM\Table(schema: "club")]
class GroupeContact implements EntityInterface {

    #[ORM\Id]
    #[ORM\ManyToOne(inversedBy: 'contacts')]
    #[ORM\JoinColumn(nullable: false)]
    protected ?Groupe $groupe = null;

    #[ORM\Id]
    #[ORM\ManyToOne(inversedBy: 'groupes')]
    #[ORM\JoinColumn(nullable: false)]
    protected ?Contact $contact = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    protected ?string $note = null;

    public function getId(): ?int {
        return $this->id;
    }

    public function getGroupe(): ?Groupe {
        return $this->groupe;
    }

    public function setGroupe(?Groupe $groupe): self {
        $this->groupe = $groupe;

        return $this;
    }

    public function getContact(): ?Contact {
        return $this->contact;
    }

    public function setContact(?Contact $contact): self {
        $this->contact = $contact;

        return $this;
    }

    public function getNote(): ?string {
        return $this->note;
    }

    public function setNote(?string $note): self {
        $this->note = $note;

        return $this;
    }
}
