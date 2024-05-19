<?php

namespace ScoRugby\Core\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use ScoRugby\Core\Repository\TraitementRepository;
use ScoRugby\Core\Model\Traitement as BaseTraitement;
use ScoRugby\Core\Model\ManagedResourceInterface;
use ScoRugby\Core\Entity\EntityInterface;

#[ORM\Entity(repositoryClass: TraitementRepository::class)]
class Traitement extends BaseTraitement implements EntityInterface, \Stringable, ManagedResourceInterface {

    public const SUCCESS = 0;
    public const FAILURE = 1;
    public const ERROR = 2;

    #[ORM\Id]
    #[ORM\Column(type: "string")]
    protected ?string $id = null;

    #[ORM\Column(length: 100)]
    protected ?string $traitement = null;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    protected ?\DateTimeInterface $debut = null;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    protected ?\DateTimeInterface $fin = null;

    #[ORM\Column]
    private ?int $status = null;

    #[ORM\Column(length: 255, nullable: true)]
    protected ?string $description = null;

    #[ORM\Column(type: 'array', nullable: true)]
    protected array $informations = [];

    #[ORM\Column(type: 'array', nullable: true)]
    protected array $context = [];

    public function getStatus(): ?string {
        return $this->status;
    }

    public function setStatus(string $status): self {
        $this->status = $status;

        return $this;
    }
}
