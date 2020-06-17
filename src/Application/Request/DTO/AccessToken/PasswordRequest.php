<?php declare(strict_types=1);

namespace App\Application\Request\DTO\AccessToken;

use App\Domain\Entity\Scope;
use LSBProject\RequestBundle\Configuration\RequestStorage;
use LSBProject\RequestBundle\Request\AbstractRequest;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @RequestStorage({"body"})
 */
class PasswordRequest extends AbstractRequest
{
    /**
     * @Assert\NotBlank()
     * @Assert\Regex(pattern="/^(password)$/")
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
}
