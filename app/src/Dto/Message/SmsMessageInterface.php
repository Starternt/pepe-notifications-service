<?php

declare(strict_types=1);

namespace App\Dto\Message;

interface SmsMessageInterface
{
    public function getPhoneNumber(): string;
}
