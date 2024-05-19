<?php

namespace ScoRugby\Core\Model;

interface BlameableInterface {

    public function getCreatedBy();

    public function getUpdatedBy();
}
