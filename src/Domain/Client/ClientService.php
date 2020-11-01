<?php

declare(strict_types=1);

namespace App\Domain\Client;

use App\Domain\Client\Entity\Client;
use App\Domain\Shared\Contract\HashGeneratorInterface;
use App\Domain\User\Entity\User;

class ClientService
{
    private HashGeneratorInterface $hashGenerator;

    public function __construct(HashGeneratorInterface $hashGenerator)
    {
        $this->hashGenerator = $hashGenerator;
    }

    public function createClient(string $host, User $user): Client
    {
        return (new Client())
            ->setHost($host)
            ->setUser($user)
            ->setSecret($this->hashGenerator->generate(32))
        ;
    }
}
