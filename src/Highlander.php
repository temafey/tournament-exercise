<?php

declare(strict_types=1);

namespace Tournament;

use Tournament\Weapon\WeaponFactory;

class Highlander extends Fighter
{
    protected int $initialHitPoints = 150;

    public function __construct(string $skill = null)
    {
        $this->setWeapon(WeaponFactory::WEAPON_GREAT_SWORD);
        parent::__construct($skill);
    }
}
