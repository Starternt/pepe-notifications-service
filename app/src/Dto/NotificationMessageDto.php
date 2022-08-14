<?php

declare(strict_types=1);

namespace App\Dto;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Controller\Action\CreateNotificationAction;
use App\Dto\Messages\MessageInterface;
use App\Dto\Messages\SignUpMessage;
use Symfony\Component\Validator\Constraints as Assert;

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
final class NotificationMessageDto
{
    public const VALIDATION_PHONE = 'notification:phone';
    public const VALIDATION_EMAIL = 'notification:email';

    private const SIGNUP_TYPE = 'signUp';

    private const TYPES = [
        self::SIGNUP_TYPE => self::SIGNUP_TYPE,
    ];

    private int $id = 1;

    #[Assert\NotBlank]
    private int $notificationId;

    #[Assert\NotBlank]
    #[Assert\Choice(choices: self::TYPES)]
    private string $type;

    #[Assert\NotBlank(groups: [self::VALIDATION_EMAIL])]
    private ?string $email = null;

    #[Assert\NotBlank(groups: [self::VALIDATION_PHONE])]
    private ?string $phone = null;

    #[Assert\NotBlank]
    #[Assert\Count(min: 1)]
    private array $channels = [];

    #[Assert\NotBlank]
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

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

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

    public function getParams(): array
    {
        return $this->params;
    }

    public function setParams(array $params): self
    {
        $this->params = $params;

        return $this;
    }

    /**
     * @throws \Exception
     */
    public function createMessage(): MessageInterface
    {
        return match ($this->type) {
            self::SIGNUP_TYPE => new SignUpMessage($this),
            default => throw new \Exception('Incorrect type.'),
        };
    }
}
