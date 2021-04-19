<?php

namespace Tournament\Weapon;

class Weapon implements WeaponInterface
{
    protected int $damage = 0;
    protected int $blows = 0;
    protected bool $bucklerDestroyer = false;

    public function canAttack(): bool
    {
        return true;
    }

    public function isBucklerDestroyer(): bool
    {
        return $this->bucklerDestroyer;
    }

    public function increaseBlowsCounter(): self
    {
        $this->blows++;

        return $this;
    }

    public function getDamage(): int
    {
        return $this->damage;
    }

    public function getBlows(): int
    {
        return $this->blows;
    }
}