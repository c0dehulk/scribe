<?php
declare(strict_types = 1);

namespace Codehulk\Scribe\Theme;

use Twig;

/**
 * Theme
 */
class Theme implements ThemeInterface
{
    private $path;

    public function __construct(string $path)
    {
        $this->path = realpath($path);
        if (!$this->path) {
            throw new \InvalidArgumentException('Invalid theme path.');
        }
    }

    /** @inheritdoc */
    public function getAssetsPath(): string
    {
        return $this->path . '/assets';
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

    public function setGlobalValues(array $globals)
    {
        foreach ($globals as $key => $value) {
            $this->getTwig()->addGlobal($key, $value);
        }
    }

    public function render(string $template, array $parameters): string
    {
        return $this->getTwig()->render($template, $parameters);
    }
}
