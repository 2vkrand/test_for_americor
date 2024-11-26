<?php

namespace App\LoanApplication\Domain\Service;

interface NotificationAdapterInterface
{
    public function sendSms(string $phoneNumber, string $message): bool;
    public function sendEmail(string $email, string $subject, string $message): bool;
}
