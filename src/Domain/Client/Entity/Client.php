<?php

declare(strict_types=1);

namespace App\Domain\Client\Entity;

use App\Domain\AuthToken\Entity\AuthToken;
use App\Domain\Scope\Entity\Scope;
use App\Domain\User\Entity\User;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;

class Client
{
    protected string $id;
    protected string $secret;

    /**
     * @Assert\Url()
     */
    protected string $host;

    /**
     * @var string[]
     */
    protected array $grantTypes = [];

    /**
     * @var Collection<Scope>
     */
    protected Collection $scopes;

    /**
     * @var Collection<AuthToken>
     */
    protected Collection $authTokens;
    protected User $user;

    public function getId(): string
    {
        return $this->id;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function getSecret(): string
    {
        return $this->secret;
    }

    public function setSecret(string $secret): self
    {
        $this->secret = $secret;

        return $this;
    }

    public function getHost(): string
    {
        return $this->host;
    }

    /**
     * @return array|string[]
     */
    public function getGrantTypes(): array
    {
        return $this->grantTypes;
    }

    /**
     * @return Collection<Scope>
     */
    public function getScopes(): Collection
    {
        return $this->scopes;
    }

    /**
     * @return Collection<AuthToken>
     */
    public function getAuthTokens(): Collection
    {
        return $this->authTokens;
    }

    public function setHost(string $host): void
    {
        $this->host = $host;
    }

    /**
     * @param string[] $grantTypes
     */
    public function setGrantTypes(array $grantTypes): void
    {
        $this->grantTypes = $grantTypes;
    }

    /**
     * @param Collection<Scope> $scopes
     */
    public function setScopes(Collection $scopes): void
    {
        $this->scopes = $scopes;
    }

    /**
     * @param Collection<AuthToken> $authTokens
     */
    public function setAuthTokens(Collection $authTokens): void
    {
        $this->authTokens = $authTokens;
    }
}
