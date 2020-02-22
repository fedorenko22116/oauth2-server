<?php declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\EquatableInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User implements UserInterface, EquatableInterface
{
    public const ROLE_USER = 'ROLE_USER';

    /**
     * @ORM\Id()
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected int $id;

    /**
     * @ORM\Column(type="string")
     * @Assert\Length(min="6")
     */
    protected string $password;

    /**
     * @ORM\Column(type="string", unique=true)
     * @Assert\Length(min="4")
     */
    protected string $username;

    /**
     * @ORM\Column(type="string", unique=true)
     * @Assert\Email()
     */
    protected string $email;

    /**
     * @ORM\Column(type="array")
     * @var string[]
     */
    protected array $roles;

    /**
     * @ORM\OneToMany(targetEntity="RefreshToken", mappedBy="user")
     * @var RefreshToken[]
     */
    protected array $refreshTokens;

    private ?string $salt;
    private string $plainPassword = '';

    public function __construct(string $username, string $email, string $password, array $roles = [self::ROLE_USER])
    {
        $this->username = $username;
        $this->email = $email;
        $this->plainPassword = $password;
        $this->roles = $roles;
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

    public function getEmail(): string
    {
        return $this->email;
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
}
