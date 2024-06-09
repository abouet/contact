<?php

namespace ScoRugby\Contact\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ScoRugby\Contact\Model\Adresse;
use ScoRugby\Contact\Entity\Contact;
use ScoRugby\Contact\Repository\Organisation\OrganisationRepository;
use ScoRugby\Core\Entity\TimestampBlameableInterface;
use ScoRugby\Core\Entity\TimestampBlameableTrait;
use ScoRugby\Core\Entity\EntityInterface;
use ScoRugby\Contact\Model\Organisation as BaseOrganisation;

#[ORM\Entity(repositoryClass: OrganisationRepository::class)]
//#[ORM\Table(schema: "contact")]
class Organisation extends BaseOrganisation implements EntityInterface, TimestampBlameableInterface {

    use TimestampBlameableTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    protected ?int $id = null;

    #[ORM\Column(length: 100)]
    protected ?string $nom = null;

    #[ORM\Embedded(class: Adresse::class, columnPrefix: false)]
    protected Adresse $adresse;

    #[ORM\Column(length: 1)]
    protected ?string $etat = 'A';

    #[ORM\ManyToMany(targetEntity: Contact::class, mappedBy: 'organisations')]
    //#[ORM\JoinTable(name: 'contact_organisation')]
    //#[ORM\JoinColumn(name: 'organisation_id', unique: true)]
    protected Collection $contacts;

    public function __construct() {
        parent::__construct();
        $this->contacts = new ArrayCollection();
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
