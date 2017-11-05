<?php
declare(strict_types = 1);

namespace Codehulk\PackageDocs;

use Exception;

/**
 * IndexPage
 */
class IndexPage
{
    /** @var PackageIndexPage[] */
    private $pages;

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
        $packages = '';
        foreach ($this->pages as $page) {
            $packages .= "<li><a href=\"{$page->getFilename()}\">{$page->getFilename()}</a></li>";
        }

        return <<<HTML
<html>
    <body>
        <h1>Packages</h1>
        <ul>{$packages}</ul>
    </body>
</html>
HTML;
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
