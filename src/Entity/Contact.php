<?php

namespace ScoRugby\Contact\Entity;

use ScoRugby\Contact\Model\Contact as BaseContact;
use ScoRugby\Contact\Model\Adresse;
use ScoRugby\Contact\Entity\Commune;
use ScoRugby\Contact\Entity\Organisation\Organisation;
use ScoRugby\Contact\Repository\ContactRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use ScoRugby\Core\Entity\EntityInterface;
use ScoRugby\Core\Model\ManagedResourceInterface;
use ScoRugby\Core\Entity\TimestampBlameableInterface;
use ScoRugby\Core\Entity\TimestampBlameableTrait;

#[ORM\Entity(repositoryClass: ContactRepository::class)]
//[ORM\Table(schema: "contact")]
#[ORM\HasLifecycleCallbacks]
class Contact extends BaseContact implements EntityInterface, TimestampBlameableInterface, ManagedResourceInterface {

    use TimestampBlameableTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    protected ?int $id = null;

    #[ORM\Embedded(class: Adresse::class, columnPrefix: false)]
    protected Adresse $adresse;

    #[ORM\Column]
    protected bool $public = false;

    #[ORM\Column]
    protected bool $listeRouge = true;

    #[ORM\Column(length: 100)]
    protected ?string $nom = null;

    #[ORM\Column(length: 100)]
    protected ?string $prenom = null;

    #[ORM\Column(length: 1)]
    protected ?string $genre = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    protected ?string $note = null;

    //[ORM\OneToOne(cascade: ['persist', 'remove'])]
    //protected ?Media $photo = null;

    #[ORM\ManyToOne]
    protected ?Commune $commune = null;

    #[ORM\OneToMany(mappedBy: 'contact', targetEntity: GroupeContact::class, orphanRemoval: true)]
    protected Collection $groupes;

    #[ORM\ManyToMany(targetEntity: Organisation::class, inversedBy: 'contacts')]
    //#[ORM\JoinTable(name: "contact_organisation")]
    //#[ORM\JoinColumn(unique: true)]
    protected Collection $organisations;

    #[ORM\OneToMany(mappedBy: 'contact', targetEntity: ContactTelephone::class, orphanRemoval: true, cascade: ['all'])]
    protected Collection $telephones;

    #[ORM\OneToMany(mappedBy: 'contact', targetEntity: ContactEmail::class, orphanRemoval: true, cascade: ['all'])]
    protected Collection $emails;

    public function __construct() {
        $this->adresse = new Adresse();
        $this->groupes = new ArrayCollection();
        $this->organisations = new ArrayCollection();
        $this->telephones = new ArrayCollection();
        $this->emails = new ArrayCollection();
    }

    public function getCommune(): ?Commune {
        return $this->commune;
    }

    public function setCommune(?Commune $commune): self {
        $this->commune = $commune;

        return $this;
    }

    /**
     * @return Collection<int, GroupeContact>
     */
    public function getGroupes(): Collection {
        return $this->groupes;
    }

    public function Groupe(GroupeContact $groupe): self {
        if (!$this->groupes->contains($groupe)) {
            $this->groupes->add($groupe);
            $groupe->setContact($this);
        }

        return $this;
    }

    public function removeGroupe(GroupeContact $groupe): self {
        if ($this->groupes->removeElement($groupe)) {
            // set the owning side to null (unless already changed)
            if ($groupe->getContact() === $this) {
                $groupe > setContact(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Organisation>
     */
    public function getOrganisations(): Collection {
        return $this->organisations;
    }

    public function addOrganisation(Organisation $organisation): self {
        if (!$this->organisations->contains($organisation)) {
            $this->organisations->add($organisation);
        }

        return $this;
    }

    public function removeOrganisation(Organisation $organisation): self {
        $this->organisations->removeElement($organisation);

        return $this;
    }

    /**
     * @return Collection<int, ContactTelephone>
     */
    public function getTelephones(): Collection {
        return $this->telephones;
    }

    public function addTelephone(ContactTelephone $telephone): self {
        if (!$this->telephones->contains($telephone)) {
            $this->telephones->add($telephone);
            $telephone->setContact($this);
        }

        return $this;
    }

    public function removeTelephone(ContactTelephone $telephone): self {
        if ($this->telephones->removeElement($telephone)) {
            // set the owning side to null (unless already changed)
            if ($telephone->getContact() === $this) {
                $telephone->setContact(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ContactTelephone>
     */
    public function getEmails(): Collection {
        return $this->emails;
    }

    public function addEmail(ContactEmail $email): self {
        if (!$this->emails->contains($email)) {
            $this->emails->add($email);
            $email->setContact($this);
        }

        return $this;
    }

    public function removeEmail(ContactEmail $email): self {
        if ($this->emails->removeElement($email)) {
            // set the owning side to null (unless already changed)
            if ($email->getContact() === $this) {
                $email->setContact(null);
            }
        }

        return $this;
    }
}
