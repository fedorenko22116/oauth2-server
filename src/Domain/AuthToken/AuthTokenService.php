<?php

declare(strict_types=1);

namespace App\Domain\AuthToken;

use App\Domain\AuthToken\Contract\AuthTokenRepositoryInterface;
use App\Domain\AuthToken\Entity\AuthToken;
use App\Domain\Client\Entity\Client;
use App\Domain\Shared\Contract\HashGeneratorInterface;
use App\Domain\User\Entity\User;

class AuthTokenService
{
    private HashGeneratorInterface $hashGenerator;
    private AuthTokenRepositoryInterface $authTokenRepository;

    public function __construct(
        HashGeneratorInterface $hashGenerator,
        AuthTokenRepositoryInterface $authTokenRepository
    ) {
        $this->hashGenerator = $hashGenerator;
        $this->authTokenRepository = $authTokenRepository;
    }

    public function createToken(User $user, Client $client, string $redirectUri): AuthToken
    {
        $token = new AuthToken($this->hashGenerator->generate(), $client, $user, $redirectUri);

        $this->authTokenRepository->save($token);

        return $token;
    }
}
