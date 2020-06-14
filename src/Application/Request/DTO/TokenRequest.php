<?php declare(strict_types=1);

namespace App\Application\Request\DTO;

use App\Domain\Entity\AuthToken;
use LSBProject\RequestBundle\Configuration\Entity;
use LSBProject\RequestBundle\Configuration\RequestStorage;
use LSBProject\RequestBundle\Request\AbstractRequest;
use Psr\Container\ContainerInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @RequestStorage({"body"})
 */
class TokenRequest extends AbstractRequest
{
    /**
     * @Assert\NotBlank()
     * @Assert\Regex(pattern="/^authorization_code$/")
     */
    public string $grantType = '';

    /**
     * @Assert\Url()
     */
    public string $redirectUri = '';

    /**
     * @Entity(expr="repository.findOneByToken(token)", mapping={"token": "token"})
     */
    public AuthToken $token;

    public function validate(ContainerInterface $container): bool
    {
        return !($this->token->getRedirectUri() && $this->redirectUri !== $this->token->getRedirectUri());
    }

    public function getErrorMessage(): string
    {
        return "Redirect link isn't matched";
    }
}
