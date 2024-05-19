<?php

namespace ScoRugby\Core\Event\Traitement;

use Symfony\Contracts\EventDispatcher\Event;
use ScoRugby\Core\Model\Traitement\TraitementObjectInterface;

class TraitementInitEvent extends Event {

    public function __construct(private TraitementObjectInterface $traitement) {
        return;
    }

    public function getTraitement(): TraitementObjectInterface {
        return $this->traitement;
    }
}
