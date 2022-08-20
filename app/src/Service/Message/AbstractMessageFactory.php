<?php

declare(strict_types=1);

namespace App\Service\Message;

use App\Dto\Message\MessageInterface;
use App\Dto\NotificationMessage\NotificationMessageInterface;
use App\Dto\NotificationMessageDtoInterface;

abstract class AbstractMessageFactory
{
    abstract public function create(NotificationMessageInterface $notificationMessage, NotificationMessageDtoInterface $notificationMessageDto): MessageInterface;
}
