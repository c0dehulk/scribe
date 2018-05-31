<?php
declare(strict_types = 1);

namespace Codehulk\Scribe\Theme;

use Twig;

/**
 * A theme.
 *
 * @package Codehulk\Scribe
 * @private
 */
class Theme implements ThemeInterface
{
    /** @var string The path the theme is located in. */
    private $path;

    /** @var mixed[] The default parameters to use when rendering a template. */
    private $defaultParameters = [];

    /**
     * Constructor.
     *
     * @param string $path A path the theme is located in.
     */
    public function __construct(string $path)
    {
        $this->path = realpath($path);
        if (!$this->path) {
            throw new \InvalidArgumentException('Invalid theme path.');
        }
    }

    /**
     * @inheritdoc
     */
    public function getAssetsPath(): string
    {
        return $this->path . '/assets';
    }

    /**
     * @inheritdoc
     */
    public function setDefaultParameters(array $parameters)
    {
        $this->defaultParameters = $parameters;
    }

    /**
     * @inheritdoc
     */
    public function render(string $template, array $parameters = []): string
    {
        $context = array_merge($this->defaultParameters, $parameters);
        return $this->getTwig()->render($template, $context);
    }

    /**
     * Initialises Twig.
     *
     * @return Twig\Environment
     */
    private function getTwig(): Twig\Environment
    {
        return new Twig\Environment(
            new Twig\Loader\FilesystemLoader($this->path)
        );
    }
}
