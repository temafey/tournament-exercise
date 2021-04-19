<?php


namespace Tournament\Skill;

use Tournament\Fighter;

interface SkillInterface
{
    public function getModifiedAttackDamage(int $damage, Fighter $fighter): int;
}