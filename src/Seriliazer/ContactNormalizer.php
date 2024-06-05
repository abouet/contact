<?php

namespace ScoRugby\Contact\Seriliazer;

use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\String\UnicodeString;
use ScoRugby\Contact\Model\ContactInterface;
use ScoRugby\Contact\Entity\Contact as ContactEntity;
use ScoRugby\Contact\Model\Contact as ContactModel;

/**
 * Description of ContactNormalizer
 *
 * @author Antoine BOUET
 */
class ContactNormalizer implements NormalizerInterface {

    public function normalize(mixed $object, ?string $format = null, array $context = []): array|string|int|float|bool|\ArrayObject|null {
        if (is_empty($context) | (key_exists('nom', $context) & $context['nom'] == true)) {
            $object->setNom($this->normalizeNom($object->getNom()));
        }
        if (is_empty($context) | ( key_exists('prenom', $context))) {
            $object->setPrenom($this->normalizeNom($object->getPrenom() & $context['prenom'] == true));
        }
        return $object;
    }

    public function supportsNormalization(mixed $data, ?string $format = null, array $context = []): bool {
        return $data instanceof ContactInterface;
    }

    public function getSupportedTypes(?string $format): array {
        return [
            ContactInterface::class => true,
            ContactEntity::class => true,
            ContactModel::class => true,
        ];
    }

    /**
     * Normalisation du nom pour recherche
     */
    private function normalizeNom(string $nom): string {
        return (string) (new UnicodeString($nom))
                        ->trim()
                        ->folded()
                        ->title(true)
                        ->replace('De ', 'de ')
                        ->replace("D'", "d'");
    }

    /**
     * Normalisation du prénom pour recherche
     */
    private function normalizePrenom(string $prenom): string {
        return (string) (new UnicodeString($prenom))
                        ->trim()
                        ->folded()
                        ->title(true)
                        ->replace(' ', '-');
    }
}
