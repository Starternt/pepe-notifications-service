<?php

declare(strict_types=1);

namespace App\Dto\NotificationMessage;

use App\Dto\NotificationMessageDtoInterface;
use Symfony\Component\Validator\Constraints as Assert;

abstract class AbstractNotificationMessage implements NotificationMessageInterface
{
    #[Assert\NotBlank]
    private int $notificationId;

    public function __construct(NotificationMessageDtoInterface $notificationMessageDto)
    {
        $this->setNotificationId($notificationMessageDto->getNotificationId());
    }

    public function getNotificationId(): int
    {
        return $this->notificationId;
    }

    public function setNotificationId(int $notificationId): self
    {
        $this->notificationId = $notificationId;

        return $this;
    }
}
