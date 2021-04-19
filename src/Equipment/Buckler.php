<?php


namespace Tournament\Equipment;

class Buckler
{
    protected const INITIAL_HIT_POINTS = 3;

    /**
     * Current shield "health"
     */
    protected int $hitPoints = self::INITIAL_HIT_POINTS;
    protected bool $readyToBlock = true;

    public function canBlock(): bool
    {
        return $this->hitPoints > 0 && $this->readyToBlock;
    }

    public function reduceHitPoints(): self
    {
        $this->hitPoints--;

        return $this;
    }

    public function updateReadyToBlockStatus(): self
    {
        $this->readyToBlock = !$this->readyToBlock;

        return $this;
    }

    public function isDestroyed(): bool
    {
        return $this->hitPoints === 0;
    }

}