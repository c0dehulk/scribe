<?php
declare(strict_types = 1);

use function DI\factory;

/**
 * Configuration for DI container.
 */
return [
    \Twig_Environment::class => factory([\Codehulk\PackageDocs\Template\ServiceFactory::class, 'create']),
];