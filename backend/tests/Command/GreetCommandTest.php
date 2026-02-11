<?php

namespace App\Tests\Command;

use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Tester\CommandTester;

class GreetCommandTest extends KernelTestCase
{
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
        $this->assertStringContainsString('Hello Alice!', $output);
    }

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
        $this->assertStringContainsString('HELLO BOB!', $output);
    }
}
