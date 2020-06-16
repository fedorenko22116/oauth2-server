<?php declare(strict_types=1);

namespace App\Application\Response;

class AccessTokenCodeResponse
{
    public string $accessToken;
    public string $tokenType;
    public int $expiresIn;
    public string $refreshToken;

    public function __construct(
        string $accessToken,
        string $tokenType,
        int $expiresIn,
        string $refreshToken
    ) {
        $this->accessToken = $accessToken;
        $this->tokenType = $tokenType;
        $this->expiresIn = $expiresIn;
        $this->refreshToken = $refreshToken;
    }
}
