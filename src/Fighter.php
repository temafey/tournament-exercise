<?php

namespace Tournament;

use JetBrains\PhpStorm\Pure;
use Monolog\Logger;
use Tournament\Equipment\Armor;
use Tournament\Equipment\Buckler;
use Tournament\Skill\SkillFactory;
use Tournament\Skill\SkillInterface;
use Tournament\Tools\LoggerInitializer;
use Tournament\Weapon\WeaponFactory;
use Tournament\Weapon\WeaponInterface;

abstract class Fighter
{
    protected const EQUIPMENT_BUCKLER = 'buckler';
    protected const EQUIPMENT_ARMOR = 'armor';

    protected int $initialHitPoints = 0;
    /**
     * Special Fighter skill
     */
    protected ?SkillInterface $skill = null;
    /**
     * Current hit points
     */
    protected int $hitPoints = 0;
    /**
     * Used weapon
     */
    protected WeaponInterface $weapon;
    /**
     * Used armor
     */
    protected ?Armor $armor = null;
    /**
     * Used buckler
     */
    protected ?Buckler $buckler = null;

    protected Logger $logger;

    public function __construct(string $skill = null)
    {
        null !== $skill && $this->setSkill($skill);
        $this->hitPoints = $this->initialHitPoints;
        $this->logger = LoggerInitializer::get();
    }

    public function getWeapon(): WeaponInterface
    {
        return $this->weapon;
    }

    public function engage(Fighter $enemy): self
    {
        $this->logger->info($this->getFighterName() . ' engaged ' . $enemy->getFighterName());
        $roundNumber = 0;
        while ($this->isAlive() && $enemy->isAlive()) {
            $this->logger->info('Round: ' . ++$roundNumber);
            $this->attack($enemy);
            if ($enemy->isAlive()) {
                $enemy->attack($this);
            }
            $this->logger->info(
                <<<LOG
{$this->getFighterName()} hit points: {$this->hitPoints()}
{$enemy->getFighterName()} hit points: {$enemy->hitPoints()}                
LOG
            );
        }

        return $this;
    }

    public function isAlive(): bool
    {
        return $this->hitPoints > 0;
    }

    public function attack(Fighter $enemy): self
    {
        $this->logger->info($this->getFighterName() . ' attacks ' . $enemy->getFighterName());
        $this->getWeapon()->increaseBlowsCounter();
        if (!$this->weapon->canAttack()) {
            $this->logger->info($this->getFighterName() . ' weapon is not able to blow');

            return $this;
        }
        if ($enemy->canBlock()) {
            $this->logger->info($enemy->getFighterName() . ' blocks the blow');
            $enemy->block($this);
        } else {
            $damage = $this->getDamageModifiedBySkill($this->getWeapon()->getDamage());
            if (null !== $this->armor) {
                $damage = $this->armor->getReducedAttackDamage($damage);
            }
            $this->logger->info($this->getFighterName() . ' delivers damage: ' . $damage);
            $enemy->receiveDamage($damage);
        }
        null !== $enemy->getBuckler() && $enemy->getBuckler()->updateReadyToBlockStatus();

        return $this;
    }

    #[Pure] public function canBlock(): bool
    {
        return null !== $this->buckler && $this->buckler->canBlock();
    }

    public function block(Fighter $enemy): self
    {
        if ($enemy->getWeapon()->isBucklerDestroyer()) {
            $this->buckler->reduceHitPoints();
            if ($this->buckler->isDestroyed()) {
                $this->logger->info($this->getFighterName() . ' buckler is destroyed');
                $this->buckler = null;
            }
        }

        return $this;
    }

    protected function getDamageModifiedBySkill(int $damage): int
    {
        if (null !== $this->skill) {
            $damage = $this->skill->getModifiedAttackDamage($damage, $this);
        }

        return $damage;
    }

    public function receiveDamage(int $damage): self
    {
        if (null !== $this->armor) {
            $damage = $this->armor->getReducedReceivedDamage($damage);
            $this->logger->info($this->getFighterName() . ' delivered damage reduced to: ' . $damage);
        }
        $this->decreaseHitPoints($damage);

        return $this;
    }

    public function getInitialHitPoints(): int
    {
        return $this->initialHitPoints;
    }

    public function hitPoints(): int
    {
        return $this->hitPoints;
    }

    public function equip(string $item): self
    {
        switch ($item) {
            case self::EQUIPMENT_ARMOR:
                $this->armor = new Armor();
                break;
            case self::EQUIPMENT_BUCKLER:
                $this->buckler = new Buckler();
                break;
            default:
                $this->setWeapon($item);
        }

        return $this;
    }

    public function setWeapon(string $weaponName): self
    {
        $this->weapon = WeaponFactory::get($weaponName);

        return $this;
    }

    public function setSkill(string $skillName): self
    {
        $this->skill = SkillFactory::get($skillName);

        return $this;
    }

    public function getBuckler(): ?Buckler
    {
        return $this->buckler;
    }

    public function getFighterName(): string
    {
        $path = explode('\\', get_class($this));

        return array_pop($path);
    }

    protected function decreaseHitPoints($damage): self
    {
        $this->hitPoints = $damage < $this->hitPoints ? $this->hitPoints - $damage : 0;

        return $this;
    }

}