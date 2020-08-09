<?php

declare(strict_types=1);

namespace App\Application\Console\Command;

use App\Domain\User\Contract\UserRepositoryInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class DeleteUserCommand extends Command
{
    private const ARG_USER = 'user';

    private SymfonyStyle $io;
    private UserRepositoryInterface $userRepository;
    private ValidatorInterface $validator;

    public function __construct(UserRepositoryInterface $userRepository, ValidatorInterface $validator)
    {
        parent::__construct();

        $this->userRepository = $userRepository;
        $this->validator = $validator;
    }

    public function configure(): void
    {
        $this
            ->setName('oauth:user:delete')
            ->addArgument(self::ARG_USER, InputArgument::OPTIONAL, 'Email or username')
            ->setDescription('Delete user')
            ->setHelp('Delete user')
        ;
    }

    public function initialize(InputInterface $input, OutputInterface $output): void
    {
        $this->io = new SymfonyStyle($input, $output);
    }

    public function interact(InputInterface $input, OutputInterface $output): void
    {
        if (!$input->getArgument(self::ARG_USER)) {
            $input->setArgument(self::ARG_USER, $this->io->ask('Username/Email'));
        }
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        /** @var string $username */
        $username = $input->getArgument(self::ARG_USER);
        $user = $this->userRepository->findOneByNameOrEmail($username);

        if (!$user) {
            $this->io->error('User not found.');

            return 1;
        }

        $this->userRepository->remove($user);

        return 0;
    }
}
