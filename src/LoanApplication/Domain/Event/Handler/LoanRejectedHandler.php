<?php

namespace App\LoanApplication\Domain\Event\Handler;

use App\LoanApplication\Domain\Event\LoanRejected;
use App\LoanApplication\Domain\Service\NotificationAdapterInterface;

readonly class LoanRejectedHandler
{
    /**
     * @param NotificationAdapterInterface $notificationAdapter
     */
    public function __construct(
        private NotificationAdapterInterface $notificationAdapter
    )
    {}

    /**
     * @param LoanRejected $event
     * @return void
     */
    public function handle(LoanRejected $event): void
    {
        $clientInfo = $event->getClientInfo();
        $this->notificationAdapter->sendEmail(
            $clientInfo->getEmail(),
            'Loan Rejected',
            'Unfortunately, your loan application has been rejected.'
        );
        $this->notificationAdapter->sendSms(
            $clientInfo->getPhoneNumber(),
            'We regret to inform you that your loan application has been rejected.'
        );
    }
}