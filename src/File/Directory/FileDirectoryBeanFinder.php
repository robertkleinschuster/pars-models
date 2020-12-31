<?php

namespace Pars\Model\File\Directory;

use Laminas\Db\Adapter\Adapter;
use Niceshops\Bean\Finder\AbstractBeanFinder;
use Pars\Core\Database\DatabaseBeanLoader;
use Pars\Model\File\FileBeanFinder;

/**
 * Class FileDirectoryBeanFinder
 * @package Pars\Model\File\Directory
 */
class FileDirectoryBeanFinder extends AbstractBeanFinder
{
    public function __construct(Adapter $adapter)
    {
        $loader = new DatabaseBeanLoader($adapter);
        $loader->addColumn('FileDirectory_ID', 'FileDirectory_ID', 'FileDirectory', 'FileDirectory_ID', true);
        $loader->addColumn('FileDirectory_Code', 'FileDirectory_Code', 'FileDirectory', 'FileDirectory_ID');
        $loader->addColumn('FileDirectory_Name', 'FileDirectory_Name', 'FileDirectory', 'FileDirectory_ID');
        $loader->addColumn('FileDirectory_Active', 'FileDirectory_Active', 'FileDirectory', 'FileDirectory_ID');
        $loader->addColumn('Person_ID_Create', 'Person_ID_Create', 'FileDirectory', 'FileDirectory_ID');
        $loader->addColumn('Person_ID_Edit', 'Person_ID_Edit', 'FileDirectory', 'FileDirectory_ID');
        $loader->addColumn('Timestamp_Create', 'Timestamp_Create', 'FileDirectory', 'FileDirectory_ID');
        $loader->addColumn('Timestamp_Edit', 'Timestamp_Edit', 'FileDirectory', 'FileDirectory_ID');

        parent::__construct($loader, new FileDirectoryBeanFactory());
        $this->addLinkedFinder(new FileBeanFinder($adapter), 'File_BeanList', 'FileDirectory_ID', 'FileDirectory_ID');
    }

    public function setFileDirectory_Active(bool $active): self
    {
        $this->getBeanLoader()->filterValue('FileDirectory_Active', $active);
        return $this;
    }


    public function setFileDirectory_ID(int $id): self
    {
        $this->getBeanLoader()->filterValue('FileDirectory_ID', $id);
        return $this;
    }
}
