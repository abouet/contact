<?php

namespace ScoRugby\Core\Manager;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use ScoRugby\Core\Model\ManagedResource;

abstract class AbstractAPIManager extends AbstractManager {

    public function __construct(protected HttpClientInterface $client, protected ?EventDispatcherInterface $dispatcher = null, protected ?ValidatorInterface $validator = null, protected ?FormFactoryInterface $formFactory = null) {
        return;
    }

    abstract public function getClassName(): string;

    public function find() {
    }

    public function create($properties): ManagedResource {
        $this->checkForAction('create');
        try {
            $class = $this->getClassName();
            if (!($properties instanceof $class)) {
                $this->createObject();
                $this->populate($properties);
            } else {
                $this->setResource($properties);
            }
            //save
            //
            $this->dispatchEvent(strTolower(sprintf('club.%s.create', $this->getResourceName())));
            return $this->getResource();
        } catch (\Exeption $e) {
            $this->dispatchException($e);
            throw $e;
        }
    }

    public function update($properties = null): ManagedResource {
        $this->checkForAction('update');
        try {
            $this->populate($properties);
            //update
            //
            try {
                $this->dispatchEvent(strTolower(sprintf('club.%s.update', $this->getResourceName())));
                return $this->getResource();
            } catch (UniqueConstraintViolationException $ex) {
                throw new UniqueConstraintViolationException(sprintf("%s '%s' already exists", $this->getResourceName(), $doc->getId()));
            } Catch (\Exception $ex) {
                throw new \LogicException($ex->getMessage());
            }
        } catch (\Exeption $e) {
            $this->dispatchException($e);
            throw $e;
        }
    }


    public function delete(): bool {
    }

    public function count($filters = null): int {
    }

    /**
     * find an occurence
     * used by self::get($id) | self::delete($id)
     * 
     * @param mixed $id
     * @return ManagedResource
     */
    protected function retrieve($ref): ?ManagedResource {
    }


}
