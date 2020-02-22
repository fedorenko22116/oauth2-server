<?php declare(strict_types=1);

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/** @ORM\Entity(repositoryClass="App\Repository\ClientRepository") */
class Client
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected int $id;

    /**
     * @ORM\Column(type="string")
     * @Assert\Url()
     */
    protected string $host;

    /**
     * @ORM\Column(type="array")
     * @var string[]
     */
    protected array $grantTypes;

    /**
     * @ORM\ManyToMany(targetEntity="Scope")
     * @ORM\JoinTable(name="client_scope",
     *      joinColumns={@ORM\JoinColumn(name="client_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="scope_id", referencedColumnName="id")}
     * )
     */
    protected ArrayCollection $scopes;

    /**
     * @Assert\Url()
     */
    private string $redirectUri;

    public function getId(): int
    {
        return $this->id;
    }

    public function getHost(): string
    {
        return $this->host;
    }

    public function getGrantTypes(): array
    {
        return $this->grantTypes;
    }

    public function getRedirectUrl(): string
    {
        return $this->redirectUri;
    }

    /**
     * @return ArrayCollection<self>
     */
    public function getScopes(): ArrayCollection
    {
        return $this->scopes;
    }

    public function setRedirectUri(string $redirectingUrl): void
    {
        $this->redirectingUrl = $redirectingUrl;
    }
}
