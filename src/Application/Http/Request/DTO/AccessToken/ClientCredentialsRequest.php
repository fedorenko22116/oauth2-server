<?php

declare(strict_types=1);

namespace App\Application\Http\Request\DTO\AccessToken;

use App\Application\Entity\Client;
use App\Application\Entity\Scope;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use LSBProject\RequestBundle\Configuration\RequestStorage;
use LSBProject\RequestBundle\Request\AbstractRequest;
use OpenApi\Annotations\Property;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @RequestStorage({RequestStorage::BODY})
 */
class ClientCredentialsRequest extends AbstractRequest
{
    public const GRANT_TYPE = 'client_credentials';

    /**
     * @Assert\EqualTo(ClientCredentialsRequest::GRANT_TYPE)
     */
    public string $grantType;
    public string $scope = Scope::INFO;

    /**
     * @Property(property="client_id", type="string")
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
