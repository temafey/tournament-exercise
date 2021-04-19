<?php

namespace Tournament\Skill;

class SkillFactory
{
    protected const SKILL_VICIOUS = 'Vicious';
    protected const SKILL_VETERAN = 'Veteran';

    public static function get(string $skillName): SkillInterface
    {
        return match ($skillName) {
            self::SKILL_VICIOUS => new Vicious(),
            self::SKILL_VETERAN => new Veteran(),
            default => throw new \InvalidArgumentException("Unknown skill '{$skillName}'"),
        };
    }

}