<?php

namespace App\LoanApplication\Infrastructure\Service;

use App\LoanApplication\Domain\Service\RandomGeneratorInterface;
use Random\RandomException;

class RandomGenerator implements RandomGeneratorInterface
{
    /**
     * @throws RandomException
     */
    public function generate(): int
    {
        return random_int(0, 1);
    }
}