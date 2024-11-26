<?php

namespace App\LoanApplication\Infrastructure\EventListener;

use App\LoanApplication\Domain\Event\Handler\LoanApprovedHandler;
use App\LoanApplication\Domain\Event\Handler\LoanRejectedHandler;
use App\LoanApplication\Domain\Event\LoanApproved;
use App\LoanApplication\Domain\Event\LoanRejected;
use App\LoanApplication\Domain\Service\NotificationAdapterInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

readonly class LoanApplicationSubscriber implements EventSubscriberInterface
{
    /**
     * @param NotificationAdapterInterface $notificationAdapter
     */
    public function __construct(
        private NotificationAdapterInterface $notificationAdapter
    )
    {}

    /**
     * @return string[]
     */
    public static function getSubscribedEvents(): array
    {
        return [
            LoanApproved::class => 'onLoanApproved',
            LoanRejected::class => 'onLoanRejected',
        ];
    }

    /**
     * @param LoanApproved $event
     * @return void
     */
    public function onLoanApproved(LoanApproved $event): void
    {
        (new LoanApprovedHandler($this->notificationAdapter))
            ->handle($event);
    }

    /**
     * @param LoanRejected $event
     * @return void
     */
    public function onLoanRejected(LoanRejected $event): void
    {
        (new LoanRejectedHandler($this->notificationAdapter))
            ->handle($event);
    }
}
