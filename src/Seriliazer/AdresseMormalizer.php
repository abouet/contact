<?php

namespace ScoRugby\Contact\Seriliazer;

use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\String\UnicodeString;
use ScoRugby\Contact\Model\AdresseInterface;

/**
 * Description of AdresseMormalizer
 *
 * @author Antoine BOUET
 */
class AdresseMormalizer implements NormalizerInterface {

    public function __construct(private readonly CommuneNormalizer $communeNormalizer) {
        return;
    }

    public function normalize(mixed $object, ?string $format = null, array $context = []): array|string|int|float|bool|\ArrayObject|null {
        $elmt['adresse'] = $adresse->getAdresse();
        $elmt['complement'] = $adresse->getComplement();
        $elmt['ville'] = $adresse->getVille();
        //
        foreach ($elmt as $id => $value) {
            if (!empty($value)) {
                $elmt[$id] = (new UnicodeString($value))->trim()
                        ->folded()->title(true)
                        ->replace(' Le ', ' le ')
                        ->replace("L'", "l'")
                        ->replace("D'", "d'")
                        ->replace(' De ', ' de ')
                        ->replace(' Des ', ' des ')
                        ->replace(' Du ', ' du ')
                        ->replace(' En ', ' en ');
            }
        }
        //
        $adresse->setAdresse($elmt['adresse']);
        $adresse->setComplement($elmt['complement']);
        //
        if (!empty($elmt['ville'])) {
            $ville = $this->communeNormalizer->normalize($elmt['ville']);
            $adresse->setVille($ville);
        }
        if (!empty($adresse->getCodePostal())) {
            $cp = (new UnicodeString($adresse->getCodePostal()))->trim()->replace(' ', '');
            $adresse->setCodePostal($cp);
        } else {
            $adresse->setCodePostal(null);
        }
    }

    public function supportsNormalization(mixed $data, ?string $format = null, array $context = []): bool {
        return $data instanceof AdresseInterface;
    }

    public function getSupportedTypes(?string $format): array {
        return [
            AdresseInterface::class => true
        ];
    }

}
