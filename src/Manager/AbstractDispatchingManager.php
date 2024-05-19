<?php

namespace ScoRugby\Core\Manager;

use ScoRugby\Core\Model\ManagedResourceInterface;
use ScoRugby\Core\Event\ResourceEvent;
use ScoRugby\Core\Event\ExceptionEvent;

/**
 * Description of AbstractService
 *
 * @author abouet
 */
abstract class AbstractDispatchingManager extends AbstractRepositoryResourceManager {

    public function create($properties): ManagedResourceInterface {
        $name = strTolower(sprintf('%s.create', $this->getResourceName()));
        try {
            $create = parent::create($properties);
            $this->dispatchEvent($name);
            return $create;
        } catch (\Exeption $e) {
            $this->dispatchException($name, $e);
            throw $e;
        }
    }

    public function update($properties = null): ManagedResourceInterface {
        $name = strTolower(sprintf('%s.update', $this->getResourceName()));
        try {
            $update = parent::update($properties);
            $this->dispatchEvent($name);
            return $update;
        } catch (\Exeption $e) {
            $this->dispatchException($name, $e);
            throw $e;
        }
    }

    public function delete(): bool {
        $name = strTolower(sprintf('%s.delete', $this->getResourceName()));
        try {
            $delete = parent::delete();
            $this->dispatchEvent($name);
            return $delete;
        } catch (\Exeption $e) {
            $this->dispatchException($name, $e);
            throw $e;
        }
    }

    protected function dispatchEvent(string $name): void {
        $this->dispatcher->dispatch(new ResourceEvent($this->getResource()), $name);
    }

    protected function dispatchException(string $name, \Exception $exception): void {
        $this->dispatcher->dispatch(new ExceptionEvent($exception), strTolower($name . 'exception'));
        $reflection = new \ReflectionClass($exception);
        if ('exception' != strtolower($reflection->getShortName())) {
            $this->dispatcher->dispatch(new ExceptionEvent($exception), strTolower(strtolower($reflection->getShortName())));
        }
    }
}
