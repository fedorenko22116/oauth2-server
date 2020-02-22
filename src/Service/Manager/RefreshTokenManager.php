<?php declare(strict_types=1);

namespace App\Service\Manager;

use App\Entity\RefreshToken;
use App\Entity\Scope;
use App\Repository\ScopeRepository;
use App\Util\Date\DateTimeInterface;
use App\Util\Hash\HashGeneratorInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class RefreshTokenManager implements RefreshTokenManagerInterface
{
    private EntityManagerInterface $entityManager;
    private HashGeneratorInterface $hashGenerator;
    private DateTimeInterface $dateTime;
    private ScopeRepository $scopeRepository;

    public function __construct(
        EntityManagerInterface $entityManager,
        HashGeneratorInterface $hashGenerator,
        DateTimeInterface $dateTime,
        ScopeRepository $scopeRepository
    ) {
        $this->entityManager = $entityManager;
        $this->hashGenerator = $hashGenerator;
        $this->dateTime = $dateTime;
        $this->scopeRepository = $scopeRepository;
    }

    public function createToken(UserInterface $user, ?ArrayCollection $scopes = null): RefreshToken
    {
        $token = new RefreshToken(
            $this->hashGenerator->generate(),
            $this->dateTime->getDate(),
            $user,
            $scopes ?? $this->scopeRepository->findDefaults()
        );

        $this->entityManager->persist($token);
        $this->entityManager->flush();

        return $token;
    }
}
