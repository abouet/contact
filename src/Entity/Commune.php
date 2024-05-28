<?php

namespace ScoRugby\ContactBundle\Entity;

use ScoRugby\ContactBundle\Repository\CommuneRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use ScoRugby\CoreBundle\Entity\EntityInterface;

#[ORM\Entity(repositoryClass: CommuneRepository::class, readOnly: true)]
//[ORM\Table(schema: "club")]
class Commune implements EntityInterface, \Stringable {

    #[ORM\Id]
    #[ORM\Column(length: 5)]
    private ?string $id = null;

    #[ORM\Column(length: 4)]
    private ?string $type = null;

    #[ORM\ManyToOne(targetEntity: self::class, inversedBy: 'communesAssociees')]
    private ?self $parent = null;

    #[ORM\Column(length: 100)]
    private ?string $canonizedNom = null;

    #[ORM\Column(length: 100)]
    private ?string $nom = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 13, scale: 10, nullable: true)]
    private ?string $latitude = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 13, scale: 10, nullable: true)]
    private ?string $longitude = null;

    #[ORM\Column(length: 5)]
    private ?string $codeINSEE = null;

    #[ORM\Column]
    private ?bool $regroupement = false;

    #[ORM\OneToMany(mappedBy: 'parent', targetEntity: self::class)]
    private Collection $communesAssociees;

    #[ORM\OneToMany(mappedBy: 'commune', targetEntity: CodePostal::class)]
    private Collection $codePostaux;

    public function __construct() {
        $this->communesAssociees = new ArrayCollection();
        $this->codePostaux = new ArrayCollection();
    }

    public function getId(): ?int {
        return $this->id;
    }

    public function setId(int $id): self {
        $this->id = $id;
        return $this;
    }

    public function getType(): ?string {
        return $this->type;
    }

    public function setType(string $type): self {
        $this->type = $type;

        return $this;
    }

    public function getNom(): ?string {
        return $this->nom;
    }

    public function setNom(string $nom): self {
        $this->nom = $nom;
        return $this;
    }

    public function getCanonizedNom(): ?string {
        return $this->canonizedNom;
    }

    public function setCanonizedNom(string $nom): self {
        $this->canonizedNom = $nom;
        return $this;
    }

    public function getLatitude(): ?string {
        return $this->latitude;
    }

    public function setLatitude(string $latitude): self {
        $this->latitude = $latitude;

        return $this;
    }

    public function getLongitude(): ?string {
        return $this->longitude;
    }

    public function setLongitude(string $longitude): self {
        $this->longitude = $longitude;

        return $this;
    }

    public function getCodeINSEE(): ?string {
        return $this->codeINSEE;
    }

    public function setCodeINSEE(string $codeINSEE): self {
        $this->codeINSEE = $codeINSEE;

        return $this;
    }

    public function isRegroupement(): ?bool {
        return $this->regroupement;
    }

    public function setRegroupement(bool $regroupement): self {
        $this->regroupement = $regroupement;

        return $this;
    }

    public function getParent(): ?self {
        return $this->parent;
    }

    public function setParent(?self $parent): self {
        $this->parent = $parent;

        return $this;
    }

    /**
     * @return Collection<int, self>
     */
    public function getCommunesAssociees(): Collection {
        return $this->communesAssociees;
    }

    public function addCommuneAssociee(self $commune): self {
        if (!$this->communesAssociees->contains($commune)) {
            $this->communesAssociees->add($commune);
            $commune->setParent($this);
        }

        return $this;
    }

    public function removeCommunesAssociee(self $commune): self {
        if ($this->communesAssociees->removeElement($commune)) {
            // set the owning side to null (unless already changed)
            if ($commune->getParent() === $this) {
                $commune->setParent(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, CodePostal>
     */
    public function getCodePostaux(): Collection {
        return $this->codePostaux;
    }

    public function addCodePostaux(CodePostal $codePostaux): self {
        if (!$this->codePostaux->contains($codePostaux)) {
            $this->codePostaux->add($codePostaux);
            $codePostaux->setCommune($this);
        }

        return $this;
    }

    public function removeCodePostaux(CodePostal $codePostal): self {
        if ($this->codePostaux->removeElement($codePostal)) {
            // set the owning side to null (unless already changed)
            if ($codePostal->getCommune() === $this) {
                $codePostal->setCommune(null);
            }
        }

        return $this;
    }

    public function __toString(): string {
        return (string) $this->getNom();
    }
}
