<?php
declare(strict_types = 1);

namespace Codehulk\PackageDocs;

/**
 * A configuration file.
 *
 * @package Codehulk\PackageDocs
 */
class ConfigFile extends Config
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
        parent::__construct(require $path);
    }
}
