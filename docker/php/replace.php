<?php

require_once __DIR__ . '/functions.php';

try {
    $parameters = argv($argv);
    foreach (['b', 'd', 't'] as $item) {
        if (!isset($parameters[$item])) {
            echo "The parameter `-{$item}` is required", PHP_EOL;
            exit;
        }
    }

    $base = $parameters['b'];
    $domain = $parameters['d'];
    $template = $parameters['t'];
    $settings = isset($parameters['s']) ? $parameters['s'] : false;

    $content = generate($base, $domain, $template);
    $name = str_replace(['domain'], [$domain], $template);
    $filename = "{$base}/{$domain}/{$name}";
    if ($settings) {
        $filename = "{$base}/docker/{$name}";
    }
    write($filename, $content);
} catch (ErrorException $e) {
    echo '"', $e->getMessage(), '"', ' on ', $e->getFile(), ' in ', $e->getLine(), PHP_EOL;
}

/**
 * @param $base
 * @param $domain
 * @param $template
 * @return string
 * @throws ErrorException
 */
function generate($base, $domain, $template)
{
    extract(['network' => str_replace('.', '_', $domain)]);
    $filename = "{$base}/docker/template/{$template}";
    if (file_exists($filename)) {
        ob_start();
        /** @noinspection PhpIncludeInspection */
        include $filename;
        $generated = ob_get_contents();
        if ($generated) {
            ob_end_clean();
        }
        return $generated;
    }
    throw new ErrorException("Can't generate {$filename}");
}
