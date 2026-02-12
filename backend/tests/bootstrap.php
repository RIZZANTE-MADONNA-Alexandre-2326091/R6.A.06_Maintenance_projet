<?php

use Symfony\Component\Dotenv\Dotenv;

require dirname(__DIR__).'/vendor/autoload.php';

if (method_exists(Dotenv::class, 'bootEnv')) {
    $projectDir = dirname(__DIR__);

    $envFiles = [
        $projectDir.'/.env',
        $projectDir.'/.env.test',
        $projectDir.'/.env.example',
    ];

    $envFile = null;
    foreach ($envFiles as $candidate) {
        if (is_file($candidate)) {
            $envFile = $candidate;
            break;
        }
    }

    if (null !== $envFile) {
        (new Dotenv())->bootEnv($envFile);
    }
}

if (!empty($_SERVER['APP_DEBUG'])) {
    umask(0000);
}
