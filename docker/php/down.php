<?php

require_once __DIR__ . '/functions.php';

try {
    $parameters = argv($argv, ['b']);

    $base = $parameters['b'];
    $domain = isset($parameters['d']) ? $parameters['d'] : '';

    // shell_exec("cd {$base}/docker && docker-compose --verbose down");
    shell_exec("cd {$base}/docker && docker-compose down");

    $sites = sites($base);
    foreach ($sites as $site) {
        if (!$site->active) {
            continue;
        }
        // shell_exec("cd {$base}/{$site->domain}/app && docker-compose --verbose down --remove-orphan");
        shell_exec("cd {$base}/{$site->domain}/app && docker-compose down");
    }
} catch (ErrorException $e) {
    echo '"', $e->getMessage(), '"', ' on ', $e->getFile(), ' in ', $e->getLine(), PHP_EOL;
}
