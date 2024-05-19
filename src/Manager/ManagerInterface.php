<?php

namespace ScoRugby\Core\Manager;

use ScoRugby\Core\Model\ManagedResourceInterface;

interface ManagerInterface {

    public function get($id): ManagedResourceInterface;

    public function count(): int;

    public function create($properties): ManagedResourceInterface;

    public function find(): array;

    public function update($properties): ManagedResourceInterface;

    public function delete(): bool;

    public function getResourceName(): string;

    public function getClassName(): string;

    public function setResource(ManagedResourceInterface $resource): self;

    public function &getResource(): ?ManagedResourceInterface;

    public function isValid(): bool;
}
