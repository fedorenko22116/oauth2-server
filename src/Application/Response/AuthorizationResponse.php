<?php declare(strict_types=1);

namespace App\Application\Http\Response;

class AuthorizationResponse
{
    public string $code;
    public string $state;

    public function __construct(string $code, string $state = '')
    {
        $this->code = $code;
        $this->state = $state;
    }
}
