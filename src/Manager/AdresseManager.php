<?php

namespace ScoRugby\ContactBundle\Manager;

use ScoRugby\ContactBundle\Model\Adresse;
use ScoRugby\ContactBundle\Entity\Commune;
use ScoRugby\ContactBundle\Repository\CommuneRepository;
use ScoRugby\ContactBundle\Seriliazer\AdresseMormalizer;

/**
 * Description of AdresseManager
 *
 * @author Antoine BOUET
 */
final class AdresseManager {

    public function __construct(private CommuneRepository $repository, private EntityManagerInterface $em) {
        return;
    }

    public function findByNom(string $nom): ?Commune {
        return $this->repository->findByNom($nom);
    }

    static public function normalize(Adresse &$adresse): void {
        $normalizer = new AdresseMormalizer();
        $adresse = $normalizer->normalize($adresse, Adresse::class);
    }
}
