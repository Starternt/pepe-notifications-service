<?php

declare(strict_types=1);

namespace App\Service\Message;

use App\Dto\Message\EmailMessage;
use App\Dto\Message\MessageInterface;
use App\Dto\NotificationMessage\NotificationMessageInterface;
use App\Dto\NotificationMessageDtoInterface;

final class EmailMessageFactory extends AbstractMessageFactory
{
    public function create(NotificationMessageInterface $notificationMessage, NotificationMessageDtoInterface $notificationMessageDto): MessageInterface
    {
        return new EmailMessage($notificationMessage, $notificationMessageDto->getEmail());
    }
}
