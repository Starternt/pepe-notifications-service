<?php

declare(strict_types=1);

namespace App\Dto\NotificationMessage;

interface NotificationMessageInterface
{
    public const CHANNEL_EMAIL = 'email';
    public const CHANNEL_SMS = 'sms';
    public const CHANNEL_TELEGRAM = 'online';

    public function getNotificationId(): int;
}
