<?php declare(strict_types=1);

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity()
 * @UniqueEntity("token")
 */
class RefreshToken
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected int $id;

    /** @ORM\Column(type="string") */
    protected string $token;

    /** @ORM\Column(type="datetime") */
    protected DateTime $expires;

    /** @ORM\ManyToOne(targetEntity="User", inversedBy="refreshTokens") */
    protected UserInterface $user;

    public function __construct(string $token, DateTime $expires, UserInterface $user)
    {
        $this->token = $token;
        $this->expires = $expires;
        $this->user = $user;
    }

    public function getExpires(): DateTime
    {
        return $this->expires;
    }

    public function getToken(): string
    {
        return $this->token;
    }
}
