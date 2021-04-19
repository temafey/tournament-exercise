<?php


namespace Tournament\Skill;


use JetBrains\PhpStorm\Pure;
use Tournament\Fighter;

class Vicious implements SkillInterface
{
    protected const MAX_BLOW_COUNTER = 2;
    protected const DAMAGE_INCREASE = 20;

    public function getModifiedAttackDamage(int $damage, Fighter $fighter): int
    {
        $weapon = $fighter->getWeapon();
        if ($weapon->getBlows() <= self::MAX_BLOW_COUNTER) {
            $damage += self::DAMAGE_INCREASE;
        }

        return $damage;
    }
}