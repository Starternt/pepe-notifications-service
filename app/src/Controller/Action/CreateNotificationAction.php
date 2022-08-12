<?php

declare(strict_types=1);

namespace App\Controller\Action;

use App\Dto\MessageDto;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class CreateNotificationAction extends AbstractController
{
    public function __construct(private ValidatorInterface $validator)
    {
    }

    public function __invoke(MessageDto $data)
    {
        dump($data);

        exit;

        /** @var User $user */
        $user = $this->getUser();

        $this->postService->create($data, $user);

        $this->validator->validate($data);

        return $data;
    }
}
