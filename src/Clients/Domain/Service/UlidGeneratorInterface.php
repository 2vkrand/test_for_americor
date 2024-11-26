<?php

namespace App\Clients\Domain\Service;

interface UlidGeneratorInterface
{
    public function generate(): string;
}
