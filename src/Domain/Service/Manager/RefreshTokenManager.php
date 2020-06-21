<?php declare(strict_types=1);

namespace App\Domain\Service\Manager;

use App\Domain\Contract\DateTimeInterface;
use App\Domain\Contract\HashGeneratorInterface;
use App\Domain\Contract\Repository\RefreshTokenRepositoryInterface;
use App\Domain\Contract\Repository\ScopeRepositoryInterface;
use App\Domain\Entity\RefreshToken;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Security\Core\User\UserInterface;

class RefreshTokenManager implements RefreshTokenManagerInterface
{
    private HashGeneratorInterface $hashGenerator;
    private DateTimeInterface $dateTime;
    private ScopeRepositoryInterface $scopeRepository;
    private RefreshTokenRepositoryInterface $refreshTokenRepository;

    public function __construct(
        HashGeneratorInterface $hashGenerator,
        DateTimeInterface $dateTime,
        ScopeRepositoryInterface $scopeRepository,
        RefreshTokenRepositoryInterface $refreshTokenRepository
    ) {
        $this->hashGenerator = $hashGenerator;
        $this->dateTime = $dateTime;
        $this->scopeRepository = $scopeRepository;
        $this->refreshTokenRepository = $refreshTokenRepository;
    }

    public function createToken(UserInterface $user, ?ArrayCollection $scopes = null): RefreshToken
    {
        $token = new RefreshToken(
            $this->hashGenerator->generate(),
            $this->dateTime->getDate(),
            $user,
            $scopes ?? $this->scopeRepository->findDefaults()
        );

        $this->refreshTokenRepository->save($token);

        return $token;
    }
}
