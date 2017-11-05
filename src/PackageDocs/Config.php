<?php
declare(strict_types = 1);

namespace Codehulk\PackageDocs;

/**
 * A configuration interface.
 */
class Config
{
    /** @var array The configuration array. */
    private $config;

    /**
     * Constructor.
     *
     * @param array $config A configuration array.
     */
    public function __construct(array $config)
    {
        $this->config = $config;
    }

    /**
     * Gets the location of the composer.json file.
     *
     * @return string
     */
    public function getComposerPath(): string
    {
        return (string) $this->config['composer']['path'] ?? '';
    }

    /**
     * Gets the namespaces to treat as package roots.
     *
     * @return array
     * @throws \Exception Thrown if no package roots are specified.
     */
    public function getPackageRoots(): array
    {
        $roots = $this->config['packages']['roots'] ?? [];
        if (!is_array($roots)) {
            throw new \Exception('Missing package roots configuration.');
        }
        if (!$roots) {
            throw new \Exception('No package roots specified.');
        }
        return $roots;
    }

    /**
     * Gets the path to write the documentation to.
     *
     * @return string
     */
    public function getOutputPath(): string
    {
        return (string) $this->config['output']['path'] ?? '';
    }

    /**
     * Gets the path to write the documentation to.
     *
     * @return string
     */
    public function getThemePath(): string
    {
        $path = realpath($this->config['output']['theme'] ?? '');
        if (!$path) {
            $path = __DIR__ . '/../../resources/theme/default';
        }
        return $path;
    }

    public function getTitle(): string
    {
        return (string) ($this->config['output']['title'] ?? 'Documentation');
    }
}
