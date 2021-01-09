<?php

namespace Pars\Model\File;

use Laminas\Db\Adapter\Adapter;
use Niceshops\Bean\Finder\AbstractBeanFinder;
use Pars\Core\Database\DatabaseBeanLoader;

/**
 * Class FileBeanFinder
 * @package Pars\Model\File
 */
class FileBeanFinder extends AbstractBeanFinder
{
    public function __construct(Adapter $adapter)
    {
        $loader = new DatabaseBeanLoader($adapter);
        $loader->addColumn('File_ID', 'File_ID', 'File', 'File_ID', true);
        $loader->addColumn('File_Name', 'File_Name', 'File', 'File_ID');
        $loader->addColumn('File_Code', 'File_Code', 'File', 'File_ID');
        $loader->addColumn('Person_ID_Create', 'Person_ID_Create', 'File', 'File_ID');
        $loader->addColumn('Person_ID_Edit', 'Person_ID_Edit', 'File', 'File_ID');
        $loader->addColumn('Timestamp_Create', 'Timestamp_Create', 'File', 'File_ID');
        $loader->addColumn('Timestamp_Edit', 'Timestamp_Edit', 'File', 'File_ID');
        $loader->addColumn('FileType_Code', 'FileType_Code', 'File', 'File_ID', false, null, ['FileType']);
        $loader->addColumn('FileDirectory_ID', 'FileDirectory_ID', 'File', 'FileDirectory_ID', false, null, ['FileDirectory']);
        $loader->addColumn('FileDirectory_Code', 'FileDirectory_Code', 'FileDirectory', 'FileDirectory_ID');
        $loader->addColumn('FileDirectory_Name', 'FileDirectory_Name', 'FileDirectory', 'FileDirectory_ID');
        $loader->addColumn('FileType_Mime', 'FileType_Mime', 'FileType', 'FileType_Code');
        $loader->addColumn('FileType_Name', 'FileType_Name', 'FileType', 'FileType_Code');
        parent::__construct($loader, new FileBeanFactory());
    }


    public function setFileType_Code(string $type): self
    {
        $this->getBeanLoader()->filterValue('FileType_Code', $type);
        return $this;
    }


    public function setFile_ID(int $id, bool $exclude = false): self
    {
        if ($exclude) {
            $this->getBeanLoader()->excludeValue('File_ID', $id);
        } else {
            $this->getBeanLoader()->filterValue('File_ID', $id);
        }
        return $this;
    }

    public function setFile_Name(string $name, bool $exclude = false): self
    {
        if ($exclude) {
            $this->getBeanLoader()->excludeValue('File_Name', $name);
        } else {
            $this->getBeanLoader()->filterValue('File_Name', $name);
        }
        return $this;
    }

    public function setFile_Code(string $code, bool $exclude = false): self
    {
        if ($exclude) {
            $this->getBeanLoader()->excludeValue('File_Code', $code);
        } else {
            $this->getBeanLoader()->filterValue('File_Code', $code);
        }
        return $this;
    }


    public function setFileDirectory_Code(string $type): self
    {
        $this->getBeanLoader()->filterValue('FileDirectory_Code', $type);
        return $this;
    }
}
