<?php

namespace ScoRugby\Contact\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ScoRugby\Core\Entity\EntityInterface;
use ScoRugby\Contact\Model\Groupe as BaseGroupe;

#[ORM\Entity(repositoryClass: GroupeRepository::class)]
//#[ORM\Table(schema: "club")]
class Groupe extends BaseGroupe implements EntityInterface {

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    protected ?int $id = null;

    #[ORM\Column(length: 20)]
    protected ?string $libelle = null;

    #[ORM\OneToMany(mappedBy: 'groupe', targetEntity: GroupeContact::class, orphanRemoval: true)]
    protected Collection $contacts;

}
