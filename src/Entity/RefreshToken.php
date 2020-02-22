<?php declare(strict_types=1);

namespace App\Entity;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
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

    /**
     * @ORM\ManyToMany(targetEntity="Scope")
     * @ORM\JoinTable(name="refresh_token_scope",
     *      joinColumns={@ORM\JoinColumn(name="refresh_token_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="scope_id", referencedColumnName="id")}
     * )
     * @var ArrayCollection<Scope>
     */
    protected ArrayCollection $scopes;

    /**
     * @param ArrayCollection<Scope> $scopes
     */
    public function __construct(string $token, DateTime $expires, UserInterface $user, ArrayCollection $scopes)
    {
        $this->token = $token;
        $this->expires = $expires;
        $this->user = $user;
        $this->scopes = $scopes;
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
