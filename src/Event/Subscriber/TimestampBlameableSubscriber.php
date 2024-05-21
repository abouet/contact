<?php

namespace App\Core\Event\Subscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use App\Core\Entity\TimestampBlameableInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Doctrine\ORM\Events;
use Doctrine\ORM\Event\PrePersistEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;

final class TimestampBlameableSubscriber implements EventSubscriberInterface {

    public function __construct(private Security $security) {
        return;
    }

    public static function getSubscribedEvents() {
        return [Events::prePersist, Events::preUpdate];
    }

    public function prePersist(PrePersistEventArgs $args) {
        $entity = $args->getObject();
        if ($entity instanceof TimestampBlameableInterface) {
            $entity->setCreatedAt(new \DateTimeImmutable());
            if (null !== $this->security->getUser()) {
                $entity->setCreatedBy($this->security->getUser());
            }
            $args->getObjectManager()->persist($entity);
        }
    }

    public function preUpdate(PreUpdateEventArgs $args) {
        $entity = $args->getObject();
        if ($entity instanceof TimestampBlameableInterface) {
            $entity->setUpdatedAt(new \DateTimeImmutable());
            if (null !== $this->security->getUser()) {
                $entity->setUpdatedBy($this->security->getUser());
            }
            $args->getObjectManager()->persist($entity);
        }
    }

}
