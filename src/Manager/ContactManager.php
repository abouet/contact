<?php

namespace ScoRugby\Contact\Manager;

use ScoRugby\Core\Manager\AbstractDispatchingManager;
//!!use App\Manager\AdresseManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use ScoRugby\Contact\Repository\ContactRepository;
use ScoRugby\Contact\Model\AdresseInterface;

final class ContactManager extends AbstractDispatchingManager {

    private $adresseManager;

    public function __construct(ContactRepository $repository, protected EntityManagerInterface $em, ?EventDispatcherInterface $dispatcher = null, ?ValidatorInterface $validator = null, ?FormFactoryInterface $formFactory = null) {
        parent::__construct($repository, $dispatcher, $validator, $formFactory);
        $this->adresseManager = new AdresseManager();
    }

    /**
     * Définir Adresse et Commune pour geolocalisation
     */
    public function setAddress(AdresseInterface $adresse): void {
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
            $this->getResource()->setCommune($commune);
        }
        $this->getResource()->setAdresse($adresse);
    }
}
