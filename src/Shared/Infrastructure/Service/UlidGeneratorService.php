<?php

namespace App\Shared\Infrastructure\Service;

use App\Clients\Domain\Service\UlidGeneratorInterface;
use Symfony\Component\Uid\Ulid;

class UlidGeneratorService implements UlidGeneratorInterface
{
    /**
     * @return string
     */
    public function generate(): string
    {
        return (string) new Ulid();
    }
}
