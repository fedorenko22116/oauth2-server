<?php declare(strict_types=1);

namespace App\Service\Manager;

use App\Entity\RefreshToken;
use App\Entity\User;
use App\Util\Date\DateTimeInterface;
use App\Util\Hash\HashGeneratorInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class RefreshTokenManager implements RefreshTokenManagerInterface
{
    private EntityManagerInterface $entityManager;
    private HashGeneratorInterface $hashGenerator;
    private DateTimeInterface $dateTime;

    public function __construct(
        EntityManagerInterface $entityManager,
        HashGeneratorInterface $hashGenerator,
        DateTimeInterface $dateTime
    ) {
        $this->entityManager = $entityManager;
        $this->hashGenerator = $hashGenerator;
        $this->dateTime = $dateTime;
    }

    public function createToken(UserInterface $user): RefreshToken
    {
        $token = new RefreshToken($this->hashGenerator->generate(), $this->dateTime->getDate(), $user);

        $this->entityManager->persist($token);
        $this->entityManager->flush();

        return $token;
    }
}
