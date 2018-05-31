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
 * @api
 */
class Generator
{
    /** @var Output */
    private $output;

    /** @var Theme\Loader */
    private $themeLoader;

    /**
     * Constructor.
     *
     * @param Theme\Loader $themeLoader
     * @param Output       $output
     */
    public function __construct(Theme\Loader $themeLoader, Output $output)
    {
        $this->output = $output;
        $this->themeLoader = $themeLoader;
    }

    /**
     * Generates documentation for a set of packages.
     *
     * @param Package\Finder         $packages The packages to generate documentation for.
     * @param Config\ConfigInterface $config
     * @param string                 $version
     *
     * @return void
     */
    public function createDocs(Package\Finder $packages, Config\ConfigInterface $config, string $version)
    {
        $this->output->setPath($config->getOutputPath());

        // Load the theme, and apply it to the output.
        $theme = $this->themeLoader->loadFromPath($config->getThemePath());
        $this->output->addThemeAssets($theme);

        $theme->setGlobalValues(
            [
                'application' => $config->getTitle(),
                'version'     => $version,
            ]
        );


        $index = new Page\IndexPage($theme);

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

        $this->output->addPage($index);
    }


    /**
     * Creates a URL-safe identifier for a page.
     *
     * @param string $raw A raw string to create an identifier from.
     *
     * @return string
     */
    private function createSlug(string $raw)
    {
        $slug = preg_replace('/[^a-z0-9]/i', '_', $raw);
        return strtolower(trim($slug, '_'));
    }
}
