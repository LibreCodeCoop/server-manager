<?php

require_once __DIR__ . '/functions.php';

try {
    $parameters = argv($argv, ['b']);

    $base = $parameters['b'];
    $domain = isset($parameters['d']) ? $parameters['d'] : '';

    $sites = sites($base);
    foreach ($sites as $site) {
        if (!$site->active) {
            continue;
        }
        // shell_exec("cd {$base}/{$site->domain}/app && docker-compose --verbose up -d");
        shell_exec("cd {$base}/{$site->domain}/app && docker-compose -p p{$site->id}_ up -d");
    }

    // shell_exec("cd {$base}/docker/ && docker-compose --verbose up -d");
    shell_exec("cd {$base}/docker/ && docker-compose up -d");
} catch (ErrorException $e) {
    echo '"', $e->getMessage(), '"', ' on ', $e->getFile(), ' in ', $e->getLine(), PHP_EOL;
}
