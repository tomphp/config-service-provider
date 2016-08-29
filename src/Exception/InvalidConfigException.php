<?php

namespace TomPHP\ConfigServiceProvider\Exception;

use LogicException;

final class InvalidConfigException extends LogicException implements Exception
{
    use ExceptionFactory;

    /**
     * @param string $filename
     *
     * @return self
     */
    public static function fromPHPFileError($filename)
    {
        return self::create('"%s" does not return a PHP array.', $filename);
    }

    /**
     * @param string $filename
     * @param string $message
     *
     * @return self
     */
    public static function fromJSONFileError($filename, $message)
    {
        return self::create('Invalid JSON in "%s": %s', $filename, $message);
    }
}
