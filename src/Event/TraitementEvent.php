<?php

namespace App\Core\Event;

use Symfony\Contracts\EventDispatcher\Event;
use App\Core\Model\TraitementInterface;

class TraitementEvent extends Event {

    public const INIT = 'process.init';
    public const START = 'process.start';
    public const END = 'process.end';
    public const SHUTDOWN = 'process.shutdown';
    public const SUCCESS = 'process.success';
    public const ERROR = 'process.rror';
    public const FAILURE = 'process.failure';
    public const EXCEPTION = 'process.exception';

    public function __construct(Protected TraitementInterface $traitement) {
        return;
    }

    public function &getTraitement(): TraitementInterface {
        return $this->traitement;
    }
}
