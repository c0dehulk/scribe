<?php
declare(strict_types = 1);

namespace Codehulk\Scribe\Cli;

use Codehulk\Package;
use Codehulk\Scribe\Config;
use Codehulk\Scribe\Generator\Generator;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * A command to generate package documentation from a configuration file.
 *
 * @package Codehulk\Scribe
 * @private
 */
class GenerateCommand extends Command
{
    /** @var Generator The documentation generator. */
    private $generator;

    /**
     * Constructor.
     *
     * @param Generator $generator A documentation generator.
     */
    public function __construct(Generator $generator)
    {
        parent::__construct();
        $this->generator = $generator;
    }

    /**
     * @inheritdoc
     */
    protected function configure()
    {
        $this->setName('generate');
        $this->setDescription('Generates package documentation.');
        $this->addArgument(
            'config',
            InputArgument::REQUIRED,
            'The configuration file to use.'
        );
        $this->addOption(
            'build',
            'b',
            InputOption::VALUE_OPTIONAL,
            'The build/version number to generate the documentation with.',
            ''
        );
    }

    /**
     * @inheritdoc
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('Generating documentation...');

        // Load the configuration.
        $config = new Config\File($input->getArgument('config'));

        // Set the packages to find.
        $composer = new Package\ComposerJson($config->getComposerPath());
        $finder = new Package\Finder(
            $composer->getNamespaces(),
            $config->getPackageRoots()
        );

        // Generate the documentation.
        $this->generator->createDocs($finder, $config, $input->getOption('build'));

        $output->writeln('Done.');
        return 0;
    }
}
