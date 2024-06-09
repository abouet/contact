<?php

namespace ScoRugby\Contact\Entity;

use ScoRugby\Contact\Repository\ContactEmailRepository;
use Doctrine\ORM\Mapping as ORM;
USE ScoRugby\Core\Entity\EntityInterface;

#[ORM\Entity(repositoryClass: ContactEmailRepository::class)]
//#[ORM\Table(schema: "club")]
class ContactEmail implements EntityInterface {

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    protected ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'emails')]
    #[ORM\JoinColumn(nullable: false)]
    protected ?Contact $contact = null;

    #[ORM\Column(length: 100)]
    protected ?string $email = null;

    #[ORM\Column(length: 1, options: ['comment' => 'D domicile,P pro,M mobile,A autre+type_libelle'])]
    protected ?string $type = null;

    #[ORM\Column(length: 20, nullable: true)]
    protected ?string $type_libelle = null;

    #[ORM\Column]
    protected ?bool $prefere = null;

    public function getId(): ?int {
        return $this->id;
    }

    public function getContact(): ?Contact {
        return $this->contact;
    }

    public function setContact(?Contact $contact): self {
        $this->contact = $contact;

        return $this;
    }

    public function getEmail(): ?string {
        return $this->email;
    }

    public function setEmail(string $email): self {
        $this->email = $email;

        return $this;
    }

    public function getType(): ?string {
        return $this->type;
    }

    public function setType(string $type): self {
        $this->type = $type;

        return $this;
    }

    public function getTypeLibelle(): ?string {
        return $this->type_libelle;
    }

    public function setTypeLibelle(?string $type_libelle): self {
        $this->type_libelle = $type_libelle;

        return $this;
    }

    public function isPrefere(): ?bool {
        return $this->prefere;
    }

    public function setPrefere(bool $prefere): self {
        $this->prefere = $prefere;

        return $this;
    }
}
