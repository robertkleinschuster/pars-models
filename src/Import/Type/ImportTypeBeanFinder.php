<?php


namespace Pars\Model\Import\Type;



use Pars\Core\Database\AbstractDatabaseBeanFinder;
use Pars\Core\Database\DatabaseBeanLoader;
use Pars\Model\Import\ImportBean;
use Pars\Model\Import\ImportBeanList;

/**
 * Class ImportTypeBeanFinder
 * @package Pars\Model\Import\Type
 * @method ImportBean getBean(bool $fetchAllData = false)
 * @method ImportBeanList getBeanList(bool $fetchAllData = false)
 */
class ImportTypeBeanFinder extends AbstractDatabaseBeanFinder
{


    protected function initLoader(DatabaseBeanLoader $loader)
    {
        $loader->addColumn('ImportType_Code', 'ImportType_Code', 'ImportType', 'ImportType_Code', true);
        $loader->addColumn('ImportType_Active', 'ImportType_Active', 'ImportType', 'ImportType_Code');
    }


    /**
     * @param bool $active
     * @return $this
     */
    public function setImportType_Active(bool $active)
    {
        $this->filter(['ImportType_Active' => $active]);
        return $this;
    }

}
