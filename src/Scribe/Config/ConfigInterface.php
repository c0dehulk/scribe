<?php
declare(strict_types = 1);

namespace Codehulk\Scribe\Config;

/**
 * A configuration interface.
 *
 * @package Codehulk\Scribe
 * @public
 */
interface ConfigInterface
{
    /**
     * Gets the location of the composer.json file.
     *
     * @return string
     */
    public function getComposerPath(): string;

    /**
     * Gets the namespaces to treat as package roots.
     *
     * @return string[]
     */
    public function getPackageRoots(): array;

    /**
     * Gets the absolute path to write the documentation to.
     *
     * @return string
     */
    public function getOutputPath(): string;

    /**
     * Gets the absolute path to load the theme from.
     *
     * @return string
     */
    public function getThemePath(): string;

    /**
     * Gets the title to use for the documentation.
     *
     * @return string
     */
    public function getTitle(): string;
}
