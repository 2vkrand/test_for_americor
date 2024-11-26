<?php

namespace App\Shared\Infrastructure\Event;

use App\Shared\Domain\Event\EventDispatcherInterface as CustomEventDispatcherInterface;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface as SymfonyEventDispatcherInterface;

class SymfonyEventDispatcherAdapter implements CustomEventDispatcherInterface
{
    /**
     * @var SymfonyEventDispatcherInterface
     */
    private SymfonyEventDispatcherInterface $eventDispatcher;

    /**
     * @param SymfonyEventDispatcherInterface $eventDispatcher
     */
    public function __construct(SymfonyEventDispatcherInterface $eventDispatcher)
    {
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * @param object $event
     * @return void
     */
    public function dispatch(object $event): void
    {
        $this->eventDispatcher->dispatch($event);
    }
}
