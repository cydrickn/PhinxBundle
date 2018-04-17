<?php

namespace Cydrickn\PhinxBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Description of CydricknPhinxBundle
 *
 * @author Cydrick Nonog <cydrick.dev@gmail.com>
 */
class CydricknPhinxBundle extends Bundle
{
    public function registerCommands(\Symfony\Component\Console\Application $application)
    {
        $application->add(new Command\CreateMigrationCommand());
        $application->add(new Command\MigrateCommand());
        $application->add(new Command\RollbackCommand());
    }
}
