<?php

namespace ScoRugby\Contact\Model;

/**
 *
 * @author Antoine BOUET
 */
interface AdresseInterface {

    public function getAdresse(): ?string;

    public function setAdresse(?string $adresse): self;

    public function getComplement(): ?string;

    public function setComplement(?string $complement): self;

    public function getCodePostal(): ?string;

    public function setCodePostal(?string $codePostal): self;

    public function getVille(): ?string;

    public function setVille(?string $ville): self;

    public function getPays(): ?string;

    public function setPays(?string $pays): self;
}
