<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\SystemRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

#[Orm\Entity(repositoryClass: SystemRepository::class)]
#[Orm\Table(name: 'system_users')]
#[UniqueEntity('apiKey')]
class System implements UserInterface
{
    public const ROLE_SYSTEM = 'ROLE_SYSTEM';

    #[ORM\Id, ORM\Column(type: 'integer'), ORM\GeneratedValue]
    private ?int $id = null;

    #[Orm\Column(type: Types::STRING, length: 255, nullable: false)]
    #[Assert\Length(max: 255)]
    private string $description = '';

    #[Orm\Column(type: Types::STRING, length: 32, nullable: false)]
    #[Assert\NotBlank]
    #[Assert\Length(min: 32, max: 32)]
    private string $apiKey = '';

    #[Orm\ManyToOne(targetEntity: User::class)]
    #[Orm\JoinColumn(name: 'created_by', referencedColumnName: 'id', nullable: false)]
    private User $user;

    #[Orm\Column(name: 'created_at', type: Types::DATETIME_IMMUTABLE)]
    private \DateTimeInterface $createdAt;

    #[Orm\Column(name: 'updated_at', type: Types::DATETIME_MUTABLE)]
    private \DateTimeInterface $updatedAt;

    public function __construct(User $user)
    {
        $this->user = $user;
        $this->createdAt = new \DateTimeImmutable();
        $this->updatedAt = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getApiKey(): string
    {
        return $this->apiKey;
    }

    public function setApiKey(string $apiKey): self
    {
        $this->apiKey = $apiKey;

        return $this;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getCreatedAt(): \DateTimeInterface
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): \DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getRoles(): array
    {
        return [self::ROLE_SYSTEM];
    }

    public function eraseCredentials(): void
    {
    }

    public function getUserIdentifier(): string
    {
        return $this->apiKey;
    }
}
