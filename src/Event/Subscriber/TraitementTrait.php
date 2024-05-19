<?php

namespace ScoRugby\Core\Event\Subscriber;

use Symfony\Contracts\EventDispatcher\Event;
use ScoRugby\Core\Manager\TraitementManager;

/**
 *
 * @author Antoine BOUET
 */
trait TraitementTrait {

    public function onInit(Event $event): void {
        $this->getTraitementManager()->init($event->getTraitement());
    }

    public function onStart(Event $event): void {
        $this->getTraitementManager()->init($event->getTraitement());
    }

    public function onEnd(Event $event): void {
        $this->getTraitementManager()->end($event->getTraitement());
    }

    public function onSuccess(Event $event): void {
        $this->getTraitementManager()->setSuccess($event->getTraitement());
    }

    public function onError(Event $event): void {
        $this->getTraitementManager()->setError($event->getTraitement());
    }

    public function onFailure(Event $event): void {
        $this->getTraitementManager()->setFailure($event->getTraitement());
    }

    public function onException(Event $event): void {
        $this->getTraitementManager()->setError($event->getTraitement());
    }

    abstract public function getTraitementManager(): TraitementManager;
}
