<?php

namespace Cydrickn\PhinxBundle\Command;

use LogicException;
use Phinx\Console\Command\Migrate;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Description of MigrateCommand
 *
 * @author Cydrick Nonog <cydrick.dev@gmail.com>
 */
class MigrateCommand extends Migrate implements ContainerAwareInterface
{
    private $container;

    protected function configure()
    {
        $this->addOption('--environment', '-l', InputOption::VALUE_REQUIRED, 'The target environment');

        $this->setName('phinx:migrations:migrate')
            ->setDescription('Migrate the database')
            ->addOption('--target', '-t', InputOption::VALUE_REQUIRED, 'The version number to migrate to')
            ->addOption('--date', '-d', InputOption::VALUE_REQUIRED, 'The date to migrate to')
            ->addOption('--dry-run', '-x', InputOption::VALUE_NONE, 'Dump query to standard output instead of executing it')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): void
    {
        $this->setConfig($this->getContainer()->get('cydrickn_phinx.config'));
        parent::execute($input, $output);
    }

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function getContainer(): ContainerInterface
    {
        if (null === $this->container) {
            $application = $this->getApplication();
            if (null === $application) {
                throw new LogicException('The container cannot be retrieved as the application instance is not yet set.');
            }

            $this->container = $application->getKernel()->getContainer();
        }

        return $this->container;
    }
}
