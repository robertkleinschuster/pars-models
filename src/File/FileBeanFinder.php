<?php

namespace Pars\Model\File;

use Laminas\Db\Adapter\Adapter;
use Pars\Bean\Finder\AbstractBeanFinder;
use Pars\Core\Database\DatabaseBeanLoader;

/**
 * Class FileBeanFinder
 * @package Pars\Model\File
 * @method FileBean getBean(bool $fetchAllData = false)
 * @method FileBeanList getBeanList(bool $fetchAllData = false)
 */
class FileBeanFinder extends AbstractBeanFinder
{
    public function __construct($adapter)
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

    /**
     * @deprecated
     * @param string $type
     * @return $this
     */
    public function setFileType_Code(string $type): self
    {
        return $this->filterFileType_Code($type);
    }

    /**
     * @param string $code
     * @return $this
     */
    public function filterFileType_Code(string $code): self
    {
        return $this->filter(['FileType_Code' => $code]);
    }

    /**
     * @deprecated
     * @param int $id
     * @param bool $exclude
     * @return $this
     */
    public function setFile_ID(int $id, bool $exclude = false): self
    {
        if ($exclude) {
            $this->excludeFile_ID($id);
        } else {
            $this->filterFile_ID($id);
        }
        return $this;
    }

    /**
     * @param int $id
     * @return $this
     */
    public function excludeFile_ID(int $id): self
    {
        return $this->exclude(['File_ID' => $id]);
    }

    /**
     * @param int $id
     * @return $this
     */
    public function filterFile_ID(int $id): self
    {
        return $this->filter(['File_ID' => $id]);
    }

    /**
     * @deprecated
     * @param string $name
     * @param bool $exclude
     * @return $this
     */
    public function setFile_Name(string $name, bool $exclude = false): self
    {
        if ($exclude) {
            $this->excludeFile_Name($name);
        } else {
            $this->filterFile_Name($name);
        }
        return $this;
    }

    /**
     * @param string $name
     * @return $this
     */
    public function filterFile_Name(string $name): self
    {
        return $this->filter(['File_Name' => $name]);
    }

    /**
     * @param string $name
     * @return $this
     */
    public function excludeFile_Name(string $name): self
    {
        return $this->exclude(['File_Name' => $name]);
    }

    /**
     * @deprecated
     * @param string $code
     * @param bool $exclude
     * @return $this
     */
    public function setFile_Code(string $code, bool $exclude = false): self
    {
        if ($exclude) {
            $this->excludeFile_Code($code);
        } else {
            $this->filterFile_Code($code);
        }
        return $this;
    }

    /**
     * @param string $code
     * @return $this
     */
    public function filterFile_Code(string $code): self
    {
        return $this->filter(['File_Code' => $code]);
    }

    /**
     * @param string $code
     * @return $this
     */
    public function excludeFile_Code(string $code): self
    {
        return $this->exclude(['File_Code' => $code]);
    }

    /**
     * @param string $code
     * @return $this
     */
    public function filterFileDirectory_Code(string $code): self
    {
        return $this->filter(['FileDirectory_Code' => $code]);
    }

    /**
     * @param int $id
     * @return $this
     */
    public function filterFileDirectory_ID(int $id): self
    {
        return $this->filter(['FileDirectory_ID' => $id]);
    }

    /**
     * @deprecated
     * @param string $type
     * @return $this
     */
    public function setFileDirectory_Code(string $type): self
    {
        return $this->filterFileDirectory_Code($type);
    }

    /**
     * @deprecated
     * @param int $id
     * @return $this
     */
    public function setFileDirectory_ID(int $id): self
    {
        return $this->filterFileDirectory_ID($id);
    }
}
