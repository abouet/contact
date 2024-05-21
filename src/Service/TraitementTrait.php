<?php

namespace App\Core\Service;

use App\Core\Model\Traitement;
use App\Core\Model\TraitementInterface;
use App\Core\Event\TraitementEvent;

trait TraitementTrait {

    //protected bool $rollback = false;
    protected ?TraitementEvent $event = null;

    public function initProcess(string $traitement, array $context = []): void {
        if ($this->hasLogger()) {
            $this->getLogger()->debug(__METHOD__);
        }
        $this->event = new TraitementEvent((new Traitement())->setTraitement($traitement)->setContext($context));
        $this->dispatcher->dispatch($this->event, TraitementEvent::INIT);
    }

    public function startProcess(int $steps = null): void {
        $this->getTraitement()->setDebut();
        $context = [];
        if (null !== $steps) {
            $context['steps'] = $steps;
        }
        if ($this->hasLogger()) {
            $this->getLogger()->info('Début traitement', $context);
        }
        $this->dispatcher->dispatch($this->event, TraitementEvent::START);
    }

    public function endProcess(): void {
        // Fin du traitement
        $this->getTraitement()->setFin();
        if ($this->hasLogger()) {
            $this->getLogger()->info('Fin traitement', [__METHOD__]);
        }
        if (null === $this->event) {
            return;
        }
        $this->dispatcher->dispatch($this->event, TraitementEvent::END);
    }

    public function getTraitement(): ?TraitementInterface {
        return $this->event->getTraitement();
    }

    public function setSuccess($message = []): void {
        if (is_string($message)) {
            $this->getTraitement()->addInformation($message);
            if ($this->hasLogger()) {
                $this->getLogger()->info($message);
            }
        } else {
            foreach ($message as $msg) {
                $this->getTraitement()->addInformation($msg);
                if ($this->hasLogger()) {
                    $this->getLogger()->info($msg);
                }
            }
        }
        $this->dispatcher->dispatch($this->event, TraitementEvent::SUCCESS);
    }

    public function setError(string $message = null, string $method = null): void {
        if (null !== $message) {
            $this->getTraitement()->addInformation($message);
        }
        if (null !== $method) {
            $this->getTraitement()->addContext('method', $method);
        }
        if ($this->hasLogger() && null !== $message) {
            $this->getLogger()->error($method . ' : ' . $message);
        }
        $this->dispatcher->dispatch($this->event, TraitementEvent::ERROR);
    }

    public function setFailure(string $message): void {
        if ($this->hasLogger()) {
            $this->getLogger()->critical($message);
        }
        if (null === $this->getTraitement()) {
            return;
        }
        $this->getTraitement()->addInformation($message);
        /* if (null === $this->filesystem) {
          $content = [];
          if (null !== $this->getTraitement()->getMessage()) {
          $content = $this->getTraitement()->getMessage();
          }
          $content[] = $message;
          $this->getTraitement()->addInformation($content);
          } else {
          $this->getTraitement()->addInformation(sprintf('voir %s pour plus de détails', $this->filename));
          //$this->filesystem->appendToFile($this->filename, $message . "\n");
          } */
        $this->dispatcher->dispatch($this->event, TraitementEvent::FAILURE);
    }
}
