<?php

namespace ScoRugby\Core\Service;

use ScoRugby\Core\Model\TraitementInterface;

interface TraitementServiceInterface {

    public function init(): void;

    public function shutdown(): void;

    public function getTraitement(): ?TraitementInterface;
}
