<?php

namespace ScoRugby\Contact\Entity\Organisation;

use ScoRugby\Contact\Model\Adresse;
use ScoRugby\Contact\Entity\Contact;
use App\Repository\Organisation\OrganisationRepository;
use App\Collection\CollectionOrganisation;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ScoRugby\Core\Model\ManagedResourceInterface;
use ScoRugby\Core\Entity\TimestampBlameableInterface;
use ScoRugby\Core\Entity\TimestampBlameableTrait;
use ScoRugby\Core\Entity\EntityInterface;

#[ORM\Entity(repositoryClass: OrganisationRepository::class)]
//#[ORM\Table(schema: "contact")]
class Organisation implements EntityInterface, ManagedResourceInterface, TimestampBlameableInterface {

    use TimestampBlameableTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $nom = null;

    #[ORM\Embedded(class: Adresse::class, columnPrefix: false)]
    private Adresse $adresse;

    #[ORM\Column(length: 1)]
    private ?string $etat = 'A';

    #[ORM\ManyToMany(targetEntity: Contact::class, mappedBy: 'organisations')]
    //#[ORM\JoinTable(name: 'contact_organisation')]
    //#[ORM\JoinColumn(name: 'organisation_id', unique: true)]
    private Collection $contacts;

    public function __construct() {
        $this->adresse = new Adresse();
        $this->contacts = new ArrayCollection();
    }

    public function getId(): ?int {
        return $this->id;
    }

    public function getAdresse(): Adresse {
        return $this->adresse;
    }

    public function getNom(): ?string {
        return $this->nom;
    }

    public function setNom(string $nom): self {
        $this->nom = $nom;

        return $this;
    }

    public function getEtat(): ?string {
        return $this->etat;
    }

    public function setEtat(string $etat): self {
        $this->etat = $etat;

        return $this;
    }

    /**
     * @return Collection<int, Contact>
     */
    public function getContacts(): Collection {
        return $this->contacts;
    }

    public function addContact(Contact $contact): self {
        if (!$this->contacts->contains($contact)) {
            $this->contacts->add($contact);
            $contact->addOrganisation($this);
        }

        return $this;
    }

    public function removeContact(Contact $contact): self {
        if ($this->contacts->removeElement($contact)) {
            $contact->removeOrganisation($this);
        }

        return $this;
    }
}
