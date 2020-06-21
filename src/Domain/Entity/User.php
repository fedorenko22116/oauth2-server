<?php declare(strict_types=1);

namespace App\Domain\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\EquatableInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Infrastructure\Repository\UserRepository")
 */
class User implements UserInterface, EquatableInterface
{
    public const ROLE_USER = 'ROLE_USER';

    /**
     * @ORM\Id()
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @var int
     */
    protected $id;

    /**
     * @ORM\Column(type="string", unique=true)
     * @Assert\Length(min="4")
     * @var string
     */
    protected $username;

    /**
     * @ORM\Column(type="string")
     * @Assert\Length(min="6")
     * @var string
     */
    protected $password;

    /**
     * @ORM\Column(type="string", unique=true)
     * @Assert\Email()
     * @var string
     */
    protected $email;

    /**
     * @ORM\Column(type="array")
     * @var string[]
     */
    protected $roles = [self::ROLE_USER];

    /**
     * @ORM\OneToMany(targetEntity="RefreshToken", mappedBy="user")
     * @var Collection<RefreshToken>
     */
    protected $refreshTokens;

    /**
     * @ORM\OneToMany(targetEntity="AuthToken", mappedBy="user")
     * @var Collection<AuthToken>
     */
    protected $authTokens;

    /**
     * @ORM\OneToMany(targetEntity="Client", mappedBy="user")
     * @var Collection<Client>
     */
    private $clients;

    /**
     * @var string|null
     */
    private $salt;

    /**
     * @var string
     */
    private $plainPassword = '';

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

    public function setSalt(?string $salt): self
    {
        $this->salt = $salt;

        return $this;
    }

    public function getSalt(): ?string
    {
        return $this->salt;
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

    public function eraseCredentials(): self
    {
        return $this;
    }

    public function isEqualTo(UserInterface $user): bool
    {
        return $user->getUsername() === $this->getUsername();
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getPlainPassword(): string
    {
        return $this->plainPassword;
    }

    /**
     * @return Collection<RefreshToken>|null
     */
    public function getRefreshTokens(): ?Collection
    {
        return $this->refreshTokens;
    }

    /**
     * @param string[] $roles
     * @return self
     */
    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @param Collection<RefreshToken> $refreshTokens
     * @return self
     */
    public function setRefreshTokens(Collection $refreshTokens): self
    {
        $this->refreshTokens = $refreshTokens;

        return $this;
    }

    /**
     * @param Collection<AuthToken> $authTokens
     * @return self
     */
    public function setAuthTokens(Collection $authTokens): self
    {
        $this->authTokens = $authTokens;

        return $this;
    }

    /**
     * @return Collection<AuthToken>|null
     */
    public function getAuthTokens(): ?Collection
    {
        return $this->authTokens;
    }

    /**
     * @return Collection<Client>|null
     */
    public function getClients(): ?Collection
    {
        return $this->clients;
    }
}
