<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:greet',
    description: 'Greets a user by name',
)]
class GreetCommand extends Command
{
    protected function configure(): void
    {
        $this
            ->addArgument('name', InputArgument::REQUIRED, 'The name of the person to greet')
            ->addOption('yell', null, InputOption::VALUE_NONE, 'If set, the greeting will be in uppercase')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $name = $input->getArgument('name');

        $greeting = sprintf('Hello %s!', $name);

        if ($input->getOption('yell')) {
            $greeting = strtoupper($greeting);
        }

        $io->success($greeting);

        return Command::SUCCESS;
    }
}
