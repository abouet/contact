<?php

namespace App\Core\Repository;

use App\Core\Entity\SluggifyInterface;

/**
 *
 * @author Antoine BOUET
 */
interface SlugRepositoryInterface {

    public function findBySlug(string $slug): ?SluggifyInterface;
}
