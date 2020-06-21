<?php declare(strict_types=1);

namespace App\Application\Http\Request\DTO\AccessToken;

use App\Domain\Entity\AuthToken;
use App\Domain\Entity\Client;
use LSBProject\RequestBundle\Configuration\Entity;
use LSBProject\RequestBundle\Configuration\RequestStorage;
use LSBProject\RequestBundle\Request\AbstractRequest;
use Psr\Container\ContainerInterface;

/**
 * @RequestStorage({"body"})
 */
class AuthorizationCodeRequest extends AbstractRequest
{
    /**
     * @Assert\NotBlank()
     * @Assert\Regex(pattern="/^(authorization_code)$/")
     */
    public string $grantType;

    /**
     * @Assert\Url()
     */
    public string $redirectUri;

    /**
     * @Entity(expr="repository.findOneByToken(token)", mapping={"token": "code"})
     */
    public AuthToken $token;

    /**
     * @Entity(options={"id": "client_id"})
     */
    public ?Client $client;

    public function validate(ContainerInterface $container): bool
    {
        return !($this->token->getRedirectUri() && $this->redirectUri !== $this->token->getRedirectUri());
    }
}
