<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * Commande de test pour saluer un utilisateur.
 */
#[AsCommand(
    name: 'app:greet',
    description: 'Salue un utilisateur par son nom',
)]
class GreetCommand extends Command
{
    /**
     * Configure les arguments et options de la commande.
     */
    protected function configure(): void
    {
        $this
            ->addArgument('name', InputArgument::REQUIRED, 'Le nom de la personne à saluer')
            ->addOption('yell', null, InputOption::VALUE_NONE, 'Si défini, la salutation sera en majuscules')
        ;
    }

    /**
     * Exécute la commande.
     * 
     * @param InputInterface $input Entrée de la console
     * @param OutputInterface $output Sortie de la console
     * @return int Code de statut de la commande
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $name = $input->getArgument('name');

        $greeting = sprintf('Bonjour %s !', $name);

        if ($input->getOption('yell')) {
            $greeting = strtoupper($greeting);
        }

        $io->success($greeting);

        return Command::SUCCESS;
    }
}
