<?php

require_once __DIR__ . '/functions.php';

try {
    $parameters = argv($argv, ['b', 'd']);

    $base = $parameters['b'];
    $domain = $parameters['d'];

    $sites = sites($base);
    $sites[] = [
        'id' => uniqid(),
        'domain' => $domain,
        'network' => network($domain),
        'active' => true,
    ];
    sites($base, $sites);
} catch (ErrorException $e) {
    echo '"', $e->getMessage(), '"', ' on ', $e->getFile(), ' in ', $e->getLine(), PHP_EOL;
}
