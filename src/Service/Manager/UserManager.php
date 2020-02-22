<?php declare(strict_types=1);

namespace App\Service\Manager;

use App\Entity\User;
use App\Request\Form\Type\Dto\RegisterUser;
use App\Util\Hash\PasswordUpdaterInterface;
use Doctrine\ORM\EntityManagerInterface;

class UserManager implements UserManagerInterface
{
    private EntityManagerInterface $entityManager;
    private PasswordUpdaterInterface $passwordUpdater;

    public function __construct(EntityManagerInterface $entityManager, PasswordUpdaterInterface $passwordUpdater)
    {
        $this->entityManager = $entityManager;
        $this->passwordUpdater = $passwordUpdater;
    }

    public function createUser(RegisterUser $registerUser): ?User
    {
        $user = new User($registerUser->username, $registerUser->email, $registerUser->password);

        $this->passwordUpdater->hashPassword($user);

        $this->entityManager->persist($user);

        try {
            $this->entityManager->flush();
        } catch (\Throwable $exception) {
            return null;
        }
    }
}
