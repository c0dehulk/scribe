<?php
declare(strict_types = 1);

namespace Codehulk\Scribe;

use Codehulk\Package;
use Twig_Environment;

/**
 * A documentation generator.
 *
 * @package Codehulk\Scribe
 * @api
 */
class Generator
{
    /** @var Twig_Environment */
    private $twig;

    /**
     * Constructor.
     *
     * @param Twig_Environment $twig
     */
    public function __construct(Twig_Environment $twig)
    {
        $this->twig = $twig;
    }

    /**
     * Generates documentation for a set of packages.
     *
     * @param Package\Finder $packages The packages to generate documentation for.
     * @param Config         $config
     * @param string         $version
     *
     * @return void
     */
    public function createDocs(Package\Finder $packages, Config $config, string $version)
    {
        $path = $config->getOutputPath();
        $this->createOutputFolder($path);


        $theme = $config->getThemePath();
        @mkdir($path . '/assets');
        copy($theme . '/assets/style.css', $path . '/assets/style.css');
        copy($theme . '/assets/markdown.css', $path . '/assets/markdown.css');

        $index = new IndexPage($this->twig);

        $this->twig->addGlobal('application', $config->getTitle());
        $this->twig->addGlobal('version', $version);


        /** @var Package\PackageInterface $package */
        foreach ($packages as $package) {
            $page = new PackageIndexPage(
                $this->createSlug($package->getId()),
                $package->getId(),
                $this->twig
            );
            $page->addReadme(
                new Package\Readme($package)
            );
            $page->write($path);

            $index->addPackage($page);
        }

        $index->write($path);
    }

    /**
     * Creates the output folder for the documentation.
     *
     * @param string $path The path to create.
     *
     * @return void
     * @throws \Exception Thrown if the folder cannot be created or written to.
     */
    private function createOutputFolder(string $path)
    {
        if (is_writable($path)) {
            return;
        }
        if (realpath($path)) {
            throw new \Exception("Unable to write to documentation path: '{$path}'.");
        }
        $isSuccess = mkdir($path, 0775, true) && chmod($path, 02775);
        if (!$isSuccess) {
            throw new \Exception("Unable to create documentation folder: '{$path}'.");
        }
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
