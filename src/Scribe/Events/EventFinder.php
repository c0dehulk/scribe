<?php
declare(strict_types = 1);

namespace Codehulk\Scribe\Events;

use Codehulk\Package\PackageInterface;
use Symfony\Component\Finder\Finder;

/**
 * A tool to find events within a package.
 *
 * @package Codehulk\Scribe
 * @api
 */
class EventFinder implements \IteratorAggregate
{
    /** @var PackageInterface */
    private $package;

    /**
     * Constructor.
     *
     * @param PackageInterface $package
     */
    public function __construct(PackageInterface $package)
    {
        $this->package = $package;
    }

    /**
     * @inheritdoc
     *
     * @return \Iterator|string[]
     */
    public function getIterator()
    {
        $namespace = $this->package->getId() . '\\Event';

        $eventNs = $this->package->findNamespace($namespace);
        if (!$eventNs) {
            return;
        }

        $finder = new Finder();
        $finder->files()
               ->in($eventNs->getPaths())
               ->ignoreDotFiles(true)
               ->name('*.php')
               ->notName('*Test.php');

        foreach ($finder as $file) {
            $class = substr($file->getFilename(), 0, -4);
            $fqcn = $namespace . '\\' . $class;
            yield $fqcn;
        }
    }
}
