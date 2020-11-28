<?php

declare(strict_types=1);

namespace App\Application\Http\Request\DTO\AccessToken;

use App\Domain\AuthToken\Entity\AuthToken;
use App\Domain\Client\Entity\Client;
use LSBProject\RequestBundle\Configuration\Entity;
use LSBProject\RequestBundle\Configuration\RequestStorage;
use LSBProject\RequestBundle\Request\AbstractRequest;
use OpenApi\Annotations\Property;
use Psr\Container\ContainerInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @RequestStorage({RequestStorage::BODY})
 */
class AuthorizationCodeRequest extends AbstractRequest
{
    public const GRANT_TYPE = 'authorization_code';

    /**
     * @Assert\EqualTo(AuthorizationCodeRequest::GRANT_TYPE)
     */
    public string $grantType;

    /**
     * @Assert\Url()
     */
    public string $redirectUri;

    /**
     * @Property(property="token", type="string")
     * @Entity(expr="repository.findOneByToken(token)", mapping={"token": "code"})
     */
    public AuthToken $token;

    /**
     * @Property(property="client_id", type="string")
     * @Entity(options={"id": "client_id"})
     */
    public ?Client $client;

    public function validate(ContainerInterface $container): bool
    {
        return !($this->token->getRedirectUri() && $this->redirectUri !== $this->token->getRedirectUri());
    }
}
