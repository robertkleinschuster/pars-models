<?php


namespace Pars\Model\Updater;

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
        $adapter = $this->container->get(\Laminas\Db\Adapter\AdapterInterface::class);
        return parent::getDbUpdaterList() + [
            new SchemaDatabaseUpdater($adapter),
            new DataDatabaseUpdater($adapter),
            new SpecialDatabaseUpdater($adapter),
        ];
    }
}
