<?php

declare(strict_types=1);

namespace App\Domain\User\Entity;

use App\Domain\AuthToken\Entity\AuthToken;
use App\Domain\Client\Entity\Client;
use App\Domain\RefreshToken\Entity\RefreshToken;
use Doctrine\Common\Collections\Collection;

class User
{
    public const ROLE_USER = 'ROLE_USER';
    public const ROLE_ADMIN = 'ROLE_ADMIN';

    protected int $id = 0;
    protected string $username = '';
    protected string $password = '';
    protected string $email = '';

    /**
     * @var string[]
     */
    protected array $roles = [self::ROLE_USER];

    /**
     * @var Collection<RefreshToken>
     */
    protected Collection $refreshTokens;

    /**
     * @var Collection<AuthToken>
     */
    protected Collection $authTokens;

    /**
     * @var Collection<Client>
     */
    protected Collection $clients;
    protected ?string $salt;
    protected string $plainPassword = '';

    public function setSalt(?string $salt): self
    {
        $this->salt = $salt;

        return $this;
    }

    public function getSalt(): ?string
    {
        return $this->salt;
    }

    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string[]
     */
    public function getRoles(): array
    {
        return $this->roles;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function setPlainPassword(string $plainPassword): self
    {
        $this->plainPassword = $plainPassword;

        return $this;
    }

    public function getPlainPassword(): string
    {
        return $this->plainPassword;
    }

    public function eraseCredentials(): self
    {
        return $this;
    }

    /**
     * @return Collection<RefreshToken>
     */
    public function getRefreshTokens(): Collection
    {
        return $this->refreshTokens;
    }

    /**
     * @param string[] $roles
     */
    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @param Collection<RefreshToken> $refreshTokens
     */
    public function setRefreshTokens(Collection $refreshTokens): self
    {
        $this->refreshTokens = $refreshTokens;

        return $this;
    }

    /**
     * @param Collection<AuthToken> $authTokens
     */
    public function setAuthTokens(Collection $authTokens): self
    {
        $this->authTokens = $authTokens;

        return $this;
    }

    /**
     * @return Collection<AuthToken>
     */
    public function getAuthTokens(): Collection
    {
        return $this->authTokens;
    }

    /**
     * @return Collection<Client>
     */
    public function getClients(): Collection
    {
        return $this->clients;
    }
}
