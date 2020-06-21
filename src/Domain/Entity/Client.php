<?php declare(strict_types=1);

namespace App\Domain\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/** @ORM\Entity(repositoryClass="App\Infrastructure\Repository\ClientRepository") */
class Client
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="string")
     * @ORM\GeneratedValue(strategy="UUID")
     * @var string
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    protected $secret;

    /**
     * @ORM\Column(type="string")
     * @Assert\Url()
     * @var string
     */
    protected $host;

    /**
     * @ORM\Column(type="array")
     * @var string[]
     */
    protected $grantTypes = [];

    /**
     * @ORM\ManyToMany(targetEntity="Scope")
     * @ORM\JoinTable(name="client_scope",
     *      joinColumns={@ORM\JoinColumn(name="client_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="scope_id", referencedColumnName="id")}
     * )
     * @var Collection<Scope>
     */
    protected $scopes;

    /**
     * @ORM\OneToMany(targetEntity="AuthToken", mappedBy="client", orphanRemoval=true)
     * @var Collection<AuthToken>
     */
    protected $authTokens;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="clients")
     * @var User
     */
    protected $user;

    public function getId(): string
    {
        return $this->id;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function getSecret(): string
    {
        return $this->secret;
    }

    public function setSecret(string $secret): self
    {
        $this->secret = $secret;

        return $this;
    }

    public function getHost(): string
    {
        return $this->host;
    }

    public function getGrantTypes(): array
    {
        return $this->grantTypes;
    }

    /**
     * @return Collection<Scope>
     */
    public function getScopes(): ?Collection
    {
        return $this->scopes;
    }

    /**
     * @return Collection<AuthToken>
     */
    public function getAuthTokens(): ?Collection
    {
        return $this->authTokens;
    }

    /**
     * @param string $host
     */
    public function setHost(string $host): void
    {
        $this->host = $host;
    }

    /**
     * @param string[] $grantTypes
     */
    public function setGrantTypes(array $grantTypes): void
    {
        $this->grantTypes = $grantTypes;
    }

    /**
     * @param Collection<Scope> $scopes
     */
    public function setScopes(Collection $scopes): void
    {
        $this->scopes = $scopes;
    }

    /**
     * @param Collection<AuthToken> $authTokens
     */
    public function setAuthTokens(Collection $authTokens): void
    {
        $this->authTokens = $authTokens;
    }
}
