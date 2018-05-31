<?php
declare(strict_types = 1);

namespace Codehulk\Scribe\Cli;

use DI\ContainerBuilder;
use Psr\Container\ContainerInterface;

/**
 * The Scribe command-line application.
 *
 * @package Codehulk\Scribe
 * @public
 */
class App extends \Symfony\Component\Console\Application
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        parent::__construct('Scribe');

        $container = $this->buildContainer();
        $this->addCommands(
            [
                $container->get(GenerateCommand::class),
            ]
        );
    }

    /**
     * Builds the DI container for the application.
     *
     * @return ContainerInterface
     */
    private function buildContainer(): ContainerInterface
    {
        $builder = new ContainerBuilder();
        return $builder->build();
    }
}
