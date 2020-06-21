<?php declare(strict_types=1);

namespace App\Domain\Service\Manager;

use App\Domain\Contract\Repository\UserRepositoryInterface;
use App\Domain\Entity\User;
use App\Domain\Service\Util\PasswordUpdaterInterface;
use Doctrine\ORM\EntityManagerInterface;

class UserManager implements UserManagerInterface
{
    private UserRepositoryInterface $userRepository;
    private PasswordUpdaterInterface $passwordUpdater;

    public function __construct(UserRepositoryInterface $userRepository, PasswordUpdaterInterface $passwordUpdater)
    {
        $this->userRepository = $userRepository;
        $this->passwordUpdater = $passwordUpdater;
    }

    public function createUser(RegisterUserDTO $registerUser): ?User
    {
        $user = new User();

        $user
            ->setUsername($registerUser->username)
            ->setEmail($registerUser->email)
        ;

        $this->passwordUpdater->hashPassword($user);

        try {
            $this->userRepository->save($user);

            return $user;
        } catch (\Throwable $exception) {
            return null;
        }

    }
}
