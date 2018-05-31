<?php
declare(strict_types = 1);

namespace Codehulk\Scribe\Config;

/**
 * A file-based Scribe configuration reader.
 *
 * @package Codehulk\Scribe
 * @public
 */
class File extends Array_ implements ConfigInterface
{
    /**
     * Constructor.
     *
     * @param string $path A path to a configuration file.
     */
    public function __construct(string $path)
    {
        $realpath = realpath($path);
        if (!$realpath) {
            throw new \InvalidArgumentException('Invalid configuration file.');
        }
        $content = require $path;
        if (!is_array($content)) {
            throw new \InvalidArgumentException('Configuration files must be an array.');
        }
        parent::__construct($content);
    }
}
