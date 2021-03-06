<?php
declare(strict_types = 1);

namespace Codehulk\Scribe\Page;

/**
 * Describes a page.
 *
 * @package Codehulk\Scribe
 * @public
 */
interface PageInterface
{
    /**
     * Gets the filename of the page.
     */
    public function getFilename(): string;

    /**
     * Gets the contents of the page.
     *
     * @return string
     */
    public function getContent(): string;
}
