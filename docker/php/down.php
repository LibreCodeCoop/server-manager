<?php

require_once __DIR__ . '/functions.php';

try {
    $parameters = argv($argv, ['b']);

    $base = $parameters['b'];
    $domain = isset($parameters['d']) ? $parameters['d'] : '';

    shell_exec("docker-compose -f {$base}/docker/docker-compose.yml down");

    $sites = sites($base);
    foreach ($sites as $site) {
        if (!$site->active) {
            continue;
        }
        shell_exec("docker-compose -f {$base}/{$site->domain}/app/docker-compose.yml down");
    }
} catch (ErrorException $e) {
    echo '"', $e->getMessage(), '"', ' on ', $e->getFile(), ' in ', $e->getLine(), PHP_EOL;
}
