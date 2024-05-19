<?php

namespace ScoRugby\Core\Repository;

use ScoRugby\Core\Entity\SluggifyInterface;

/**
 *
 * @author Antoine BOUET
 */
interface SlugRepositoryInterface {

    public function findBySlug(string $slug): ?SluggifyInterface;
}
