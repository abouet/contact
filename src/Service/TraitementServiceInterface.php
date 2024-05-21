<?php

namespace App\Core\Service;

use App\Core\Model\TraitementInterface;

interface TraitementServiceInterface {

    public function init(): void;

    public function shutdown(): void;

    public function getTraitement(): ?TraitementInterface;
}
