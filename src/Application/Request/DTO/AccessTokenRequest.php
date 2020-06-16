<?php declare(strict_types=1);

namespace App\Application\Request\DTO;

use App\Domain\Entity\AuthToken;
use App\Domain\Entity\Client;
use App\Domain\Entity\Scope;
use LSBProject\RequestBundle\Configuration\Entity;
use LSBProject\RequestBundle\Configuration\RequestStorage;
use LSBProject\RequestBundle\Request\AbstractRequest;
use Psr\Container\ContainerInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @RequestStorage({"body"})
 */
class AccessTokenRequest extends AbstractRequest
{
    /**
     * @Assert\NotBlank()
     * @Assert\Regex(pattern="/^(authorization_code|password|client_credentials)$/")
     */
    public string $grantType = '';

    public string $username;
    public string $password;
    public string $scope = Scope::INFO;

    /**
     * @Assert\Url()
     */
    public string $redirectUri = '';

    /**
     * @Entity(expr="repository.findOneByToken(token)", mapping={"token": "code"})
     */
    public AuthToken $token;

    /**
     * @Entity(options={"id": "client_id"})
     */
    public Client $client;

    public function validate(ContainerInterface $container): bool
    {
        return !($this->token->getRedirectUri() && $this->redirectUri !== $this->token->getRedirectUri());
    }

    public function getErrorMessage(): string
    {
        return "Redirect link isn't matched";
    }
}
