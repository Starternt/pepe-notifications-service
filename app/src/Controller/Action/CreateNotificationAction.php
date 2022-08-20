<?php

declare(strict_types=1);

namespace App\Controller\Action;

use ApiPlatform\Core\Validator\ValidatorInterface;
use App\Dto\NotificationMessage\NotificationMessageInterface;
use App\Dto\NotificationMessageDto;
use App\Dto\NotificationMessageDtoInterface;
use App\Service\Message\EmailMessageFactory;
use App\Service\Message\SmsMessageFactory;
use App\Service\NotificationMessage\NotificationMessageFactory;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Messenger\MessageBusInterface;

final class CreateNotificationAction extends AbstractController
{
    private SmsMessageFactory $smsMessageFactory;
    private EmailMessageFactory $emailMessageFactory;

    public function __construct(
        private readonly ValidatorInterface $validator,
        private readonly LoggerInterface $logger,
        private readonly MessageBusInterface $messageBus
    ) {
        $this->smsMessageFactory = new SmsMessageFactory();
        $this->emailMessageFactory = new EmailMessageFactory();
    }

    public function __invoke(NotificationMessageDto $data): NotificationMessageDto
    {
        $validationGroups = ['Default'];
        $channels = $data->getChannels();

        if (\in_array(NotificationMessageInterface::CHANNEL_SMS, $channels, true)) {
            $validationGroups[] = NotificationMessageDtoInterface::VALIDATION_PHONE;
        }

        if (\in_array(NotificationMessageInterface::CHANNEL_EMAIL, $channels, true)) {
            $validationGroups[] = NotificationMessageDtoInterface::VALIDATION_EMAIL;
        }

        $this->validator->validate($data, ['groups' => $validationGroups]);

        try {
            $notificationMessage = NotificationMessageFactory::create($data);
        } catch (\Exception $e) {
            $this->logger->error(sprintf('Error when tried to create NotificationMessage. %s', $e->getMessage()));

            return $data;
        }

        $this->validator->validate($notificationMessage);

        foreach ($data->getChannels() as $channel) {
            switch ($channel) {
                case NotificationMessageInterface::CHANNEL_SMS:
                    $this->messageBus->dispatch($this->smsMessageFactory->create($notificationMessage, $data));

                    break;

                case NotificationMessageInterface::CHANNEL_EMAIL:
                    $this->messageBus->dispatch($this->emailMessageFactory->create($notificationMessage, $data));

                    break;

                case NotificationMessageInterface::CHANNEL_TELEGRAM:
                    // TODO
                    break;

                default:
                    $this->logger->error(sprintf('Incorrect channel %s', $channel));
            }
        }

        return $data;
    }
}
