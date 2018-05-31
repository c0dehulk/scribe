<?php
declare(strict_types = 1);

namespace Codehulk\Scribe\Theme;

/**
 * Describes a theme.
 *
 * @package Codehulk\Scribe
 * @public
 */
interface ThemeInterface
{
    /**
     * Gets the path to the theme's assets folder.
     *
     * @return string
     */
    public function getAssetsPath(): string;

    /**
     * Sets the default parameters for themes.
     *
     * @return void
     */
    public function setDefaultParameters(array $parameters);

    /**
     * Renders a template.
     *
     * @return void
     */
    public function render(string $template, array $parameters): string;
}
