<?php

/**
 * @param $base
 * @return array|mixed
 * @throws ErrorException
 */
function sites($base)
{
    $filename = "{$base}/docker/sites.json";
    $sites = json_decode(read($filename, '[]'));
    if (!is_array($sites)) {
        $sites = [];
    }
    return $sites;
}

/**
 * @param string $filename
 * @param string $content
 * @return bool|int
 * @throws ErrorException
 */
function write($filename, $content)
{
    if (is_writable(dirname($filename))) {
        if (!is_string($content)) {
            $content = json_encode($content);
        }
        return file_put_contents($filename, $content);
    }
    throw new ErrorException("Can't write {$filename}");
}

/**
 * @param string $filename
 * @param string $default
 * @return bool|string
 * @throws ErrorException
 */
function read($filename, $default = null)
{
    if (file_exists($filename)) {
        return file_get_contents($filename);
    }
    if ($default) {
        return $default;
    }
    throw new ErrorException("Can't write {$filename}");
}

/**
 * @param string $domain
 * @return mixed
 */
function network($domain)
{
    return str_replace('.', '_', $domain);
}

/**
 * @param array $argv
 * @param array $requires
 * @return array
 * @SuppressWarnings("Exit")
 */
function argv($argv, $requires = [])
{
    array_shift($argv);
    $parameters = [];
    foreach ($argv as $arg) {
        $parameter = explode('=', $arg);
        $value = $parameter[0];
        if (count($parameter) === 2) {
            $parameters[$value] = $parameter[1];
            continue;
        }
        $parameters[] = $value;
    }
    if (count($requires)) {
        foreach ($requires as $required) {
            if (!isset($parameters[$required])) {
                echo "The parameter `{$required}` is required", PHP_EOL;
                exit;
            }
        }
    }
    return $parameters;
}
