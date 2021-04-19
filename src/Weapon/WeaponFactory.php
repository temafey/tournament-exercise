<?php


namespace Tournament\Weapon;


class WeaponFactory
{
    public const WEAPON_SWORD = 'sword';
    public const WEAPON_AXE = 'axe';
    public const WEAPON_GREAT_SWORD = 'great_sword';

    /**
     * @param string $weaponName
     * @return WeaponInterface
     */
    public static function get(string $weaponName): WeaponInterface
    {
        return match ($weaponName) {
            self::WEAPON_SWORD => new Sword(),
            self::WEAPON_AXE => new Axe(),
            self::WEAPON_GREAT_SWORD => new GreatSword(),
            default => throw new \InvalidArgumentException("Unknown weapon '{$weaponName}'"),
        };
    }

}