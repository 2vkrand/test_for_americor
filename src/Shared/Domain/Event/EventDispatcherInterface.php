<?php

namespace App\Shared\Domain\Event;

interface EventDispatcherInterface
{
    public function dispatch(object $event): void;
}
