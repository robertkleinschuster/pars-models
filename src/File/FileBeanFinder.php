<?php

namespace Pars\Model\File;

use Pars\Bean\Factory\BeanFactoryInterface;
use Pars\Core\Database\AbstractDatabaseBeanFinder;
use Pars\Core\Database\DatabaseBeanLoader;

/**
 * Class FileBeanFinder
 * @package Pars\Model\File
 * @method FileBean getBean(bool $fetchAllData = false)
 * @method FileBeanList getBeanList(bool $fetchAllData = false)
 */
class FileBeanFinder extends AbstractDatabaseBeanFinder
{

    protected function createBeanFactory(): BeanFactoryInterface
    {
        return new FileBeanFactory();
    }

    protected function initLoader(DatabaseBeanLoader $loader)
    {
        $loader->addField('File.File_ID')->setKey(true);
        $loader->addField('File.File_Name');
        $loader->addField('File.File_Code');
        $loader->addField('File.FileType_Code')->addTable('FileType');
        $loader->addField('FileType.FileType_Mime')->setJoinField('FileType_Code');
        $loader->addField('FileType.FileType_Name')->setJoinField('FileType_Code');
        $loader->addField('File.FileDirectory_ID')->addTable('FileDirectory');
        $loader->addField('FileDirectory.FileDirectory_Code')->setJoinField('FileDirectory_ID');
        $loader->addField('FileDirectory.FileDirectory_Name')->setJoinField('FileDirectory_ID');
        $loader->addDefaultFields('File');
    }


    /**
     * @param string $type
     * @return $this
     * @deprecated
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
     * @param int $id
     * @param bool $exclude
     * @return $this
     * @deprecated
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
     * @param string $name
     * @param bool $exclude
     * @return $this
     * @deprecated
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
     * @param string $code
     * @param bool $exclude
     * @return $this
     * @deprecated
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
     * @param string $type
     * @return $this
     * @deprecated
     */
    public function setFileDirectory_Code(string $type): self
    {
        return $this->filterFileDirectory_Code($type);
    }

    /**
     * @param int $id
     * @return $this
     * @deprecated
     */
    public function setFileDirectory_ID(int $id): self
    {
        return $this->filterFileDirectory_ID($id);
    }
}
