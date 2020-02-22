<?php declare(strict_types=1);

namespace App\Entity;

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
     */
    private int $id;

    /**
     * @ORM\Column(type="string", unique=true)
     */
    private string $token;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Client", inversedBy="authTokens")
     */
    private Client $client;

    /** @ORM\ManyToOne(targetEntity="User", inversedBy="authTokens") */
    protected UserInterface $user;

    public function __construct(string $token, Client $client, UserInterface $user)
    {
        $this->token = $token;
        $this->client = $client;
        $this->user = $user;
    }

    public function getToken(): string
    {
        return $this->token;
    }
}
