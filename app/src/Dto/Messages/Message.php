<?php

declare(strict_types=1);

namespace App\Dto\Messages;

use App\Dto\NotificationMessageDto;
use Symfony\Component\Validator\Constraints as Assert;

abstract class Message implements MessageInterface
{
    #[Assert\NotBlank]
    private int $notificationId;

    private ?string $email = null;

    private ?string $phone = null;

    #[Assert\Count(min: 1)]
    private array $channels = [];

    public function __construct(NotificationMessageDto $notificationMessageDto)
    {
        $this->setNotificationId($notificationMessageDto->getNotificationId());
        $this->setChannels($notificationMessageDto->getChannels());
        $this->setEmail($notificationMessageDto->getEmail());
        $this->setPhone($notificationMessageDto->getPhone());
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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getChannels(): array
    {
        return $this->channels;
    }

    public function setChannels(array $channels): self
    {
        $this->channels = $channels;

        return $this;
    }
}
