<?php

namespace App\Core\Model;

interface TaxonomyInterface {

    public function getCode(): ?string;

    public function setCode($code): self;

    public function getLibelle(): ?string;

    public function setLibelle($libelle): self;

    public function getDescription(): ?string;

    public function setDescription($description): self;

    public function __toString(): string;
}
