<?php

declare(strict_types=1);

namespace App\Dto\Message;

use App\Dto\NotificationMessage\NotificationMessageInterface;

interface MessageInterface
{
    public function getNotificationMessage(): NotificationMessageInterface;
}
