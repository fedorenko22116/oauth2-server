<?php declare(strict_types=1);

namespace App\Request\Dto;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;

class TokenRequest extends Request
{
    /**
     * @Assert\NotBlank()
     * @Assert\Regex(pattern="/^authorization_code$/")
     */
    public string $grantType = '';

    /**
     * @Assert\NotBlank()
     * @Assert\Url()
     */
    public string $redirectUri = '';
}
