<?php

namespace App\LoanApplication\Infrastructure\Adapter;

use App\LoanApplication\Domain\Service\NotificationAdapterInterface;

readonly class NotificationBrokerAdapter implements NotificationAdapterInterface
{
    /**
     * @var string
     */
    private string $messageDirectory;

    /**
     * @param string $projectDir
     */
    public function __construct(string $projectDir)
    {
        $this->messageDirectory = $projectDir . '/var/messages/';
        if (!is_dir($this->messageDirectory)) {
            mkdir($this->messageDirectory, 0777, true);
        }
    }

    /**
     * @param string $phoneNumber
     * @param string $message
     * @return bool
     */
    public function sendSms(string $phoneNumber, string $message): bool
    {
        $smsFile = $this->messageDirectory . 'sms.txt';
        $content = sprintf("Phone: %s\nMessage: %s\n\n", $phoneNumber, $message);

        file_put_contents($smsFile, $content, FILE_APPEND);

        return true; // Симуляция успешной отправки
    }

    /**
     * @param string $email
     * @param string $subject
     * @param string $message
     * @return bool
     */
    public function sendEmail(string $email, string $subject, string $message): bool
    {
        $emailFile = $this->messageDirectory . 'email.txt';
        $content = sprintf("Email: %s\nSubject: %s\nMessage: %s\n\n", $email, $subject, $message);

        file_put_contents($emailFile, $content, FILE_APPEND);

        return true; // Симуляция успешной отправки
    }
}
