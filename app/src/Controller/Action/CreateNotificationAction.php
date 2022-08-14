<?php

declare(strict_types=1);

namespace App\Controller\Action;

use ApiPlatform\Core\Validator\ValidatorInterface;
use App\Dto\Messages\MessageInterface;
use App\Dto\NotificationMessageDto;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class CreateNotificationAction extends AbstractController
{
    public function __construct(private readonly ValidatorInterface $validator)
    {
    }

    public function __invoke(NotificationMessageDto $data): NotificationMessageDto
    {
        $validationGroups = ['Default'];
        $channels = $data->getChannels();

        if (in_array(MessageInterface::CHANNEL_SMS, $channels)) {
            $validationGroups[] = NotificationMessageDto::VALIDATION_PHONE;
        }

        if (in_array(MessageInterface::CHANNEL_EMAIL, $channels)) {
            $validationGroups[] = NotificationMessageDto::VALIDATION_EMAIL;
        }

        $this->validator->validate($data, ['groups' => $validationGroups]);

        try {
            $message = $data->createMessage();
        } catch (\Exception $e) {
            throw $e; // TODO
        }

        $this->validator->validate($message);

        return $data;
    }
}
