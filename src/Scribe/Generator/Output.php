<?php
declare(strict_types = 1);

namespace Codehulk\Scribe\Generator;

use Codehulk\Scribe\Page;
use Codehulk\Scribe\Theme;
use Exception;
use Symfony\Component\Filesystem\Filesystem;

/**
 * An output handler.
 *
 * @package Codehulk\Scribe
 * @private
 */
class Output
{
    /** @var Filesystem The filesystem. */
    private $fs;

    /** @var string The path to write output files to. */
    private $path;

    /**
     * Constructor.
     *
     * @param Filesystem $fs A filesystem.
     */
    public function __construct(Filesystem $fs)
    {
        $this->fs = $fs;
    }

    /**
     * Gets the current output path.
     *
     * @return string
     * @throws Exception Thrown if no output path is set.
     */
    public function getPath(): string
    {
        if (!$this->path) {
            throw new \Exception('Output path not set.');
        }
        return $this->path;
    }

    /**
     * Sets the output path, creating the folder if it doesn't exist, and deleting any existing files in that location.
     *
     * @param string $path The path to use as the output path.
     *
     * @return void
     */
    public function setPath(string $path)
    {
        if ($this->fs->exists($path)) {
            $this->fs->remove($path);
        }
        $this->fs->mkdir($path, 02775);

        $this->path = realpath($path);
    }

    /**
     * Adds theme assets to the output files.
     *
     * @param Theme\ThemeInterface $theme A theme.
     *
     * @return void
     */
    public function addThemeAssets(Theme\ThemeInterface $theme)
    {
        $outputAssetsPath = $this->getPath() . '/assets';
        $this->fs->mkdir($outputAssetsPath);
        $this->fs->mirror($theme->getAssetsPath(), $outputAssetsPath);
    }

    /**
     * Adds a page to the output.
     *
     * @param Page\PageInterface $page A page.
     *
     * @return void
     * @throws Exception Thrown if unable to write the page to disk.
     */
    public function addPage(Page\PageInterface $page)
    {
        $filename = $this->getPath() . '/' . $page->getFilename();
        $isSuccess = file_put_contents($filename, $page->getContent());
        if ($isSuccess === false) {
            throw new Exception('Unable to write page.');
        }
    }
}
