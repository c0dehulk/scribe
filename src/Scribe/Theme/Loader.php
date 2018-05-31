<?php
declare(strict_types = 1);

namespace Codehulk\Scribe\Theme;

/**
 * Repository
 */
class Loader
{
    public function loadFromPath(string $path): ThemeInterface
    {
        return new Theme($path);
    }
}
