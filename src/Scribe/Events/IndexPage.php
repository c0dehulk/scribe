<?php
declare(strict_types = 1);

namespace Codehulk\Scribe\Events;

use Exception;
use Twig_Environment;

/**
 * An index page for events.
 *
 * @package Codehulk\Scribe\Events
 * @api
 */
class IndexPage
{
    /** @var Twig_Environment */
    private $twig;

    /** @var string[] */
    private $events;

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
     * @param string $name The name of the event to add.
     *
     * @return void
     */
    public function add(string $name)
    {
        $this->events[] = $name;
    }

    /**
     * Gets the contents of the page.
     *
     * @return string
     */
    private function getContent(): string
    {
        return $this->twig->render(
            'events.twig',
            ['events' => $this->events]
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
        $filename = $path . '/events.html';
        $isSuccess = file_put_contents($filename, $this->getContent());
        if ($isSuccess === false) {
            throw new Exception('Unable to write page.');
        }
    }

}
