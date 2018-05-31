<?php
declare(strict_types = 1);

namespace Codehulk\Scribe\Page;

use Codehulk\Package\Readme;
use Codehulk\Scribe\Theme\ThemeInterface;

/**
 * A package index page.
 *
 * @package Codehulk\Scribe
 * @private
 */
class PackageIndexPage implements PageInterface
{
    /** @var string The identifier for the page. */
    private $id;

    /** @var string The name of the page. */
    private $name;

    /** @var Readme The readme file. */
    private $readme;

    /** @var ThemeInterface The theme to create the page with. */
    private $theme;

    /**
     * Constructor.
     *
     * @param string         $id    An identifier for the page.
     * @param string         $name  A name of the page.
     * @param ThemeInterface $theme The theme to create the page with.
     */
    public function __construct(string $id, string $name, ThemeInterface $theme)
    {
        $this->id = $id;
        $this->name = $name;
        $this->theme = $theme;
    }

    /**
     * @inheritdoc
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @inheritdoc
     */
    public function getFilename(): string
    {
        return $this->id . '.html';
    }

    /**
     * @inheritdoc
     */
    public function getContent(): string
    {
        return $this->theme->render(
            'package.twig',
            [
                'title'  => $this->name,
                'readme' => $this->readme->getContentAsHtml(),
            ]
        );
    }

    /**
     * Adds a readme file to the page.
     *
     * @param Readme $readme A readme file.
     *
     * @return void
     */
    public function addReadme(Readme $readme)
    {
        $this->readme = $readme;
    }
}
