<?php

require_once __DIR__ . '/helper/functions.php';

try {
    $parameters = argv($argv, ['b', 'd']);

    $base = $parameters['b'];
    $domain = $parameters['d'];

    down($base);
    down($base, $domain);

    status($base, $domain, false);

    up($base);

} catch (ErrorException $e) {
    echo '"', $e->getMessage(), '"', ' on ', $e->getFile(), ' in ', $e->getLine(), PHP_EOL;
}
