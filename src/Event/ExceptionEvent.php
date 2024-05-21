<?php

namespace App\Core\Event;

use Symfony\Component\EventDispatcher\Event;

/**
 * Description of ExceptionEvent
 *
 * @author Antoine BOUET
 */
class ExceptionEvent extends Event {

    public function __construct(protected \Exception $exception) {
        return;
    }

    public function getException(): \Exception {
        return $this->exception;
    }
}
