<?php

namespace ScoRugby\Core\Model;

class Traitement implements TraitementInterface {

    protected ?string $traitement = null;
    protected ?\DateTimeInterface $debut = null;
    protected ?\DateTimeInterface $fin = null;
    protected ?string $description = null;
    protected array $informations = [];
    protected array $context = [];

    public function __construct(private ?string $id = null) {
        if (null === $this->id) {
            $this->id = uniqid();
        }
    }

    public function getId(): ?string {
        return $this->id;
    }

    public function getTraitement(): ?string {
        return $this->traitement;
    }

    public function setTraitement(string $traitement): self {
        $this->traitement = $traitement;

        return $this;
    }

    public function getDebut(): ?\DateTimeInterface {
        return $this->debut;
    }

    public function setDebut(?\DateTimeInterface $debut = null): self {
        if (null === $debut) {
            $debut = new \DateTimeImmutable();
        }
        $this->debut = $debut;

        return $this;
    }

    public function getFin(): ?\DateTimeInterface {
        return $this->fin;
    }

    public function setFin(?\DateTimeInterface $fin = null): self {
        if (null === $fin) {
            $fin = new \DateTimeImmutable();
        }
        $this->fin = $fin;

        return $this;
    }

    public function getDescription(): ?string {
        return $this->description;
    }

    public function setDescription(?string $description): self {
        $this->description = $description;

        return $this;
    }

    public function getInformations(): ?array {
        return $this->informations;
    }

    public function addInformation(string $information): void {
        $this->informations[] = $information;
    }

    public function setInformations(array $informations): self {
        $this->informations = $informations;

        return $this;
    }

    public function getContext(): ?array {
        return $this->context;
    }

    public function addContext(string $key, string $context): void {
        $this->context[$key] = $context;
    }

    public function setContext(array $context): self {
        $this->context = $context;

        return $this;
    }

    public function __toString(): string {
        reset($this->informations);
        return sprintf('%s %s-%s : %s', $this->getDescription(), $this->getDebut()->format('H:i:s'), $this->getFin()->format('H:i:s'), current($this->informations));
    }
}
