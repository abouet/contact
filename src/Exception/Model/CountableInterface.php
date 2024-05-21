<?php

namespace App\Core\Model;

interface CountableInterface extends \Countable {

    public function setCount($count);

    public function increment();

    public function decrement();
}
