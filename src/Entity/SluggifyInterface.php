<?php

namespace App\Core\Entity;

/**
 *
 * @author Antoine BOUET
 */
interface SluggifyInterface {

    public function getSlug(): ?string;

    public function setSlug(string $slug): self;

    public function sluggify(string $slug): string;
}
