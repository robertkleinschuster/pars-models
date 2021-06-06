<?php

namespace Pars\Model\File\Directory;

use Pars\Bean\Factory\BeanFactoryInterface;
use Pars\Core\Database\AbstractDatabaseBeanFinder;
use Pars\Core\Database\DatabaseBeanLoader;
use Pars\Model\File\FileBeanFinder;

/**
 * Class FileDirectoryBeanFinder
 * @package Pars\Model\File\Directory
 * @method FileDirectoryBean getBean(bool $fetchAllData = false)
 * @method FileDirectoryBeanList getBeanList(bool $fetchAllData = false)
 * @method FileDirectoryBeanFactory getBeanFactory()
 */
class FileDirectoryBeanFinder extends AbstractDatabaseBeanFinder
{

    protected function createBeanFactory(): BeanFactoryInterface
    {
        return new FileDirectoryBeanFactory();
    }

    protected function initLinkedFinder()
    {
        parent::initLinkedFinder();
        $this->addLinkedFinder(new FileBeanFinder($this->getDatabaseAdapter()), 'File_BeanList', 'FileDirectory_ID', 'FileDirectory_ID');
    }


    protected function initLoader(DatabaseBeanLoader $loader)
    {
        $loader->addColumn('FileDirectory_ID', 'FileDirectory_ID', 'FileDirectory', 'FileDirectory_ID', true);
        $loader->addColumn('FileDirectory_Code', 'FileDirectory_Code', 'FileDirectory', 'FileDirectory_ID');
        $loader->addColumn('FileDirectory_Name', 'FileDirectory_Name', 'FileDirectory', 'FileDirectory_ID');
        $loader->addColumn('FileDirectory_Active', 'FileDirectory_Active', 'FileDirectory', 'FileDirectory_ID');
        $loader->addColumn('Person_ID_Create', 'Person_ID_Create', 'FileDirectory', 'FileDirectory_ID');
        $loader->addColumn('Person_ID_Edit', 'Person_ID_Edit', 'FileDirectory', 'FileDirectory_ID');
        $loader->addColumn('Timestamp_Create', 'Timestamp_Create', 'FileDirectory', 'FileDirectory_ID');
        $loader->addColumn('Timestamp_Edit', 'Timestamp_Edit', 'FileDirectory', 'FileDirectory_ID');

    }


    public function setFileDirectory_Active(bool $active): self
    {
        $this->getBeanLoader()->filterValue('FileDirectory_Active', $active);
        return $this;
    }


    public function setFileDirectory_ID(int $id, bool $exclude = false): self
    {
        if ($exclude) {
            $this->getBeanLoader()->excludeValue('FileDirectory_ID', $id);
        } else {
            $this->getBeanLoader()->filterValue('FileDirectory_ID', $id);
        }
        return $this;
    }

    public function setFileDirectory_Name(string $name): self
    {
        $this->getBeanLoader()->filterValue('FileDirectory_Name', $name);
        return $this;
    }

    public function setFileDirectory_Code(string $code): self
    {
        $this->getBeanLoader()->filterValue('FileDirectory_Code', $code);
        return $this;
    }
}
