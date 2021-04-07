<?php


namespace Spier\EnvReader;

use RuntimeException;

/**
 * Class EnvReader
 * @package Spier\EnvReader
 */
class EnvReader
{
    /**
     * The directory where the .env file can be located.
     *
     * @var string
     */
    protected string $path;

    /**
     * EnvReader constructor.
     * @param string $path
     */
    public function __construct(string $path)
    {
        if(!file_exists($path)) {
            throw new \InvalidArgumentException(sprintf('%s does not exist', $path));
        }
        $this->path = $path;
    }

    /**
     * Description: loads variables from .env to getenv()
     * Created by rpurant on 07/04/2021 7:08 PM
     */
    public function load() :void
    {
        if (!is_readable($this->path)) {
            throw new RuntimeException(sprintf('%s file is not readable', $this->path));
        }

        $lines = file($this->path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {

            if (strpos(trim($line), '#') === 0) {
                continue;
            }

            [$name, $value] = explode('=', $line, 2);
            $name = trim($name);
            $value = trim($value);

            if (!array_key_exists($name, $_SERVER) && !array_key_exists($name, $_ENV)) {
                putenv(sprintf('%s=%s', $name, $value));
                $_ENV[$name] = $value;
                $_SERVER[$name] = $value;
            }
        }
    }
}