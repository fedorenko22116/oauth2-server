<?php declare(strict_types=1);

namespace App\Domain\Service\Manager;

use App\Domain\Entity\User;
use App\Application\Request\Form\Type\Dto\RegisterUser;

interface UserManagerInterface
{
    public function createUser(RegisterUser $registerUser): ?User;
}
