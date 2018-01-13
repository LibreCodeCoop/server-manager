<?php

require_once __DIR__ . '/functions.php';

try {
    $parameters = argv($argv);
    foreach (['b', 'd', 'o'] as $item) {
        if (!isset($parameters[$item])) {
            echo "The parameter `-{$item}` is required", PHP_EOL;
            exit;
        }
    }

    $base = $parameters['b'];
    $domain = $parameters['d'];
    $operation = $parameters['o'];

    $filename = "{$base}/docker/enabled.json";
    $enabled = json_decode(read($filename));
    if (!is_array($enabled)) {
        $enabled = [];
    }
    if ($operation === 'add') {
        $enabled[] = $domain;
    } elseif ($operation === 'add') {
        $enabled = array_filter($enabled, function ($installed) use ($domain) {
            return $installed !== $domain;
        });
    }
    write($filename, json_encode($enabled));
} catch (ErrorException $e) {
    echo '"', $e->getMessage(), '"', ' on ', $e->getFile(), ' in ', $e->getLine(), PHP_EOL;
}
