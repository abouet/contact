<?php

namespace ScoRugby\Core\Service;

use Psr\Log\LoggerInterface;

trait TransactionTrait {

    protected bool $chained = false;
    protected bool $rollback = false;

    public function initTransaction(): void {
        if (true === $this->chained) {
            return;
        }
        /* if ($this->em->getConnection()->isConnected()) {
          return;
          } */
        if ($this->hasLogger()) {
            $this->getLogger()->debug('start transaction');
        }
        $this->em->beginTransaction();
        $this->em->getConnection()->setAutoCommit(false);
    }

    public function setChained(): void {
        $this->chained = true;
    }

    public function endChained(): void {
        $this->chained = false;
    }

    public function setRollback(): void {
        $this->rollback = true;
    }

    public function shutDownTransaction(): void {
        if (true === $this->chained) {
            return;
        }
        if ($this->hasLogger()) {
            $this->getLogger()->debug('Fin transaction');
        }
        if (!$this->em->isOpen()) {
            if ($this->hasLogger()) {
                $this->getLogger()->debug('   closed');
            }
            return;
        }
        if (!$this->em->getConnection()->isConnected()) {
            if ($this->hasLogger()) {
                $this->getLogger()->debug('   not connected');
            }
            return;
        }
        if (true === $this->rollback) {
            if ($this->hasLogger()) {
                $this->getLogger()->debug('   rollback');
            }
            this->em->getConnection()->rollBack();
        } else {
            if ($this->hasLogger()) {
                $this->getLogger()->debug('   commit');
            }
            $this->em->getConnection()->commit();
        }
        //
        if ($this->hasLogger()) {
            $this->getLogger()->debug('   close transation');
        }
        $this->em->getConnection()->close();
        //
        if ($this->hasLogger()) {
            $this->getLogger()->debug('   close em');
        }
    }

    abstract protected function hasLogger(): bool;

    abstract protected function getLogger(): LoggerInterface;
}
