<?php

declare(strict_types=1);

namespace App\Dto\Message;

interface EmailMessageInterface
{
    public function getEmail(): string;
}
