<?php

namespace ScoRugby\Core\Manager;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use ScoRugby\Core\Exception\InvalidResourceException;
use ScoRugby\Core\Exception\ResourceActionException;
use ScoRugby\Core\Model\ManagedResourceInterface;

/**
 * Description of AbstractService
 *
 * @author abouet
 */
abstract class AbstractManager implements ManagerInterface {

    protected $resource;

    public function createObject(): ManagedResourceInterface {
        $class = $this->getClassName();
        $this->setResource(new $class());
        return $this->getResource();
    }

    public function setResource(ManagedResourceInterface $resource): self {
        $this->resource = $resource;
    }

    public function &getResource(): ?ManagedResourceInterface {
        return $this->resource;
    }

    public function isValid(): bool {
        $class = $this->getClassName();
        return ($this->getResource() instanceof $class);
    }

    protected function populate($properties): void {
        if ($properties instanceof Request) {
            $valid = $this->processRequest($properties);
        } elseif ($properties instanceof FormInterface) {
            if ($properties->isSubmitted() && $properties->isValid()) {
                $this->setResource($properties->getData());
            }
            $valid = $properties->isValid();
        } else {
            $valid = $this->validate();
        }
        if (true !== $valid) {
            throw new InvalidResourceException();
        }
    }

    protected function checkForAction(string $action): bool {
        if (!$this->isValid()) {
            throw new ResourceActionException(sprintf("No %s has been set for %s.", $this->getResourceName(), $action));
        }
        switch ($action) {
            case 'delete':
            case 'update':
            case 'create':
                if (null === $this->dispatcher) {
                    throw new ResourceActionException(sprintf("No EventDispatcherInterface. Not possible to %s .", $action));
                }
                break;
            case 'validate':
                if (null === $this->validator) {
                    throw new ResourceActionException(sprintf("No ValidatorInterface. Not possible to validate."));
                }
                break;
        }
        return true;
    }

    public function getResourceName(): string {
        if (method_exists($this, 'getClassName')) {
            $reflectionClass = new \ReflectionClass($this->getClassName());
            return $reflectionClass->getShortName();
        } else {
            $reflectionClass = new \ReflectionClass($this);
            return ucfirst(str_replace('manager', '', strtolower($reflectionClass->getShortName())));
        }
    }
}
