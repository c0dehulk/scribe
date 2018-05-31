<?php
declare(strict_types = 1);

namespace Codehulk\Scribe\Theme;

/**
 * Describes a theme.
 */
interface ThemeInterface
{
    /**
     * Gets the path to the theme's assets folder.
     *
     * @return string
     */
    public function getAssetsPath(): string;

    public function setGlobalValues(array $globals);

    public function render(string $template, array $parameters): string;
}
