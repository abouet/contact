<?php

namespace ScoRugby\Core\Event;

use ScoRugby\Core\Model\ManagedResourceInterface;
use Symfony\Component\EventDispatcher\Event;

/**
 * Description of ResourceEvent
 *
 * @author Antoine BOUET
 */
class ResourceEvent extends Event {

    public function __construct(protected ManagedResourceInterface $resource) {
        return;
    }

    public function getResource(): ManagedResourceInterface {
        return $this->resource;
    }
}
