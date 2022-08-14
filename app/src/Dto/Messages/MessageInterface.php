<?php

declare(strict_types=1);

namespace App\Dto\Messages;

use App\Dto\NotificationMessageDto;

interface MessageInterface
{
    public const CHANNEL_EMAIL = 'email';
    public const CHANNEL_SMS = 'sms';
    public const CHANNEL_TELEGRAM = 'online';

    public function __construct(NotificationMessageDto $notificationMessageDto);

    public function getNotificationId(): int;

    public function getPhone(): ?string;

    public function getEmail(): ?string;

    public function getChannels(): array;
}
