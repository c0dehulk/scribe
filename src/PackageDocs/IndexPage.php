<?php
declare(strict_types = 1);

namespace Codehulk\PackageDocs;

use Exception;
use Twig_Environment;

/**
 * IndexPage
 */
class IndexPage
{
    /** @var Twig_Environment */
    private $twig;

    /** @var PackageIndexPage[] */
    private $pages;

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

    public function getFilename(): string
    {
        return 'index.html';
    }


    /**
     * Gets the contents of the page.
     *
     * @return string
     */
    private function getContent(): string
    {
        return $this->twig->render(
            'index.twig',
            ['packages' => $this->pages]
        );
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
            throw new Exception('Unable to write page.');
        }
    }

}
