<?php

declare(strict_types=1);

namespace App\Dto\Message;

use App\Dto\NotificationMessage\NotificationMessageInterface;

final class EmailMessage implements MessageInterface, EmailMessageInterface
{
    private NotificationMessageInterface $notificationMessage;

    private string $email;

    public function __construct(NotificationMessageInterface $notificationMessage, string $email)
    {
        $this->notificationMessage = $notificationMessage;
        $this->email = $email;
    }

    public function getNotificationMessage(): NotificationMessageInterface
    {
        return $this->notificationMessage;
    }

    public function getEmail(): string
    {
        return $this->email;
    }
}
