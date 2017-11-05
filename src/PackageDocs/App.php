<?php
declare(strict_types = 1);

namespace Codehulk\PackageDocs;

use DI\ContainerBuilder;
use Interop\Container\ContainerInterface;

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
        $container = $this->buildContainer();

        parent::__construct('Package Documentor');
        $this->addCommands(
            [
                $container->get(Command\Generate::class),
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
        $builder->addDefinitions(require __DIR__ . '/../../config/di.config.php');
        return $builder->build();
    }
}
