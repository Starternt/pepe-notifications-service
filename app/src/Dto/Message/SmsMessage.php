<?php

declare(strict_types=1);

namespace App\Dto\Message;

use App\Dto\NotificationMessage\NotificationMessageInterface;

final class SmsMessage implements MessageInterface, SmsMessageInterface
{
    private NotificationMessageInterface $notificationMessage;

    private string $phoneNumber;

    public function __construct(NotificationMessageInterface $notificationMessage, string $phoneNumber)
    {
        $this->notificationMessage = $notificationMessage;
        $this->phoneNumber = $phoneNumber;
    }

    public function getNotificationMessage(): NotificationMessageInterface
    {
        return $this->notificationMessage;
    }

    public function getPhoneNumber(): string
    {
        return $this->phoneNumber;
    }
}
