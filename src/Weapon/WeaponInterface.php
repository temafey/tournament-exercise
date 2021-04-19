<?php


namespace Tournament\Weapon;


interface WeaponInterface
{
    public function canAttack(): bool;

    public function isBucklerDestroyer(): bool;

    public function increaseBlowsCounter(): self;

    public function getDamage(): int;

    public function getBlows(): int;
}