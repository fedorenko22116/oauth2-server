<?php declare(strict_types=1);

namespace App\Application\Response;

class AccessTokenTokenResponse
{
    public string $accessToken;
    public string $tokenType;
    public int $expiresIn;
    public array $scope;
    public string $state;

    public function __construct(
        string $accessToken,
        string $tokenType,
        int $expiresIn,
        array $scope,
        string $state
    ) {
        $this->accessToken = $accessToken;
        $this->tokenType = $tokenType;
        $this->expiresIn = $expiresIn;
        $this->scope = $scope;
        $this->state = $state;
    }
}
