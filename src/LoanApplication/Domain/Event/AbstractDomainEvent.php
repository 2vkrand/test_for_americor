<?php

namespace App\LoanApplication\Domain\Event;

abstract class AbstractDomainEvent implements DomainEventInterface
{
    /**
     * @var \DateTimeImmutable
     */
    private \DateTimeImmutable $occurredOn;

    /**
     *
     */
    public function __construct()
    {
        $this->occurredOn = new \DateTimeImmutable();
    }

    /**
     * @return \DateTimeImmutable
     */
    public function occurredOn(): \DateTimeImmutable
    {
        return $this->occurredOn;
    }
}