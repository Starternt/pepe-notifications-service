<?php

declare(strict_types=1);

namespace App\Dto;

interface NotificationMessageDtoInterface
{
    public const VALIDATION_PHONE = 'notification:phone';
    public const VALIDATION_EMAIL = 'notification:email';

    public function getEmail(): ?string;

    public function getPhone(): ?string;

    public function getParams(): array;

    public function getNotificationId(): ?int;
}
