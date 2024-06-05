<?php

namespace ScoRugby\Contact\Model;

use ScoRugby\Contact\Model\AdresseInterface;

/**
 *
 * @author Antoine BOUET
 */
interface ContactInterface extends \Stringable {

    public function getId(): ?int;

    public function getAdresse(): AdresseInterface;

    public function setAdresse(AdresseInterface $adresse): self;

    public function isPublic(): ?bool;

    public function setNom(string $nom): self;

    public function getPrenom(): ?string;

    public function setPrenom(string $prenom): self;
}
