<?php

namespace Cydrickn\PhinxBundle\Command;

use Phinx\Console\Command\Create;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Description of CreateMigration
 *
 * @author Cydrick Nonog <cydrick.dev@gmail.com>
 */
class CreateMigrationCommand extends Create implements ContainerAwareInterface
{
    private $container;

    protected function configure()
    {
        parent::configure();

        $this->setName('phinx:migrations:create');
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
                throw new \LogicException('The container cannot be retrieved as the application instance is not yet set.');
            }

            $this->container = $application->getKernel()->getContainer();
        }

        return $this->container;
    }
}
