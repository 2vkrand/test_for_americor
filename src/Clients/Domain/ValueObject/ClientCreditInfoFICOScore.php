<?php

namespace App\Clients\Domain\ValueObject;

readonly class ClientCreditInfoFICOScore
{
    /**
     * @param int $score
     */
    public function __construct(private int $score)
    {
        if ($score < 300 || $score > 850) {
            throw new \InvalidArgumentException('FICO Score должен быть в диапазоне от 300 до 850.');
        }
    }

    /**
     * @return int
     */
    public function getValue(): int
    {
        return $this->score;
    }
}
