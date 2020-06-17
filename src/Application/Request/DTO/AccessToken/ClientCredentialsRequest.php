<?php declare(strict_types=1);

namespace App\Application\Request\DTO\AccessToken;

use App\Domain\Entity\Scope;
use LSBProject\RequestBundle\Configuration\RequestStorage;
use LSBProject\RequestBundle\Request\AbstractRequest;

/**
 * @RequestStorage({"body"})
 */
class ClientCredentialsRequest extends AbstractRequest
{
    /**
     * @Assert\NotBlank()
     * @Assert\Regex(pattern="/^(client_credentials)$/")
     */
    public string $grantType;
    public string $scope = Scope::INFO;
}
