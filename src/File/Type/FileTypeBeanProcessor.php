<?php

namespace Pars\Model\File\Type;

use Laminas\Db\Adapter\Adapter;
use Niceshops\Bean\Processor\AbstractBeanProcessor;
use Niceshops\Bean\Type\Base\BeanInterface;
use Pars\Core\Database\DatabaseBeanSaver;

/**
 * Class FileTypeBeanProcessor
 * @package Pars\Model\File\Type
 */
class FileTypeBeanProcessor extends AbstractBeanProcessor
{

    /**
     * ArticleStateBeanProcessor constructor.
     */
    public function __construct(Adapter $adapter)
    {
        $saver = new DatabaseBeanSaver($adapter);
        $saver->addColumn('FileType_Code', 'FileType_Code', 'FileType', 'FileType_Code', true);
        $saver->addColumn('FileType_Name', 'FileType_Name', 'FileType', 'FileType_Code');
        $saver->addColumn('FileType_Mime', 'FileType_Mime', 'FileType', 'FileType_Code');
        $saver->addColumn('FileType_Active', 'FileType_Active', 'FileType', 'FileType_Code');
        parent::__construct($saver);
    }

    protected function validateForSave(BeanInterface $bean): bool
    {
        return true;
    }

    protected function validateForDelete(BeanInterface $bean): bool
    {
        return true;
    }
}
