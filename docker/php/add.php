<?php

require_once __DIR__ . '/helper/functions.php';

try {
    $parameters = argv($argv, ['b', 'd']);

    $base = $parameters['b'];
    $domain = $parameters['d'];

    $sites = sites($base);
    $sites[] = [
        'id' => uniqid(),
        'domain' => $domain,
        'network' => network($domain),
        'active' => false,
    ];
    sites($base, $sites);

} catch (ErrorException $e) {
    echo '"', $e->getMessage(), '"', ' on ', $e->getFile(), ' in ', $e->getLine(), PHP_EOL;
}
