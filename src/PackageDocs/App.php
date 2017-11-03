<?php
declare(strict_types = 1);

namespace Codehulk\PackageDocs;

/**
 * The Package Documentor application.
 *
 * @package Codehulk\PackageDocs
 * @api
 */
class App extends \Symfony\Component\Console\Application
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        parent::__construct('Package Documentor');

        $this->addCommands([new Command\Generate()]);
    }
}
