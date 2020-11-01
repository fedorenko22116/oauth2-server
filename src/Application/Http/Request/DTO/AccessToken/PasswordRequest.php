<?php

declare(strict_types=1);

namespace App\Application\Http\Request\DTO\AccessToken;

use App\Domain\Client\Entity\Client;
use App\Domain\Scope\Entity\Scope;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use LSBProject\RequestBundle\Configuration\RequestStorage;
use LSBProject\RequestBundle\Request\AbstractRequest;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @RequestStorage({RequestStorage::BODY})
 */
class PasswordRequest extends AbstractRequest
{
    public const GRANT_TYPE = 'password';

    /**
     * @Assert\EqualTo(PasswordRequest::GRANT_TYPE)
     */
    public string $grantType;

    /**
     * @Assert\NotBlank()
     */
    public string $username;

    /**
     * @Assert\NotBlank()
     */
    public string $password;
    public string $scope = Scope::INFO;

    /**
     * @RequestStorage({RequestStorage::HEAD})
     */
    public Client $client;

    /**
     * @return Collection<string>
     */
    public function getScopes(): Collection
    {
        return new ArrayCollection(array_map('trim', explode(',', $this->scope)));
    }
}
