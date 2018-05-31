<?php
declare(strict_types = 1);

namespace Codehulk\Scribe\Page;

use Codehulk\Scribe\Theme\ThemeInterface;

/**
 * An index page.
 *
 * @package Codehulk\Scribe
 * @private
 */
class IndexPage implements PageInterface
{
    /** @var PageInterface[] An array of pages to include in the index. */
    private $pages;

    /** @var ThemeInterface */
    private $theme;

    /**
     * Constructor.
     *
     * @param ThemeInterface $theme
     */
    public function __construct(ThemeInterface $theme)
    {
        $this->theme = $theme;
    }

    /**
     * Adds a package to the index.
     *
     * @param PackageIndexPage $page
     *
     * @return void
     */
    public function addPackage(PackageIndexPage $page)
    {
        $this->pages[] = $page;
    }

    /**
     * @inheritdoc
     */
    public function getName(): string
    {
        return 'Index';
    }

    /**
     * @inheritdoc
     */
    public function getFilename(): string
    {
        return 'index.html';
    }

    /**
     * @inheritdoc
     */
    public function getContent(): string
    {
        return $this->theme->render(
            'index.twig',
            ['packages' => $this->pages]
        );
    }
}
