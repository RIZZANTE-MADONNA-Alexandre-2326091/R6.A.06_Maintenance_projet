<?php

namespace App\Tests\Behat;

use Behat\Behat\Context\Context;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\KernelInterface;

/**
 * Context pour les tests API Behat.
 */
class ApiContext implements Context
{
    private KernelInterface $kernel;
    private ?Response $response = null;
    private array $storedValues = [];

    public function __construct(KernelInterface $kernel)
    {
        $this->kernel = $kernel;
    }

    /**
     * @When I send a GET request to :url
     */
    public function iSendAGetRequestTo(string $url): void
    {
        $url = $this->replaceStoredValues($url);
        $this->response = $this->kernel->handle(Request::create($url, 'GET'));
    }

    /**
     * @When I send a POST request to :url with body:
     */
    public function iSendAPostRequestToWithBody(string $url, string $body): void
    {
        $url = $this->replaceStoredValues($url);
        $body = $this->replaceStoredValues($body);
        
        $this->response = $this->kernel->handle(
            Request::create(
                $url,
                'POST',
                [],
                [],
                [],
                ['CONTENT_TYPE' => 'application/json'],
                $body
            )
        );
    }

    /**
     * @When I send a PUT request to :url with body:
     */
    public function iSendAPutRequestToWithBody(string $url, string $body): void
    {
        $url = $this->replaceStoredValues($url);
        $body = $this->replaceStoredValues($body);
        
        $this->response = $this->kernel->handle(
            Request::create(
                $url,
                'PUT',
                [],
                [],
                [],
                ['CONTENT_TYPE' => 'application/json'],
                $body
            )
        );
    }

    /**
     * @When I send a PATCH request to :url with body:
     */
    public function iSendAPatchRequestToWithBody(string $url, string $body): void
    {
        $url = $this->replaceStoredValues($url);
        $body = $this->replaceStoredValues($body);
        
        $this->response = $this->kernel->handle(
            Request::create(
                $url,
                'PATCH',
                [],
                [],
                [],
                ['CONTENT_TYPE' => 'application/merge-patch+json'],
                $body
            )
        );
    }

    /**
     * @When I send a DELETE request to :url
     */
    public function iSendADeleteRequestTo(string $url): void
    {
        $url = $this->replaceStoredValues($url);
        $this->response = $this->kernel->handle(Request::create($url, 'DELETE'));
    }

    /**
     * @Then the response status code should be :statusCode
     */
    public function theResponseStatusCodeShouldBe(int $statusCode): void
    {
        if ($this->response === null) {
            throw new \RuntimeException('No response available');
        }

        if ($this->response->getStatusCode() !== $statusCode) {
            throw new \RuntimeException(
                sprintf(
                    'Expected status code %d, got %d. Response: %s',
                    $statusCode,
                    $this->response->getStatusCode(),
                    $this->response->getContent()
                )
            );
        }
    }

    /**
     * @Then the response should be in JSON
     */
    public function theResponseShouldBeInJson(): void
    {
        if ($this->response === null) {
            throw new \RuntimeException('No response available');
        }

        $contentType = $this->response->headers->get('Content-Type');
        if ($contentType === null || !str_contains($contentType, 'application/json')) {
            throw new \RuntimeException(
                sprintf('Response is not JSON. Content-Type: %s', $contentType ?? 'null')
            );
        }

        json_decode($this->response->getContent(), true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \RuntimeException(
                sprintf('Response is not valid JSON: %s', json_last_error_msg())
            );
        }
    }

    /**
     * @Then the JSON node :node should be equal to :value
     */
    public function theJsonNodeShouldBeEqualTo(string $node, string $value): void
    {
        if ($this->response === null) {
            throw new \RuntimeException('No response available');
        }

        $data = json_decode($this->response->getContent(), true);
        if (!isset($data[$node])) {
            throw new \RuntimeException(
                sprintf('JSON node "%s" not found in response: %s', $node, $this->response->getContent())
            );
        }

        if ($data[$node] !== $value) {
            throw new \RuntimeException(
                sprintf('Expected "%s" to be "%s", got "%s"', $node, $value, $data[$node])
            );
        }
    }

    /**
     * @Given I store the JSON node :node as :variableName
     */
    public function iStoreTheJsonNodeAs(string $node, string $variableName): void
    {
        if ($this->response === null) {
            throw new \RuntimeException('No response available');
        }

        $data = json_decode($this->response->getContent(), true);
        if (!isset($data[$node])) {
            throw new \RuntimeException(
                sprintf('JSON node "%s" not found in response: %s', $node, $this->response->getContent())
            );
        }

        $this->storedValues[$variableName] = $data[$node];
    }

    /**
     * Replace stored values in URL or body.
     */
    private function replaceStoredValues(string $text): string
    {
        foreach ($this->storedValues as $key => $value) {
            $text = str_replace('{' . $key . '}', (string) $value, $text);
        }
        
        return $text;
    }
}
