<?php
declare(strict_types = 1);

namespace Codehulk\Scribe\Generator;

use Codehulk\Scribe\Page;
use Codehulk\Scribe\Theme;
use Exception;
use Symfony\Component\Filesystem\Filesystem;

/**
 * Output
 */
class Output
{
    /** @var Filesystem */
    private $fs;

    /**
     * @param Filesystem $fs
     *
     * @return void
     */
    public function __construct(Filesystem $fs)
    {
        $this->fs = $fs;
        $this->path = __DIR__ . '/../../../build/output';
    }

    public function addThemeAssets(Theme\ThemeInterface $theme)
    {
        $outputAssetsPath = $this->getPath() . '/assets';
        $this->fs->mkdir($outputAssetsPath);
        $this->fs->mirror($theme->getAssetsPath(), $outputAssetsPath);
    }

    public function addPage(Page\PageInterface $page)
    {
        $filename = $this->getPath() . '/' . $page->getFilename();
        $isSuccess = file_put_contents($filename, $page->getContent());
        if ($isSuccess === false) {
            throw new Exception('Unable to write page.');
        }
    }

    public function getPath(): string {
        if (!$this->path) {
            throw new \Exception('Output path not set.');
        }
        return $this->path;
    }

    /**
     * Creates the output folder for the documentation.
     *
     * @param string $path The path to create.
     *
     * @return void
     * @throws \Exception Thrown if the folder cannot be created or written to.
     */
    public function setPath(string $path)
    {
        $existingPath = realpath($path);
        if ($existingPath) {
            $this->fs->remove($existingPath);
        }

        $isSuccess = mkdir($path, 0775, true) && chmod($path, 02775);
        if (!$isSuccess) {
            throw new \Exception("Unable to create documentation folder: '{$path}'.");
        }
    }
}
