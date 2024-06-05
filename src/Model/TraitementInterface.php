<?php

namespace ScoRugby\Core\Model;

interface TraitementInterface {

    public function getId(): ?string;

    public function getTraitement(): ?string;

    public function setTraitement(string $traitement): self;

    public function getDebut(): ?\DateTimeInterface;

    public function setDebut(?\DateTimeInterface $debut = null): self;

    public function getFin(): ?\DateTimeInterface;

    public function setFin(?\DateTimeInterface $fin = null): self;

    public function getDescription(): ?string;

    public function setDescription(?string $description): self;

    public function setInformations(array $informations): self;

    public function addInformation(string $information): void;

    public function getInformations(): ?array;

    public function getContext(): ?array;

    public function addContext(string $key, string $context): void;

    public function setContext(array $context): self;
}
