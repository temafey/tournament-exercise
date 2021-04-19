<?php

declare(strict_types=1);

namespace Tournament;

use Tournament\Weapon\WeaponFactory;

class Swordsman extends Fighter
{
    protected int $initialHitPoints = 100;

    public function __construct(string $skill = null)
    {
        $this->setWeapon(WeaponFactory::WEAPON_SWORD);
        parent::__construct($skill);
    }
}
