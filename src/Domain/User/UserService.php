<?php

declare(strict_types=1);

namespace App\Domain\User;

use App\Domain\User\Contract\PasswordUpdaterInterface;
use App\Domain\User\Contract\UserRepositoryInterface;
use App\Domain\User\Entity\User;

class UserService
{
    private UserRepositoryInterface $userRepository;
    private PasswordUpdaterInterface $passwordUpdater;

    public function __construct(UserRepositoryInterface $userRepository, PasswordUpdaterInterface $passwordUpdater)
    {
        $this->userRepository = $userRepository;
        $this->passwordUpdater = $passwordUpdater;
    }

    public function createUser(RegistrationData $registerUser): User
    {
        $user = new User();

        $user
            ->setUsername($registerUser->username ?? '')
            ->setEmail($registerUser->email ?? '')
            ->setPlainPassword($registerUser->password ?? '')
            ->setRoles($registerUser->roles ?? [])
        ;

        $this->passwordUpdater->hashPassword($user);
        $this->userRepository->save($user);

        return $user;
    }
}
