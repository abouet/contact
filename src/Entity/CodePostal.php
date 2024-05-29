<?php

namespace ScoRugby\ContactBundle\Entity;

use ScoRugby\ContactBundle\Repository\CodePostalRepository;
use Doctrine\ORM\Mapping as ORM;
use ScoRugby\CoreBundle\Entity\EntityInterface;

#[ORM\Entity(repositoryClass: CodePostalRepository::class, readOnly: true)]
//[ORM\Table(schema: "club")]
class CodePostal implements EntityInterface {

    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "IDENTITY")]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 10)]
    private ?string $codePostal = null;

    #[ORM\ManyToOne(inversedBy: 'codePostaux')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Commune $commune = null;

    public function getId(): ?int {
        return $this->id;
    }

    public function getCodePostal(): ?string {
        return $this->codePostal;
    }

    public function setCodePostal(string $codePostal): self {
        $this->codePostal = $codePostal;

        return $this;
    }

    public function getCommune(): ?Commune {
        return $this->commune;
    }

    public function setCommune(?Commune $commune): self {
        $this->commune = $commune;

        return $this;
    }
}
