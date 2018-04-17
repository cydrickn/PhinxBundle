<?php

namespace Cydrickn\PhinxBundle\Command;

use LogicException;
use Phinx\Console\Command\Rollback;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Description of RollbackCommand
 *
 * @author Cydrick Nonog <cydrick.dev@gmail.com>
 */
class RollbackCommand extends Rollback implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    public function configure()
    {
        $this->setName('phinx:migrations:rollback');
        $this->addOption('--environment', null, InputOption::VALUE_REQUIRED, 'The target environment');
        $this->addOption('--configuration', '-c', InputOption::VALUE_REQUIRED, 'The configuration file to load');
        $this->addOption('--parser', '-p', InputOption::VALUE_REQUIRED, 'Parser used to read the config file. Defaults to YAML')
            ->setDescription('Rollback the last or to a specific migration')
            ->addOption('--target', '-t', InputOption::VALUE_REQUIRED, 'The version number to rollback to')
            ->addOption('--date', '-d', InputOption::VALUE_REQUIRED, 'The date to rollback to')
            ->addOption('--force', '-f', InputOption::VALUE_NONE, 'Force rollback to ignore breakpoints')
            ->addOption('--dry-run', '-x', InputOption::VALUE_NONE, 'Dump query to standard output instead of executing it')
            ->setHelp(
                <<<EOT
The <info>rollback</info> command reverts the last migration, or optionally up to a specific version

<info>phinx rollback -e development</info>
<info>phinx rollback -e development -t 20111018185412</info>
<info>phinx rollback -e development -d 20111018</info>
<info>phinx rollback -e development -v</info>
<info>phinx rollback -e development -t 20111018185412 -f</info>

If you have a breakpoint set, then you can rollback to target 0 and the rollbacks will stop at the breakpoint.
<info>phinx rollback -e development -t 0 </info>

The <info>version_order</info> configuration option is used to determine the order of the migrations when rolling back.
This can be used to allow the rolling back of the last executed migration instead of the last created one, or combined
with the <info>-d|--date</info> option to rollback to a certain date using the migration start times to order them.

EOT
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output): void
    {
        $this->setConfig($this->getContainer()->get('cydrickn_phinx.config'));
        parent::execute($input, $output);
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
