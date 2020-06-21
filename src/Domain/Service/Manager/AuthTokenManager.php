<?php declare(strict_types=1);

namespace App\Domain\Service\Manager;

use App\Domain\Contract\HashGeneratorInterface;
use App\Domain\Contract\Repository\AuthTokenRepositoryInterface;
use App\Domain\Entity\AuthToken;
use App\Domain\Entity\Client;
use Symfony\Component\Security\Core\User\UserInterface;

class AuthTokenManager implements AuthTokenManagerInterface
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
