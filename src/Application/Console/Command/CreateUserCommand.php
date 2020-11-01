<?php

declare(strict_types=1);

namespace App\Application\Console\Command;

use App\Application\Entity\User;
use App\Domain\User\RegistrationData;
use App\Domain\User\UserService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class CreateUserCommand extends Command
{
    private const ARG_USERNAME = 'username';
    private const ARG_PASSWORD = 'password';
    private const ARG_EMAIL = 'email';
    private const ARG_ROLES = 'roles';

    private SymfonyStyle $io;
    private UserService $userService;
    private ValidatorInterface $validator;

    public function __construct(UserService $userService, ValidatorInterface $validator)
    {
        parent::__construct();

        $this->userService = $userService;
        $this->validator = $validator;
    }

    public function configure(): void
    {
        $this
            ->setName('oauth:user:create')
            ->addArgument(self::ARG_USERNAME, InputArgument::OPTIONAL)
            ->addArgument(self::ARG_PASSWORD, InputArgument::OPTIONAL)
            ->addArgument(self::ARG_EMAIL, InputArgument::OPTIONAL)
            ->addArgument(self::ARG_ROLES, InputArgument::OPTIONAL, 'Roles separated by comma', User::ROLE_USER)
            ->setDescription('Add user')
            ->setHelp('Add user')
        ;
    }

    public function initialize(InputInterface $input, OutputInterface $output): void
    {
        $this->io = new SymfonyStyle($input, $output);
    }

    public function interact(InputInterface $input, OutputInterface $output): void
    {
        if (!$input->getArgument(self::ARG_USERNAME)) {
            $input->setArgument(self::ARG_USERNAME, $this->io->ask('Username'));
        }

        if (!$input->getArgument(self::ARG_PASSWORD)) {
            $input->setArgument(
                self::ARG_PASSWORD,
                $this->io->askQuestion((new Question('Password'))->setHidden(true)),
            );
        }

        if (!$input->getArgument(self::ARG_EMAIL)) {
            $input->setArgument(self::ARG_EMAIL, $this->io->ask('Email'));
        }

        if (!$input->getArgument(self::ARG_ROLES)) {
            $input->setArgument(self::ARG_ROLES, $this->io->ask('Roles', User::ROLE_USER));
        }
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        /** @var string $username */
        $username = $input->getArgument(self::ARG_USERNAME);

        /** @var string $password */
        $password = $input->getArgument(self::ARG_PASSWORD);

        /** @var string $email */
        $email = $input->getArgument(self::ARG_EMAIL);

        /** @var string $rolesString */
        $rolesString = $input->getArgument(self::ARG_EMAIL);

        /** @var string[]|false $roles */
        $roles = explode(',', $rolesString);
        $roles = $roles ?: [];

        $registrationData = new RegistrationData();
        $registrationData->username = $username;
        $registrationData->password = $password;
        $registrationData->email = $email;
        $registrationData->roles = $roles;

        $errors = $this->validator->validate($registrationData);

        if ($errors->count()) {
            /** @var ConstraintViolation $error */
            foreach ($errors as $error) {
                $this->io->error((string) $error->getMessage());
            }

            return 1;
        }

        $this->userService->createUser($registrationData);
        $this->io->success('Creation success.');

        return 0;
    }
}
