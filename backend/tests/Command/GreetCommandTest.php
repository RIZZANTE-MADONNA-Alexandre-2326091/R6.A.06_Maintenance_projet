<?php

namespace App\Tests\Command;

use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Tester\CommandTester;

/**
 * Tests de la commande app:greet.
 */
class GreetCommandTest extends KernelTestCase
{
    /**
     * Teste l'exécution avec un nom.
     */
    public function testExecuteWithName(): void
    {
        $kernel = self::bootKernel();
        $application = new Application($kernel);

        $command = $application->find('app:greet');
        $commandTester = new CommandTester($command);
        $commandTester->execute([
            'name' => 'Alice',
        ]);

        $commandTester->assertCommandIsSuccessful();

        $output = $commandTester->getDisplay();
        $this->assertStringContainsString('Bonjour Alice !', $output);
    }

    /**
     * Teste l'exécution avec l'option --yell (majuscules).
     */
    public function testExecuteWithYellOption(): void
    {
        $kernel = self::bootKernel();
        $application = new Application($kernel);

        $command = $application->find('app:greet');
        $commandTester = new CommandTester($command);
        $commandTester->execute([
            'name' => 'Bob',
            '--yell' => true,
        ]);

        $commandTester->assertCommandIsSuccessful();

        $output = $commandTester->getDisplay();
        $this->assertStringContainsString('BONJOUR BOB !', $output);
    }
}
