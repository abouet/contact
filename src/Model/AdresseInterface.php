<?php

namespace ScoRugby\Core\Model;

interface AdresseInterface {

    public function setAdresse(string $adresse): self;

    public function getAdresse(): ?string;

    public function setComplement(string $adresse): self;

    public function getComplement(): ?string;

    public function setCodePostal(string $cp): self;

    public function getCodePostal(): ?string;

    public function setVille(string $ville): self;

    public function getVille(): ?string;

    public function getAdresseComplete(bool $multiligne = false): ?string;
}
