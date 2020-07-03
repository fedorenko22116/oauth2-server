<?php declare(strict_types=1);

namespace App\Domain\User\Entity;

use App\Domain\AuthToken\Entity\AuthToken;
use App\Domain\Client\Entity\Client;
use App\Domain\RefreshToken\Entity\RefreshToken;
use Doctrine\Common\Collections\Collection;
use EasyCorp\Bundle\EasyAdminBundle\Contracts\Collection\CollectionInterface;
use Symfony\Component\Security\Core\User\EquatableInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

class User implements UserInterface, EquatableInterface
{
    public const ROLE_USER = 'ROLE_USER';

    protected int $id = 0;

    /**
     * @Assert\Length(min="4")
     */
    protected string $username = '';

    /**
     * @Assert\Length(min="6")
     */
    protected string $password = '';

    /**
     * @Assert\Email()
     */
    protected string $email = '';

    /**
     * @var string[]
     */
    protected array $roles = [self::ROLE_USER];

    /**
     * @var CollectionInterface<RefreshToken>|null
     */
    protected ?CollectionInterface $refreshTokens;

    /**
     * @var CollectionInterface<AuthToken>|null
     */
    protected ?CollectionInterface $authTokens;

    /**
     * @var CollectionInterface<Client>|null
     */
    private ?CollectionInterface $clients;

    private ?string $salt;
    private string $plainPassword = '';

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
     * @return CollectionInterface<RefreshToken>|null
     */
    public function getRefreshTokens(): ?CollectionInterface
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
     * @param CollectionInterface<RefreshToken> $refreshTokens
     * @return self
     */
    public function setRefreshTokens(CollectionInterface $refreshTokens): self
    {
        $this->refreshTokens = $refreshTokens;

        return $this;
    }

    /**
     * @param CollectionInterface<AuthToken> $authTokens
     * @return self
     */
    public function setAuthTokens(CollectionInterface $authTokens): self
    {
        $this->authTokens = $authTokens;

        return $this;
    }

    /**
     * @return CollectionInterface<AuthToken>|null
     */
    public function getAuthTokens(): ?Collection
    {
        return $this->authTokens;
    }

    /**
     * @return CollectionInterface<Client>|null
     */
    public function getClients(): ?Collection
    {
        return $this->clients;
    }
}
