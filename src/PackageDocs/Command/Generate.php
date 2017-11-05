<?php
declare(strict_types = 1);

namespace Codehulk\PackageDocs\Command;

use Codehulk\Package;
use Codehulk\PackageDocs\ConfigFile;
use Codehulk\PackageDocs\Generator;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * A command to generate package documentation from a configuration file.
 *
 * @package Codehulk\PackageDocs
 */
class Generate extends Command
{
    /** @var Generator */
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
        $this->addOption(
            'config',
            'c',
            InputOption::VALUE_REQUIRED,
            'The configuration file to use.'
        );
    }

    /**
     * @inheritdoc
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('Generating documentation...');

        // Load the configuration.
        $config = new ConfigFile($input->getOption('config'));

        // Set the packages to find.
        $composer = new Package\ComposerJson($config->getComposerPath());
        $finder = new Package\Finder(
            $composer->getNamespaces(),
            $config->getPackageRoots()
        );

        // Generate the documentation.
        $this->generator->createDocs($finder, $config);

        $output->writeln('Done.');
        return 0;
    }
}
