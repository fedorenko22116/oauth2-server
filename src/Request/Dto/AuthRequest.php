<?php declare(strict_types=1);

namespace App\Request\Dto;

use App\Entity\Scope;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;

class AuthRequest extends Request
{
    /**
     * @Assert\NotBlank()
     * @Assert\Url()
     */
    public string $redirectUri = '';

    /**
     * @Assert\NotBlank()
     * @Assert\Regex(pattern="/^code$/")
     */
    public string $responseType = '';

    public string $scope = Scope::INFO;
    public string $state = '';
}
