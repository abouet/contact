<?php

namespace ScoRugby\ContactBundle\Entity;

use ScoRugby\ContactBundle\Model as BaseContact;
use ScoRugby\ContactBundle\Entity\Commune;
use ScoRugby\ContactBundle\Entity\Organisation\Organisation;
use ScoRugby\ContactBundle\Repository\ContactRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use ScoRugby\CoreBundle\Entity\EntityInterface;
use ScoRugby\CoreBundle\Model\ManagedResourceInterface;
use ScoRugby\CoreBundle\Entity\TimestampBlameableInterface;
use ScoRugby\CoreBundle\Entity\TimestampBlameableTrait;

#[ORM\Entity(repositoryClass: ContactRepository::class)]
//[ORM\Table(schema: "contact")]
#[ORM\UniqueConstraint(name: "unq_contact_external_id", columns: ["external_id"])]
#[ORM\HasLifecycleCallbacks]
class Contact extends BaseContact implements EntityInterface, ManagedResourceInterface, TimestampBlameableInterface {

    use TimestampBlameableTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Embedded(class: Adresse::class, columnPrefix: false)]
    private Adresse $adresse;

    #[ORM\Column]
    private bool $public = false;

    #[ORM\Column]
    private bool $listeRouge = true;

    #[ORM\Column(length: 100)]
    private ?string $nom = null;

    #[ORM\Column(length: 100)]
    private ?string $prenom = null;

    #[ORM\Column(length: 1)]
    private ?string $genre = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $note = null;

    //[ORM\OneToOne(cascade: ['persist', 'remove'])]
    //private ?Media $photo = null;

    #[ORM\ManyToOne]
    private ?Commune $commune = null;

    #[ORM\OneToMany(mappedBy: 'contact', targetEntity: GroupeContact::class, orphanRemoval: true)]
    private Collection $groupes;

    #[ORM\ManyToMany(targetEntity: Organisation::class, inversedBy: 'contacts')]
    //#[ORM\JoinTable(name: "contact_organisation")]
    //#[ORM\JoinColumn(unique: true)]
    private Collection $organisations;

    #[ORM\OneToMany(mappedBy: 'contact', targetEntity: ContactTelephone::class, orphanRemoval: true, cascade: ['all'])]
    private Collection $telephones;

    #[ORM\OneToMany(mappedBy: 'contact', targetEntity: ContactEmail::class, orphanRemoval: true, cascade: ['all'])]
    private Collection $emails;

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
