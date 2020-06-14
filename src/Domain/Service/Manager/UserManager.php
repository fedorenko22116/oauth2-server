<?php declare(strict_types=1);

namespace App\Service\Manager;

use App\Domain\Entity\User;
use App\Application\Request\Form\Type\Dto\RegisterUser;
use App\Infrastructure\Service\Hash\PasswordUpdaterInterface;
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
        $user = new User();

        $user
            ->setUsername($registerUser->username)
            ->setEmail($registerUser->email)
        ;

        $this->passwordUpdater->hashPassword($user);
        $this->entityManager->persist($user);

        try {
            $this->entityManager->flush();
        } catch (\Throwable $exception) {
            return null;
        }
    }
}
