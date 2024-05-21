<?php

namespace App\Core\Model;

interface BlameableInterface {

    public function getCreatedBy();

    public function getUpdatedBy();
}
