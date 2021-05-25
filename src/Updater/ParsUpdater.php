<?php


namespace Pars\Model\Updater;

use Pars\Core\Container\ParsContainer;
use Pars\Model\Updater\Database\DataDatabaseUpdater;
use Pars\Model\Updater\Database\SchemaDatabaseUpdater;
use Pars\Model\Updater\Database\SpecialDatabaseUpdater;

/**
 * Class ParsUpdater
 * @package Pars\Model\Updater
 */
class ParsUpdater extends \Pars\Core\Deployment\ParsUpdater
{
    /**
     * @return array
     */
    public function getDbUpdaterList(): array
    {
        $parsContainer = $this->container->get(ParsContainer::class);
        return parent::getDbUpdaterList() + [
            new SchemaDatabaseUpdater($parsContainer),
            new DataDatabaseUpdater($parsContainer),
            new SpecialDatabaseUpdater($parsContainer),
        ];
    }
}
