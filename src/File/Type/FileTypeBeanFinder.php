<?php

namespace Pars\Model\File\Type;

use Laminas\Db\Adapter\Adapter;
use Pars\Bean\Finder\AbstractBeanFinder;
use Pars\Core\Database\DatabaseBeanLoader;

/**
 * Class FileTypeBeanFinder
 * @package Pars\Model\File\Type
 * @method FileTypeBean getBean(bool $fetchAllData = false)
 * @method FileTypeBeanList getBeanList(bool $fetchAllData = false)
 */
class FileTypeBeanFinder extends AbstractBeanFinder
{
    public function __construct(Adapter $adapter)
    {
        $loader = new DatabaseBeanLoader($adapter);
        $loader->addColumn('FileType_Code', 'FileType_Code', 'FileType', 'FileType_Code', true);
        $loader->addColumn('FileType_Name', 'FileType_Name', 'FileType', 'FileType_Code');
        $loader->addColumn('FileType_Mime', 'FileType_Mime', 'FileType', 'FileType_Code');
        $loader->addColumn('FileType_Active', 'FileType_Active', 'FileType', 'FileType_Code');
        parent::__construct($loader, new FileTypeBeanFactory());
    }

    public function setFileType_Active(bool $active): self
    {
        $this->getBeanLoader()->filterValue('FileType_Active', $active);
        return $this;
    }

    public function setFileType_Code(string $code): self
    {
        $this->getBeanLoader()->filterValue('FileType_Code', $code);
        return $this;
    }
}
