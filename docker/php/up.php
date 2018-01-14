<?php

require_once __DIR__ . '/helper/functions.php';

try {
    $parameters = argv($argv, ['b']);

    $base = $parameters['b'];

    $sites = sites($base);
    foreach ($sites as $site) {
        if (!$site->active) {
            continue;
        }
        up($base, $site->domain);
    }
    up($base);
} catch (ErrorException $e) {
    echo '"', $e->getMessage(), '"', ' on ', $e->getFile(), ' in ', $e->getLine(), PHP_EOL;
}
