<?php
declare(strict_types = 1);

namespace Codehulk\Scribe\Generator;

use Codehulk\Package;
use Codehulk\Scribe\Config;
use Codehulk\Scribe\Page;
use Codehulk\Scribe\Theme;

/**
 * A documentation generator.
 *
 * @package Codehulk\Scribe
 * @public
 */
class Generator
{
    /** @var Theme\Loader The loader to retrieve themes with. */
    private $themeLoader;

    /** @var Output The output handler. */
    private $output;

    /**
     * Constructor.
     *
     * @param Theme\Loader $themeLoader A loader to retrieve themes with.
     * @param Output       $output      An output handler.
     */
    public function __construct(Theme\Loader $themeLoader, Output $output)
    {
        $this->themeLoader = $themeLoader;
        $this->output = $output;
    }

    /**
     * Generates documentation for a set of packages.
     *
     * @param Package\Finder         $packages A set of packages to generate documentation for.
     * @param Config\ConfigInterface $config   A configuration set.
     * @param string                 $version  A version to annotate the generated documentation with.
     *
     * @return void
     */
    public function createDocs(Package\Finder $packages, Config\ConfigInterface $config, string $version)
    {
        $this->output->setPath($config->getOutputPath());

        // Load the theme, and apply it to the output.
        $theme = $this->themeLoader->loadFromPath($config->getThemePath());
        $theme->setDefaultParameters(
            [
                'application' => $config->getTitle(),
                'version'     => $version,
            ]
        );
        $this->output->addThemeAssets($theme);

        // Generate the index page.
        $index = new Page\IndexPage($theme);

        // Generate pages for each package.
        /** @var Package\PackageInterface $package */
        foreach ($packages as $package) {
            $page = new Page\PackageIndexPage(
                $this->createSlug($package->getId()),
                $package->getId(),
                $theme
            );
            $page->addReadme(
                new Package\Readme($package)
            );
            $this->output->addPage($page);

            $index->addPackage($page);
        }

        // Finalise the index page.
        $this->output->addPage($index);
    }

    /**
     * Creates a URL-safe identifier for a page.
     *
     * @param string $raw A raw string to create an identifier from.
     *
     * @return string
     */
    private function createSlug(string $raw): string
    {
        $slug = preg_replace('/[^a-z0-9]/i', '_', $raw);
        return strtolower(trim($slug, '_'));
    }
}
