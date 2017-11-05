<?php
declare(strict_types = 1);

namespace Codehulk\PackageDocs;

use Codehulk\Package;

/**
 * A documentation generator.
 *
 * @package Codehulk\PackageDocs
 * @api
 */
class Generator
{
    /**
     * Generates documentation for a set of packages.
     *
     * @param Package\Finder $packages The packages to generate documentation for.
     * @param string         $path     The path to write the documentation to.
     *
     * @return void
     */
    public function createDocs(Package\Finder $packages, string $path)
    {
        $this->createOutputFolder($path);

        $index = new IndexPage();

        /** @var Package\PackageInterface $package */
        foreach ($packages as $package) {
            $page = new PackageIndexPage(
                $this->createSlug($package->getId()),
                $package->getId()
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
