<?php
declare(strict_types = 1);

namespace Codehulk\PackageDocs\Template;

use Interop\Container\ContainerInterface;
use Twig;

/**
 * A factory responsible for instantiating Twig.
 *
 * @package Codehulk\PackageDocs\Template
 */
class ServiceFactory
{
    /**
     * Initialises Twig.
     *
     * @param ContainerInterface $container The container.
     *
     * @return Twig\Environment
     */
    public function create(ContainerInterface $container): Twig\Environment
    {
        return new Twig\Environment(
            new Twig\Loader\FilesystemLoader('resources/theme/default')
        );
    }
}
