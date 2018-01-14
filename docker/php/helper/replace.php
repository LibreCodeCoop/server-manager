<?php

require_once __DIR__ . '/functions.php';

try {
    $parameters = argv($argv, ['b', 'd', 't']);

    $base = $parameters['b'];
    $domain = $parameters['d'];
    $template = $parameters['t'];
    $settings = isset($parameters['s']) ? $parameters['s'] : false;

    template($base, $domain, $template, $settings);
} catch (ErrorException $e) {
    echo '"', $e->getMessage(), '"', ' on ', $e->getFile(), ' in ', $e->getLine(), PHP_EOL;
}
