<?php

declare(strict_types=1);

namespace App\Domain\User;

use App\Domain\User\Contract\PasswordUpdaterInterface;
use App\Domain\User\Contract\UserRepositoryInterface;
use App\Domain\User\Entity\User;
use Throwable;

class UserService
{
    private UserRepositoryInterface $userRepository;
    private PasswordUpdaterInterface $passwordUpdater;

    public function __construct(UserRepositoryInterface $userRepository, PasswordUpdaterInterface $passwordUpdater)
    {
        $this->userRepository = $userRepository;
        $this->passwordUpdater = $passwordUpdater;
    }

    public function createUser(RegistrationData $registerUser): ?User
    {
        $user = new User();

        $user
            ->setUsername($registerUser->username ?? '')
            ->setEmail($registerUser->email ?? '')
        ;

        $this->passwordUpdater->hashPassword($user);

        try {
            $this->userRepository->save($user);

            return $user;
        } catch (Throwable $exception) {
            return null;
        }
    }
}
