<?php

declare(strict_types=1);

namespace App\Dto\Messages;

use App\Dto\NotificationMessageDto;
use Symfony\Component\Validator\Constraints as Assert;

final class SignUpMessage extends Message
{
    #[Assert\NotBlank]
    #[Assert\Length(min: 6, max: 6)]
    private ?string $code;

    public function __construct(NotificationMessageDto $notificationMessageDto)
    {
        parent::__construct($notificationMessageDto);

        $params = $notificationMessageDto->getParams();
        $this->code = array_key_exists('code', $params) ? (string) $params['code'] : null;
    }

    public function getCode(): string
    {
        return $this->code;
    }
}
