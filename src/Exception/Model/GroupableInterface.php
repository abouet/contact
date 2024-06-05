<?php

namespace ScoRugby\Core\Model;

use Doctrine\Common\Collections\Collection;

interface GroupableInterface {

    public function getGroupes(): Collection;

//    public function hasGroupe($name);
//    public function addGroupe(GroupeInterface $groupe);
//    public function removeGroupe(GroupeInterface $groupe);
}
