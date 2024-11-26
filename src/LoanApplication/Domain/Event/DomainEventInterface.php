<?php

namespace App\LoanApplication\Domain\Event;

interface DomainEventInterface
{
    public function occurredOn(): \DateTimeImmutable;
}