<?php

declare(strict_types=1);

namespace App\Service\Message;

use App\Dto\Message\MessageInterface;
use App\Dto\Message\SmsMessage;
use App\Dto\NotificationMessage\NotificationMessageInterface;
use App\Dto\NotificationMessageDtoInterface;

final class SmsMessageFactory extends AbstractMessageFactory
{
    public function create(NotificationMessageInterface $notificationMessage, NotificationMessageDtoInterface $notificationMessageDto): MessageInterface
    {
        return new SmsMessage($notificationMessage, $notificationMessageDto->getPhone());
    }
}
