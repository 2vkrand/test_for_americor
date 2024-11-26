<?php

namespace App\LoanApplication\Domain\Service;

interface RandomGeneratorInterface
{
    public function generate(): int;
}