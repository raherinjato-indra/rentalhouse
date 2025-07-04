<?php

namespace App\Command;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class CreateUserCommand extends Command
{
    // Nom officiel de la commande (utile pour certains environnements)
    protected static $defaultName = 'app:create-user';

    public function __construct(
        private EntityManagerInterface $entityManager,
        private UserPasswordHasherInterface $passwordHasher
    ) {
        parent::__construct();

        // 👇 Important pour éviter l’erreur "cannot have an empty name"
        $this->setName(self::$defaultName);
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Créer un utilisateur avec email et mot de passe.')
            ->addArgument('email', InputArgument::REQUIRED, 'Email de l\'utilisateur')
            ->addArgument('password', InputArgument::REQUIRED, 'Mot de passe de l\'utilisateur');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $email = $input->getArgument('email');
        $plainPassword = $input->getArgument('password');

        $user = new User();
        $user->setEmail($email);

        $hashedPassword = $this->passwordHasher->hashPassword($user, $plainPassword);
        $user->setPassword($hashedPassword);

        // Donne un rôle par défaut
        $user->setRoles(['ROLE_USER']);

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        $output->writeln("✅ Utilisateur '$email' créé avec succès !");
        return Command::SUCCESS;
    }
}
