<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\ORMFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture implements ORMFixtureInterface
{
    public function __construct(private UserPasswordHasherInterface $hasher)
    {
    }

    public function load(ObjectManager $manager): void
    {
        foreach ($this->getUsersData() as $userData) {
            $user = (new User())
                ->setUsername($userData['username'])
                ->setUpdatedAt($userData['updated_at'])
            ;
            $user->setPassword($this->hasher->hashPassword($user, $userData['password']));

            if (!empty($userData['roles'])) {
                foreach ($userData['roles'] as $role) {
                    $user->addRole($role);
                }
            }
            $manager->persist($user);
        }

        $manager->flush();
    }

    private function getUsersData(): array
    {
        $currentDateTime = new \DateTimeImmutable();

        return [
            [
                'username' => 'admin',
                'password' => '123',
                'roles' => [User::ROLE_ADMIN],
                'updated_at' => $currentDateTime,
            ],
        ];
    }
}
