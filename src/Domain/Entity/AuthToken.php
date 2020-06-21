<?php declare(strict_types=1);

namespace App\Domain\Entity;

use Symfony\Component\Security\Core\User\UserInterface;

class AuthToken
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $token;

    /**
     * @var string
     */
    private $redirectUri;

    /**
     * @var Client
     */
    private $client;

    /**
     * @var UserInterface
     */
    protected $user;

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
