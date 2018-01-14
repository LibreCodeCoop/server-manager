<?php

require_once __DIR__ . '/functions.php';

try {
    $parameters = argv($argv, ['b', 'd']);

    $base = $parameters['b'];
    $domain = $parameters['d'];

    $sites = array_filter(sites($base), function ($site) use ($domain) {
        return $site->domain !== $domain;
    });
    write($filename, json_encode($sites));
} catch (ErrorException $e) {
    echo '"', $e->getMessage(), '"', ' on ', $e->getFile(), ' in ', $e->getLine(), PHP_EOL;
}
