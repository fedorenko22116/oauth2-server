<?php

declare(strict_types=1);

namespace App\Domain\AuthToken\Entity;

use App\Domain\Client\Entity\Client;
use Symfony\Component\Security\Core\User\UserInterface;

class AuthToken
{
    protected UserInterface $user;
    private int $id;
    private string $token;
    private string $redirectUri;
    private Client $client;

    public function __construct(string $token, Client $client, UserInterface $user, string $redirectUri)
    {
        $this->token = $token;
        $this->client = $client;
        $this->user = $user;
        $this->redirectUri = $redirectUri;
    }

    public function getToken(): string
    {
        return $this->token;
    }

    public function getClient(): Client
    {
        return $this->client;
    }

    public function getUser(): UserInterface
    {
        return $this->user;
    }

    public function getRedirectUri(): ?string
    {
        return $this->redirectUri;
    }
}
