<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\PasswordHasher\Hasher\PasswordHasherAwareInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

#[Gedmo\SoftDeleteable(fieldName: 'deletedAt')]
#[Orm\Entity(repositoryClass: UserRepository::class)]
#[Orm\Table(name: 'users')]
#[UniqueEntity('username')]
class User implements PasswordAuthenticatedUserInterface, PasswordHasherAwareInterface, UserInterface
{
    use SoftDeleteableEntity;

    public const ROLE_ADMIN = 'ROLE_ADMIN';

    public const ROLES = [
        self::ROLE_ADMIN => 'Admin',
    ];

    #[ORM\Id, ORM\Column(type: 'integer'), ORM\GeneratedValue]
    private ?int $id = null;

    #[Orm\Column(type: Types::STRING, length: 180, unique: true, nullable: false)]
    #[Assert\NotBlank]
    private string $username = '';

    /**
     * @var string[]
     */
    #[Orm\Column(type: Types::JSON)]
    private array $roles = [];

    #[Orm\Column(type: Types::STRING, length: 100, nullable: false)]
    private string $password = '';

    #[Orm\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $updatedAt = null;

    private ?string $plainPassword = null;

    public function __construct()
    {
    }

    public function __toString(): string
    {
        return sprintf('%s', $this->username);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function setUsername(string $username): static
    {
        $this->username = $username;

        return $this;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getRoles(): array
    {
        $roles = $this->roles;

        // we need to make sure to have at least one role
        $roles[] = self::ROLE_ADMIN;

        return array_unique($roles);
    }

    public function addRole(string $role): self
    {
        $role = strtoupper($role);
        if (self::ROLE_ADMIN === $role) {
            return $this;
        }

        if (!\in_array($role, $this->roles, true)) {
            $this->roles[] = $role;
        }

        return $this;
    }

    public function removeRole(string $role): self
    {
        if (false !== $key = array_search(strtoupper($role), $this->roles, true)) {
            unset($this->roles[$key]);
            $this->roles = array_values($this->roles);
        }

        return $this;
    }

    public function hasRole(string $role): bool
    {
        return \in_array($role, $this->getRoles(), true);
    }

    public function isAdmin(): bool
    {
        return !empty(array_intersect($this->getRoles(), [self::ROLE_ADMIN]));
    }

    public function eraseCredentials(): self
    {
        $this->plainPassword = null;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getPasswordHasherName(): ?string
    {
        return null;
    }

    public function getUserIdentifier(): string
    {
        return $this->username;
    }

    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }

    public function setPlainPassword(?string $plainPassword): self
    {
        $this->plainPassword = $plainPassword;

        return $this;
    }
}
