<?php
declare(strict_types = 1);

namespace Codehulk\Scribe\Config;

/**
 * A configuration reader for an array.
 *
 * @package Codehulk\Scribe
 * @public
 */
class Array_ implements ConfigInterface
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

    /** @inheritdoc */
    public function getComposerPath(): string
    {
        return (string) $this->config['composer']['path'] ?? '';
    }

    /** @inheritdoc */
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

    /** @inheritdoc */
    public function getOutputPath(): string
    {
        return (string) $this->config['output']['path'] ?? '';
    }

    /** @inheritdoc */
    public function getThemePath(): string
    {
        return (string) $this->config['output']['theme'] ?? '';
    }

    /** @inheritdoc */
    public function getTitle(): string
    {
        return (string) ($this->config['output']['title'] ?? 'Scribe');
    }
}
