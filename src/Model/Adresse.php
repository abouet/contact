<?php

namespace ScoRugby\Core\Model;

class Adresse implements \Stringable {

    protected $adresse,
            $complement,
            $code_postal,
            $ville;

    public function setAdresse(string $adresse): self {
        $this->adresse = $adresse;
        return $this;
    }

    public function getAdresse(): ?string {
        return $this->adresse;
    }

    public function setComplement(string $adresse): self {
        $this->complement = $adresse;
        return $this;
    }

    public function getComplement(): ?string {
        return $this->complement;
    }

    public function setCodePostal(string $cp): self {
        $this->code_postal = $cp;
        return $this;
    }

    public function getCodePostal(): ?string {
        return $this->code_postal;
    }

    public function setVille(string $ville): self {
        $this->ville = $ville;
        return $this;
    }

    public function getVille(): ?string {
        return $this->ville;
    }

    public function getAdresseComplete(bool $multiligne = false): ?string {
        $separateur = ' ';
        if (true === $multiligne) {
            $separateur = "\n";
        }
        $adresse[] = $this->getAdresse();
        if ($this->complement) {
            $adresse[] = $this->getComplement();
        }
        $adresse[] = $this->getCodePostal() . ' ' . $this->getVille();
        return implode($separateur, $adresse);
    }

    public function __toString(): string {
        return $this->getAdresseComplete(false);
    }

}
