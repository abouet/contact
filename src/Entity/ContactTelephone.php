<?php

namespace ScoRugby\Contact\Entity;

use ScoRugby\Contact\Repository\ContactTelephoneRepository;
use Doctrine\ORM\Mapping as ORM;
use ScoRugby\Core\Exception\InvalidParameterException;
use Symfony\Component\Intl\Countries;
USE ScoRugby\Core\Entity\EntityInterface;

#[ORM\Entity(repositoryClass: ContactTelephoneRepository::class)]
//#[ORM\Table(schema: "club")]
class ContactTelephone implements EntityInterface {

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    protected ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'telephones')]
    #[ORM\JoinColumn(nullable: false)]
    protected ?Contact $contact = null;

    #[ORM\Column(length: 2, options: ['comment' => 'Code pays ISO 3166-1 alpha-2'])]
    protected ?string $code_pays = null;

    #[ORM\Column(length: 20, options: ['comment' => 'sans espace ni autre séparateur'])]
    protected ?string $numero = null;

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

    public function getCodePays(): ?string {
        return $this->code_pays;
    }

    public function setCodePays(string $pays): self {
        $pays = strtoupper($pays);
        if (!Countries::exists($pays)) {
            throw new InvalidParameterException(sprintf('Le code %s n\'est pas un code pays valide (ISO 3166-1 alpha-2)', $pays));
        }
        $this->code_pays = $pays;

        return $this;
    }

    public function getNumero(): ?string {
        return $this->numero;
    }

    public function setNumero(string $numero): self {
        $this->numero = $numero;

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
