<?php

namespace Tournament\Equipment;

class Armor
{
    protected const RECEIVED_DAMAGE_REDUCE = 3;
    protected const ATTACK_DAMAGE_REDUCE = 1;

    public function getReducedReceivedDamage(int $damage): int
    {
        return $damage - self::RECEIVED_DAMAGE_REDUCE;
    }

    public function getReducedAttackDamage(int $damage): int
    {
        return $damage - self::ATTACK_DAMAGE_REDUCE;
    }
}