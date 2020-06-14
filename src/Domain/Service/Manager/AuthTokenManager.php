<?php declare(strict_types=1);

namespace App\Domain\Service\Manager;

use App\Domain\Entity\AuthToken;
use App\Domain\Entity\Client;
use App\Infrastructure\Service\Hash\HashGeneratorInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class AuthTokenManager implements AuthTokenManagerInterface
{
    private HashGeneratorInterface $hashGenerator;
    private EntityManagerInterface $entityManager;

    public function __construct(HashGeneratorInterface $hashGenerator, EntityManagerInterface $entityManager)
    {
        $this->hashGenerator = $hashGenerator;
        $this->entityManager = $entityManager;
    }

    public function createToken(UserInterface $user, Client $client, string $redirectUri): AuthToken
    {
        $token = new AuthToken($this->hashGenerator->generate(), $client, $user, $redirectUri);

        $this->entityManager->persist($token);
        $this->entityManager->flush();
    }
}
