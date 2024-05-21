<?php

namespace App\Core\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\String\Slugger\AsciiSlugger;

trait SluggifyTrait {

    #[ORM\Column(length: 100)]
    private ?string $slug = null;

    public function getSlug(): ?string {
        return $this->slug;
    }

    public function setSlug(string $slug): self {
        $this->slug = $this->sluggify($slug);
        return $this;
    }

    public function sluggify(string $slug): string {
        return (new AsciiSlugger())->slug($slug);
    }
}
