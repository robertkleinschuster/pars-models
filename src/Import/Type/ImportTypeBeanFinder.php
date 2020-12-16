<?php


namespace Pars\Model\Import\Type;


use Laminas\Db\Adapter\Adapter;
use Niceshops\Bean\Finder\AbstractBeanFinder;
use Pars\Core\Database\DatabaseBeanLoader;

class ImportTypeBeanFinder extends AbstractBeanFinder
{
    public function __construct(Adapter $adapter)
    {
        $loader = new DatabaseBeanLoader($adapter);
        $loader->addColumn('ImportType_Code', 'ImportType_Code', 'ImportType', 'ImportType_Code', true);
        $loader->addColumn('ImportType_Active', 'ImportType_Active', 'ImportType', 'ImportType_Code');
        parent::__construct($loader, new ImportTypeBeanFactory());
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
