<?php

declare(strict_types=1);

namespace Tournament;

use Tournament\Weapon\WeaponFactory;

class Viking extends Fighter
{
    protected int $initialHitPoints = 120;

    public function __construct(string $skill = null)
    {
        $this->setWeapon(WeaponFactory::WEAPON_AXE);
        parent::__construct($skill);
    }
}
