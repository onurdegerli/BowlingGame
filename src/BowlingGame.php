<?php

namespace PF;

use RuntimeException;

class BowlingGame
{
    private const MIN_SCORE = 0;
    private const MAX_SCORE = 10;

    private array $rolls = [];

    public function roll(int $score): void
    {
        if ($score < self::MIN_SCORE) {
            throw new RuntimeException('Score must be greater than ' . self::MIN_SCORE);
        }

        if ($score > self::MAX_SCORE) {
            throw new RuntimeException('Score must be smaller than ' . self::MAX_SCORE);
        }

        $this->rolls[] = $score;
    }

    public function getScore(): int
    {
        $score = 0;
        $roll = 0;

        for ($frame = 0; $frame < 10; $frame++) {
            if ($this->isStrike($roll)) {
                $score += self::MAX_SCORE + $this->getStrikeBonus($roll);
                $roll++;
                continue;
            }

            if ($this->isSpare($roll)) {
                $score += $this->getSpareBonus($roll);
            }

            $score += $this->getNormalScore($roll);
            $roll += 2;
        }

        return $score;
    }

    public function getNormalScore(int $roll): int
    {
        return $this->rolls[$roll] + $this->rolls[$roll + 1];
    }

    public function isSpare(int $roll): bool
    {
        return $this->getNormalScore($roll) === self::MAX_SCORE;
    }

    public function getSpareBonus(int $roll): int
    {
        return $this->rolls[$roll + 2];
    }

    public function getStrikeBonus(int $roll): int
    {
        return $this->rolls[$roll + 1] + $this->rolls[$roll + 2];
    }

    public function isStrike(int $roll): bool
    {
        return $this->rolls[$roll] === 10;
    }
}