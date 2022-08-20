<?php

declare(strict_types=1);

namespace App\Service\NotificationMessage;

use App\Dto\NotificationMessage\NotificationMessageInterface;
use App\Dto\NotificationMessage\SignUpMessage;
use App\Dto\NotificationMessageDto;
use App\Dto\NotificationMessageDtoInterface;

class NotificationMessageFactory
{
    /**
     * @throws \Exception
     */
    public static function create(NotificationMessageDtoInterface $messageDto): NotificationMessageInterface
    {
        return match ($messageDto->getType()) {
            NotificationMessageDto::SIGNUP_TYPE => new SignUpMessage($messageDto),
            default => throw new \Exception('Incorrect type.'),
        };
    }
}
