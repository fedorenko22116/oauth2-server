<?php

declare(strict_types=1);

namespace App\Application\Service\ViewModel\Token\View;

use App\Application\Constants;
use App\Application\Service\ViewModel\ViewInterface;

final class TokenModel implements ViewInterface
{
    private string $accessToken;
    private int $expires;
    private string $refreshToken;

    public function __construct(string $accessToken, int $expires, string $refreshToken)
    {
        $this->accessToken = $accessToken;
        $this->expires = $expires;
        $this->refreshToken = $refreshToken;
    }

    /**
     * @return array<string, string|int>
     */
    public function toArray(): array
    {
        return [
            "access_token" => $this->accessToken,
            "token_type" => Constants::TOKEN_TYPE,
            "expires_in" => $this->expires,
            "refresh_token" => $this->refreshToken,
        ];
    }
}
