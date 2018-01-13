<?php

/**
 * @param $filename
 * @param $content
 * @return bool|int
 * @throws ErrorException
 */
function write($filename, $content)
{
    if (is_writable(dirname($filename))) {
        return file_put_contents($filename, $content);
    }
    throw new ErrorException("Can't write {$filename}");
}

/**
 * @param $filename
 * @return bool|string
 * @throws ErrorException
 */
function read($filename)
{
    if (file_exists($filename)) {
        return file_get_contents($filename);
    }
    throw new ErrorException("Can't write {$filename}");
}

/**
 * @param array $argv
 * @return array
 */
function argv($argv)
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
    return $parameters;
}
