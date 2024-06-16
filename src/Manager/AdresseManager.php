<?php

namespace ScoRugby\Contact\Manager;

use ScoRugby\Contact\Model\Adresse;
use ScoRugby\Contact\Entity\Commune;
use ScoRugby\Contact\Repository\CommuneRepository;

/**
 * Description of AdresseManager
 *
 * @author Antoine BOUET
 */
class AdresseManager {

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
