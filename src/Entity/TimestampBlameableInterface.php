<?php

namespace ScoRugby\Core\Entity;

//use ScoRugby\Core\Entity\Security\User;

interface TimestampBlameableInterface {

    public function setCreatedAt(\DateTimeInterface $date);

    public function getCreatedAt(): ?\DateTimeImmutable;

//    public function setCreatedBy(User $user): self;
//
//    public function getCreatedBy(): ?User;

    public function setUpdatedAt(\DateTimeInterface $date);

    public function getUpdatedAt(): ?\DateTimeImmutable;

//    public function setUpdatedBy(User $user);
//
//    public function getUpdatedBy(): ?User;
}
