<?php


namespace Tournament\Weapon;

class GreatSword extends Weapon
{
    protected const SKIP_ATTACK_COUNT = 3;

    protected int $damage = 12;

    public function canAttack(): bool
    {
        return $this->blows === 0 || $this->blows % self::SKIP_ATTACK_COUNT !== 0;
    }
}