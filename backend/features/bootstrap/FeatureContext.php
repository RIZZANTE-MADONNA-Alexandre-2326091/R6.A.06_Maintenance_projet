<?php

use Behat\Behat\Context\Context;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;
use Symfony\Component\HttpKernel\KernelInterface;

/**
 * Defines application features from the specific context.
 */
class FeatureContext implements Context
{
    private ?CommandTester $commandTester = null;
    private ?int $exitCode = null;

    public function __construct(private KernelInterface $kernel)
    {
    }

    /**
     * @When I run the command :commandLine
     */
    public function iRunTheCommand(string $commandLine): void
    {
        $application = new Application($this->kernel);
        $application->setAutoExit(false);

        // Parse la ligne de commande
        $parts = explode(' ', $commandLine);
        $commandName = array_shift($parts);

        $command = $application->find($commandName);
        $this->commandTester = new CommandTester($command);

        // Convertir les arguments/options
        $input = ['command' => $commandName];
        foreach ($parts as $part) {
            if (str_starts_with($part, '--')) {
                $input[$part] = true;
            } else {
                // Premier argument positionnel
                if (!isset($input['name'])) {
                    $input['name'] = $part;
                }
            }
        }

        $this->exitCode = $this->commandTester->execute($input);
    }

    /**
     * @Then the command should succeed
     */
    public function theCommandShouldSucceed(): void
    {
        if (0 !== $this->exitCode) {
            throw new RuntimeException(sprintf('Command failed with exit code %d. Output: %s', $this->exitCode, $this->commandTester->getDisplay()));
        }
    }

    /**
     * @Then the output should contain :text
     */
    public function theOutputShouldContain(string $text): void
    {
        $output = $this->commandTester->getDisplay();
        if (!str_contains($output, $text)) {
            throw new RuntimeException(sprintf('Output does not contain "%s". Actual output: %s', $text, $output));
        }
    }
}
