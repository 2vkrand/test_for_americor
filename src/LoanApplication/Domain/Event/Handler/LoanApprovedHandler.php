<?php

namespace App\LoanApplication\Domain\Event\Handler;

use App\LoanApplication\Domain\Event\LoanApproved;
use App\LoanApplication\Domain\Service\NotificationAdapterInterface;

readonly class LoanApprovedHandler
{
    /**
     * @param NotificationAdapterInterface $notificationAdapter
     */
    public function __construct(
        private NotificationAdapterInterface $notificationAdapter
    )
    {}
    /**
     * @param LoanApproved $event
     * @return void
     */
    public function handle(LoanApproved $event): void
    {
        $clientInfo = $event->getClientInfo();
        $this->notificationAdapter->sendEmail(
            $clientInfo->getEmail(),
            'Loan Approved',
            'Congratulations, your loan application has been approved!'
        );
        $this->notificationAdapter->sendSms(
            $clientInfo->getPhoneNumber(),
            'Your loan application has been approved.'
        );
    }
}