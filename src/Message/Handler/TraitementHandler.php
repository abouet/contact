<?php

namespace ScoRugby\Core\Message\Handler;

use ScoRugby\Core\Message\SmsNotification;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

class TraitementHandler {

    public function __invoke(SmsNotification $message) {
        // ... do some work - like sending an SMS message!
    }
}
