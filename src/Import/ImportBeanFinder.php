<?php


namespace Pars\Model\Import;


use Pars\Bean\Factory\BeanFactoryInterface;
use Pars\Core\Database\AbstractDatabaseBeanFinder;
use Pars\Core\Database\DatabaseBeanLoader;

/**
 * Class ImportBeanFinder
 * @package Pars\Model\Import
 * @method ImportBean getBean(bool $fetchAllData = false)
 * @method ImportBeanList getBeanList(bool $fetchAllData = false)
 */
class ImportBeanFinder extends AbstractDatabaseBeanFinder
{

    protected function createBeanFactory(): BeanFactoryInterface
    {
        return new ImportBeanFactory();
    }

    protected function initLoader(DatabaseBeanLoader $loader)
    {

        $loader->addColumn('Import_ID', 'Import_ID', 'Import', 'Import_ID', true);
        $loader->addColumn('Article_ID', 'Article_ID', 'Import', 'Import_ID');
        $loader->addColumn('Import_Name', 'Import_Name', 'Import', 'Import_ID');
        $loader->addColumn('ImportType_Code', 'ImportType_Code', 'Import', 'Import_ID');
        $loader->addColumn('Import_Data', 'Import_Data', 'Import', 'Import_ID');
        $loader->addColumn('Import_Active', 'Import_Active', 'Import', 'Import_ID');
        $loader->addColumn('Import_Day', 'Import_Day', 'Import', 'Import_ID');
        $loader->addColumn('Import_Hour', 'Import_Hour', 'Import', 'Import_ID');
        $loader->addColumn('Import_Minute', 'Import_Minute', 'Import', 'Import_ID');
        $loader->addColumn('Timestamp_Create', 'Timestamp_Create', 'Import', 'Import_ID');
        $loader->addColumn('Timestamp_Edit', 'Timestamp_Edit', 'Import', 'Import_ID');
        $loader->addColumn('Person_ID_Create', 'Person_ID_Create', 'Import', 'Import_ID');
        $loader->addColumn('Person_ID_Edit', 'Person_ID_Edit', 'Import', 'Import_ID');
    }

    /**
     * @param int $id
     * @return $this
     */
    public function setImport_ID(int $id)
    {
        $this->filter(['Import_ID' => $id]);
        return $this;
    }


    /**
     * @param int $id
     * @return $this
     */
    public function setArticle_ID(int $id)
    {
        $this->filter(['Article_ID' => $id]);
        return $this;
    }
}
