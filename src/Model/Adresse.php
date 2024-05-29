<?php

namespace ScoRugby\ContactBundle\Model\Adresse;

use Doctrine\ORM\Mapping as ORM;
use ScoRugby\CoreBundle\Exception\InvalidParameterException;
use Symfony\Component\Intl\Countries;

#[ORM\Embeddable]
class Adresse {

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $adresse = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $complement = null;

    #[ORM\Column(length: 10, nullable: true)]
    private ?string $codePostal = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $ville = null;

    #[ORM\Column(length: 2, nullable: true)]
    private ?string $pays = null;

    public function getAdresse(): ?string {
        return $this->adresse;
    }

    public function setAdresse(?string $adresse): self {
        $this->adresse = $adresse;
        return $this;
    }

    public function getComplement(): ?string {
        return $this->complement;
    }

    public function setComplement(?string $complement): self {
        $this->complement = $complement;
        return $this;
    }

    public function getCodePostal(): ?string {
        return $this->codePostal;
    }

    public function setCodePostal(?string $codePostal): self {
        $this->codePostal = $codePostal;
        return $this;
    }

    public function getVille(): ?string {
        return $this->ville;
    }

    public function setVille(?string $ville): self {
        $this->ville = $ville;
        return $this;
    }

    public function getPays(): ?string {
        return $this->pays;
    }

    public function setPays(?string $pays): self {
        $pays = strtoupper($pays);
        if (!Countries::exists($pays)) {
            throw new InvalidParameterException(sprintf('Le code %s n\'est pas un code pays valide (ISO 3166-1 alpha-2)', $pays));
        }
        $this->pays = $pays;
        return $this;
    }
}
