<?php

namespace ScoRugby\Core\Manager;

use ScoRugby\Core\Entity\Traitement;
use ScoRugby\Core\Model\TraitementInterface;
use ScoRugby\Core\Repository\TraitementRepository;
use ScoRugby\Core\Exception\ResourceActionException;
use ScoRugby\Core\Model\ManagedResourceInterface;
use ScoRugby\Core\Exception\ResourceNotFoundException;
use Psr\Log\LoggerInterface;

final class TraitementManager extends AbstractManager {

    protected $resource;

    public function __construct(private TraitementRepository $repository, private LoggerInterface $logger) {
        return;
    }

    public function getClassName(): string {
        return $this->repository->getClassName();
    }

    public function setResource(ManagedResourceInterface $resource): self {
        $this->resource = $resource;
    }

    public function &getResource(): ?ManagedResourceInterface {
        return $this->resource;
    }

    /**
     * @inheritDoc
     */
    public function get($id): ManagedResourceInterface {
        $trt = $this->repository->find($id);
        if (!$trt) {
            throw new ResourceNotFoundException(sprintf("Traitement '%s' not found", $id));
        }
        $this->setResource($trt);
        return $trt;
    }

    /**
     * @inheritDoc
     */
    public function count(): int {
        return $this->repository->count();
    }

    /**
     * @inheritDoc
     */
    public function create($properties): ManagedResourceInterface {
        throw new ResourceActionException(sprintf('%s ne peut pas être utilisé directement', __METHOD__));
    }

    /**
     * @inheritDoc
     */
    public function find(): array {
        return $this->repository->findAll();
    }

    /**
     * @inheritDoc
     */
    public function update($properties): ManagedResourceInterface {
        throw new ResourceActionException(sprintf('%s ne peut pas être utilisé directement', __METHOD__));
    }

    /**
     * @inheritDoc
     */
    public function delete(): bool {
        $this->repository->remove($this - $this->getResource(), true);
        return true;
    }

    /**
     * @inheritDoc
     */
    public function getResourceName(): string {
        return 'Traitement';
    }

    public function init(TraitementInterface $traitement): void {
        $trtObj = (new Traitement())
                ->setTraitement($traitement->getTraitement());
        $this->setResource($trtObj);
        $this->save();
    }

    public function start(TraitementInterface $traitement): void {
        $trtObj = $this->get($traitement->getId());
        if (null == $trtObj) {
            $trtObj = $this->createTraitement($traitement);
        }
        $trtObj->setDebut();
        $this->setResource($trtObj);
        $this->save();
    }

    public function end(TraitementInterface $traitement): void {
        $trtObj = $this->get($traitement->getId());
        if (null == $trtObj) {
            $trtObj = $this->createTraitement($traitement);
        }
        $trtObj->setFin();
        if (null === $trtObj->getStatus()) {
            $trtObj->setStatus(Traitement::ERROR);
            if (!empty($trtObj->getInformations())) {
                $trtObj->addInformation('Fin anormale');
            }
        }
        $this->setResource($trtObj);
        $this->save();
    }

    public function setSuccess(TraitementInterface $traitement): void {
        $trtObj = $this->get($traitement->getId());
        if (null == $trtObj) {
            $trtObj = $this->createTraitement($traitement);
        }
        $trtObj->setStatus(Traitement::SUCCESS);
        $trtObj->setInformations($trtObj->getInformations());
        $this->setResource($trtObj);
        $this->save();
    }

    public function setError(TraitementInterface $traitement): void {
        $trtObj = $this->get($traitement->getId());
        if (null == $trtObj) {
            $trtObj = $this->createTraitement($traitement);
        }
        $trtObj->setStatus(Traitement::ERROR);
        $trtObj->setInformations($trtObj->getInformations());
        $this->setResource($trtObj);
        $this->save();
    }

    public function setFailure(TraitementInterface $traitement): void {
        $trtObj = $this->get($traitement->getId());
        if (null == $trtObj) {
            $trtObj = $this->createTraitement($traitement);
        }
        $trtObj->setStatus(Traitement::FAILURE);
        $trtObj->setInformations($trtObj->getInformations());
        $this->setResource($trtObj);
        $this->save();
    }

    private function save(): void {
        $this->repository->save($this->getResource(), true);
        /* this->repository->getEntityManager()->beginTransaction();
          try {
          $this->repository->save($this->getResource(), true);
          $this->repository->getEntityManager()->commit();
          } catch (Exception $ex) {
          $this->repository->getEntityManager()->rollback();
          throw $ex;
          } finally {
          $this->repository->getEntityManager()->close();
          } */
    }

    private function createTraitement(TraitementInterface $traitement): Traitement {
        return (new Traitement())
                        ->setTraitement($traitement->getTraitement())
                        ->setDebut();
    }
}
