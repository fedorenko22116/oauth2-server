<?php declare(strict_types=1);

namespace App\Domain\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity()
 */
class AuthToken
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @var int
     */
    private $id;

    /**
     * @ORM\Column(type="string", unique=true)
     * @var string
     */
    private $token;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var string
     */
    private string $redirectUri;

    /**
     * @ORM\ManyToOne(targetEntity="Client", inversedBy="authTokens")
     * @var Client
     */
    private $client;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="authTokens")
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
