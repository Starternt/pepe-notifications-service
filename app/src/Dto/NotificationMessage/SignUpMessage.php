<?php

declare(strict_types=1);

namespace App\Dto\NotificationMessage;

use App\Dto\NotificationMessageDtoInterface;
use Symfony\Component\Validator\Constraints as Assert;

final class SignUpMessage extends AbstractNotificationMessage
{
    #[Assert\NotBlank]
    #[Assert\Length(min: 6, max: 6)]
    private string $code;

    public function __construct(NotificationMessageDtoInterface $notificationMessageDto)
    {
        parent::__construct($notificationMessageDto);

        $params = $notificationMessageDto->getParams();
        $this->code = \array_key_exists('code', $params) ? (string) $params['code'] : '';
    }

    public function getCode(): string
    {
        return $this->code;
    }
}
