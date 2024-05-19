<?php

namespace App\Entity;

use App\Repository\TraitementRepository;
use App\Model\Traitement as BaseTraitement;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Model\ManagedResourceInterface;
use App\Entity\EntityInterface;

#[ORM\Entity(repositoryClass: TraitementRepository::class)]
//#[ORM\Table(schema: "club")]
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
