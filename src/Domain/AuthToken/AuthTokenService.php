<?php declare(strict_types=1);

namespace App\Domain\AuthToken;

use App\Domain\Shared\Contract\HashGeneratorInterface;
use App\Domain\AuthToken\Contract\AuthTokenRepositoryInterface;
use App\Domain\AuthToken\Entity\AuthToken;
use App\Domain\Client\Entity\Client;
use Symfony\Component\Security\Core\User\UserInterface;

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

    public function createToken(UserInterface $user, Client $client, string $redirectUri): AuthToken
    {
        $token = new AuthToken($this->hashGenerator->generate(), $client, $user, $redirectUri);

        $this->authTokenRepository->save($token);

        return $token;
    }
}
