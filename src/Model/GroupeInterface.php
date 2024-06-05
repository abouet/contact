<?php

namespace ScoRugby\Core\Model;

interface GroupeInterface {

    public function getId(): ?int;

    public function getLibelle(): ?string;

    public function setLibelle(string $libelle): self;
}
