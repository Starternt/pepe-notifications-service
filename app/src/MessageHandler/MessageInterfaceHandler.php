<?php

declare(strict_types=1);

namespace App\MessageHandler;

use App\Dto\Message\MessageInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class MessageInterfaceHandler
{
    public function __invoke(MessageInterface $message): void
    {
        dump($message);

        exit;
    }
}
