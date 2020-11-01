<?php

declare(strict_types=1);

namespace App\Application\Service\Hash;

use App\Application\Entity\User as AppUser;
use App\Domain\User\Contract\PasswordUpdaterInterface;
use App\Domain\User\Entity\User;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;
use Symfony\Component\Security\Core\Encoder\SelfSaltingEncoderInterface;

final class PasswordUpdater implements PasswordUpdaterInterface
{
    private EncoderFactoryInterface $encoderFactory;

    public function __construct(EncoderFactoryInterface $encoderFactory)
    {
        $this->encoderFactory = $encoderFactory;
    }

    public function hashPassword(User $user): void
    {
        $plainPassword = $user->getPlainPassword();

        if ('' === $plainPassword) {
            return;
        }

        $encoder = $this->encoderFactory->getEncoder(AppUser::class);
        $strong = true;
        $hash = openssl_random_pseudo_bytes(32, $strong);

        if ($encoder instanceof SelfSaltingEncoderInterface) {
            $user->setSalt(null);
        } else {
            $salt = rtrim(
                str_replace('+', '.', base64_encode($hash ?: '')),
                '=',
            );
            $user->setSalt($salt);
        }

        $hashedPassword = $encoder->encodePassword($plainPassword, $user->getSalt());

        $user->setPassword($hashedPassword);
        $user->eraseCredentials();
    }
}
