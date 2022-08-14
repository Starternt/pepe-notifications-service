<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\NotificationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as Orm;

#[Orm\Entity(repositoryClass: NotificationRepository::class)]
#[Orm\Table(name: 'notifications')]
class Notification
{
    // Identifiers
    public const REGISTRATION = 1;

    // Channels
    public const CHANNEL_SMS = 1;
    public const CHANNEL_EMAIL = 2;
    public const CHANNEL_TELEGRAM = 3;

    #[Orm\Id]
    #[Orm\GeneratedValue]
    #[Orm\Column(type: Types::INTEGER)]
    private int $id;

    #[Orm\Column(type: Types::STRING, length: 1000, nullable: true)]
    private ?string $description = null;

    #[Orm\Column(type: Types::BOOLEAN, nullable: false)]
    private bool $isSms = false;

    #[Orm\Column(type: Types::BOOLEAN, nullable: false)]
    private bool $isEmail = false;

    #[Orm\Column(type: Types::BOOLEAN, nullable: false)]
    private bool $isTelegram = false;

    #[Orm\Column(type: Types::TEXT, nullable: true)]
    private ?string $templateSms = null;

    #[Orm\Column(type: Types::TEXT, nullable: true)]
    private ?string $templateEmail = null;

    #[Orm\Column(type: Types::TEXT, nullable: true)]
    private ?string $templateTelegram = null;

    public function __construct(int $id)
    {
        $this->id = $id;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function isSms(): bool
    {
        return $this->isSms;
    }

    public function setIsSms(bool $isSms): self
    {
        $this->isSms = $isSms;

        return $this;
    }

    public function isEmail(): bool
    {
        return $this->isEmail;
    }

    public function setIsEmail(bool $isEmail): self
    {
        $this->isEmail = $isEmail;

        return $this;
    }

    public function isTelegram(): bool
    {
        return $this->isTelegram;
    }

    public function setIsTelegram(bool $isTelegram): self
    {
        $this->isTelegram = $isTelegram;

        return $this;
    }

    public function getTemplateSms(): ?string
    {
        return $this->templateSms;
    }

    public function setTemplateSms(?string $templateSms): self
    {
        $this->templateSms = $templateSms;

        return $this;
    }

    public function getTemplateEmail(): ?string
    {
        return $this->templateEmail;
    }

    public function setTemplateEmail(?string $templateEmail): self
    {
        $this->templateEmail = $templateEmail;

        return $this;
    }

    public function getTemplateTelegram(): ?string
    {
        return $this->templateTelegram;
    }

    public function setTemplateTelegram(?string $templateTelegram): self
    {
        $this->templateTelegram = $templateTelegram;

        return $this;
    }
}
