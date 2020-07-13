<?php


namespace App\Application\Service\ViewModel\Authorization\View;


use App\Application\Constants;
use App\Application\Service\ViewModel\ViewInterface;

final class TokenView implements ViewInterface
{
    private string $token;
    private string $state;
    private int $expires;

    public function __construct(string $accessToken, string $state, int $expires)
    {
        $this->token = $accessToken;
        $this->state = $state;
        $this->expires = $expires;
    }

    public function toArray(): array
    {
        return [
            'access_token'  => $this->token,
            'state'         => $this->state,
            'token_type'    => Constants::TOKEN_TYPE,
            'expires'       => $this->expires,
        ];
    }
}