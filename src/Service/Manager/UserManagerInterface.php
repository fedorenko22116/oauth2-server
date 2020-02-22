<?php declare(strict_types=1);

namespace App\Service\Manager;

use App\Entity\User;
use App\Request\Form\Type\Dto\RegisterUser;

interface UserManagerInterface
{
    public function createUser(RegisterUser $registerUser): ?User;
}
