<?php

namespace ScoRugby\Contact\Manager;

use ScoRugby\Core\Manager\AbstractDispatchingManager;
use ScoRugby\Core\Model\ManagedResourceInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use ScoRugby\Contact\Repository\ContactRepository;
use ScoRugby\Contact\Model\ContactInterface;
use ScoRugby\Contact\Model\AdresseInterface;
use ScoRugby\Contact\Seriliazer\ContactNormalizer;

class ContactManager extends AbstractDispatchingManager {

    private $adresseManager;

    public function __construct(ContactRepository $repository, protected EntityManagerInterface $em, ?EventDispatcherInterface $dispatcher = null, ?ValidatorInterface $validator = null, ?FormFactoryInterface $formFactory = null) {
        parent::__construct($repository, $dispatcher, $validator, $formFactory);
        $this->adresseManager = new AdresseManager();
    }

    public function setResource(ManagedResourceInterface $resource): self {
        if (!($resource instanceof ContactInterface)) {
            throw new \InvalidArgumentException(sprintf("Parameter MUST be an instance of %s. %s given", ContactInterface::class, get_class($resource)));
        }
        $normalizer = new ContactNormalizer();
        $contact = $normalizer->normalize($resource, ContactInterface::class);
        $adresse = $contact->getAdresse();
        $this->normalizeAddress($adresse);
        $contact->setAdresse($adresse);
        parent::setResource($contact);
    }

    /**
     * Définir Adresse et Commune pour geolocalisation
     */
    private function normalizeAddress(AdresseInterface $adresse): void {
        $this->adresseManager->normalize($adresse);
        // 
        if (null === $adresse->getVille()) {
            return;
        }
        $commune = null;
        if (null != $adresse->getVille()) {
            $commune = $this->adresseManager->findByNom($adresse->getVille());
        }
        if (null !== $commune) {
            $adresse->setVille($commune->getNom());
            if ($commune->isRegroupement() & null != $adresse->getComplement()) {
                $cmplmt = $this->adresseManager->findByNom($adresse->getComplement());
                if (null !== $cmplmt) {
                    $commune = $cmplmt;
                }
            }
        }
        if (null !== $commune) {
            $adresse->setCommune($commune);
        }
    }
}
