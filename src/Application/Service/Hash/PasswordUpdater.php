<?php

declare(strict_types=1);

namespace App\Application\Service\Hash;

use App\Domain\User\Contract\PasswordUpdaterInterface;
use App\Domain\User\Entity\User;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;
use Symfony\Component\Security\Core\Encoder\NativePasswordEncoder;
use Symfony\Component\Security\Core\Encoder\SelfSaltingEncoderInterface;

class PasswordUpdater implements PasswordUpdaterInterface
{
    private EncoderFactoryInterface $encoderFactory;

    public function __construct(EncoderFactoryInterface $encoderFactory)
    {
        $this->encoderFactory = $encoderFactory;
    }

    public function hashPassword(User $user): void
    {
        $plainPassword = $user->getPlainPassword();

        if (0 === strlen($plainPassword)) {
            return;
        }

        $encoder = $this->encoderFactory->getEncoder($user->getUsername());

        if ($encoder instanceof NativePasswordEncoder || $encoder instanceof SelfSaltingEncoderInterface) {
            $user->setSalt(null);
        } else {
            $salt = rtrim(
                str_replace('+', '.', base64_encode(openssl_random_pseudo_bytes(32) ?: '')),
                '=',
            );
            $user->setSalt($salt);
        }

        $hashedPassword = $encoder->encodePassword($plainPassword, $user->getSalt());

        $user->setPassword($hashedPassword);
        $user->eraseCredentials();
    }
}
