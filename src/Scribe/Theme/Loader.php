<?php
declare(strict_types = 1);

namespace Codehulk\Scribe\Theme;

/**
 * A loader for themes.
 *
 * @package Codehulk\Scribe
 * @private
 */
class Loader
{
    /**
     * Loads a theme from a path.
     *
     * @param string $path A path.
     *
     * @return ThemeInterface
     */
    public function loadFromPath(string $path): ThemeInterface
    {
        return new Theme($path);
    }
}
