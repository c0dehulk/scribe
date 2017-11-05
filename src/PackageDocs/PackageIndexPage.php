<?php
declare(strict_types = 1);

namespace Codehulk\PackageDocs;

use Codehulk\Package\Readme;
use Exception;

/**
 * A renderer for a package index page.
 *
 * @package Codehulk\PackageDocs
 */
class PackageIndexPage
{
    /** @var string The identifier for the page. */
    private $id;

    /** @var string the name of the page. */
    private $name;

    /** @var Readme The readme file. */
    private $readme;

    /** @var \Twig_Environment */
    private $twig;

    /**
     * Constructor.
     *
     * @param string            $id   An identifier for the page.
     * @param string            $name A name of the page.
     * @param \Twig_Environment $twig
     */
    public function __construct(string $id, string $name, \Twig_Environment $twig)
    {
        $this->id = $id;
        $this->name = $name;
        $this->twig = $twig;
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

    /**
     * Gets the filename of the page.
     *
     * @return string
     */
    public function getFilename(): string
    {
        return $this->id . '.html';
    }

    /**
     * Writes the page to a folder.
     *
     * @param string $path A path to a folder to write the page in.
     *
     * @return void
     * @throws Exception Thrown if the page cannot be written.
     */
    public function write(string $path)
    {
        $filename = $path . '/' . $this->getFilename();
        $isSuccess = file_put_contents($filename, $this->getContent());
        if ($isSuccess === false) {
            throw new \Exception('Unable to write page.');
        }
    }

    /**
     * Gets the contents of the page.
     *
     * @return string
     */
    private function getContent(): string
    {
        return $this->twig->render(
            'package.twig',
            [
                'title'  => $this->name,
                'readme' => $this->readme->getContentAsHtml(),
            ]
        );
    }
}
