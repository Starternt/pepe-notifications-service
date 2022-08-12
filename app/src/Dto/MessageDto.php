<?php

declare(strict_types=1);

namespace App\Dto;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Controller\Action\CreateNotificationAction;

#[ApiResource(
    collectionOperations: [
        'get',
        'post' => [
            'controller' => CreateNotificationAction::class,
            'path' => '/notifications',
        ],
    ],
    itemOperations: [
        'get',
    ],
)]
final class MessageDto
{
    private int $id = 1;

    private ?int $notificationId = null;

    private ?string $email = null;

    private ?string $phone = null;

    private array $params = [];

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getNotificationId(): ?int
    {
        return $this->notificationId;
    }

    public function setNotificationId(?int $notificationId): self
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

    public function getParams(): array
    {
        return $this->params;
    }

    public function setParams(array $params): self
    {
        $this->params = $params;

        return $this;
    }
}
