<?php


namespace Tournament\Skill;

use JetBrains\PhpStorm\Pure;
use Tournament\Fighter;

class Veteran implements SkillInterface
{
    protected const BERSERK_HIT_POINTS_PERCENTAGE_THRESHOLD = 0.3;
    protected const DAMAGE_MULTIPLIER = 2;

    #[Pure] public function getModifiedAttackDamage(int $damage, Fighter $fighter): int
    {
        if ($fighter->hitPoints() <
            $fighter->getInitialHitPoints() * self::BERSERK_HIT_POINTS_PERCENTAGE_THRESHOLD) {
            $damage *= self::DAMAGE_MULTIPLIER;
        }

        return $damage;
    }
}