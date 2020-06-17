<?php declare(strict_types=1);

namespace App\Domain\Entity;

use DateTime;
use Doctrine\Common\Collections\Collection;
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
     * @var int
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    protected $token;

    /**
     * @ORM\Column(type="datetime")
     * @var DateTime
     */
    protected $expires;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="refreshTokens")
     * @var UserInterface
     */
    protected $user;

    /**
     * @ORM\ManyToMany(targetEntity="Scope")
     * @ORM\JoinTable(name="refresh_token_scope",
     *      joinColumns={@ORM\JoinColumn(name="refresh_token_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="scope_id", referencedColumnName="id")}
     * )
     * @var Collection<Scope>
     */
    protected $scopes;

    /**
     * @param Collection<Scope> $scopes
     */
    public function __construct(string $token, DateTime $expires, UserInterface $user, Collection $scopes)
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
