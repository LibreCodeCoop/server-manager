<?php

define('COMPOSER_FILE', 'docker-compose.yml');

/**
 * @param string $base
 * @param array $sites
 * @return array|mixed
 * @throws ErrorException
 */
function sites($base, $sites = null)
{
    $filename = "{$base}/sm/docker/sites.json";
    if (!is_null($sites)) {
        return write($filename, $sites);
    }
    $sites = json_decode(read($filename, '[]'));
    if (!is_array($sites)) {
        $sites = [];
    }
    return $sites;
}

/**
 * @param string $filename
 * @param mixed $content
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

/**
 * @param string $base
 * @param string $domain
 * @return string
 * @SuppressWarnings("ShortMethodName")
 */
function up($base, $domain = '')
{
    $file = COMPOSER_FILE;
    if ($domain) {
        $container = "{$base}/app/{$domain}/{$file}";
        if (file_exists($container)) {
            return shell_exec("docker-compose -f {$container} up -d");
        }
        return '';
    }
    return shell_exec("docker-compose -f {$base}/sm/docker/{$file} up -d");
}

/**
 * @param string $base
 * @param string $domain
 * @return string
 */
function down($base, $domain = '')
{
    $file = COMPOSER_FILE;
    //  --remove-orphan
    if ($domain) {
        $container = "{$base}/app/{$domain}/{$file}";
        if (file_exists($container)) {
            return shell_exec("docker-compose -f {$container} down");
        }
        return '';
    }
    return shell_exec("docker-compose -f {$base}/sm/docker/{$file} down");
}

/**
 * @param $base
 * @param $domain
 * @param $template
 * @return string
 * @throws ErrorException
 */
function compile($base, $domain, $template)
{
    $sites = sites($base);

    $actives = array_filter($sites, function ($site) {
        return $site->active;
    });
    $current = array_reduce($sites, function ($accumulate, $item) use ($domain) {
        if ($item->domain === $domain) {
            return (array)$item;
        }
        return $accumulate;
    }, []);
    $variables = array_merge($current, [
        'network' => network($domain),
        'sites' => $actives,
    ]);
    extract($variables);

    $filename = "{$base}/sm/docker/template/{$template}";
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

/**
 * @param string $base
 * @param string $domain
 * @param string $template
 * @param string $settings
 * @throws ErrorException
 */
function template($base, $domain, $template, $settings)
{
    $content = compile($base, $domain, $template);
    $name = str_replace(['domain'], [$domain], $template);
    $filename = "{$base}/{$name}";
    if ($settings) {
        $filename = "{$base}/sm/docker/{$name}";
    }
    write($filename, $content);
}

/**
 * @param string $base
 * @param string $domain
 * @param boolean $status
 * @throws ErrorException
 */
function status($base, $domain, $status)
{
    $sites = array_map(function ($site) use ($domain, $status) {
        if ($site->domain === $domain) {
            $site->active = $status;
        }
        return $site;
    }, sites($base));
    sites($base, $sites);

    template($base, $domain, 'docker-compose.yml', true);
}
