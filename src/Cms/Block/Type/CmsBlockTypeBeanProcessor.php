<?php

namespace Pars\Model\Cms\Block\Type;

use Laminas\Db\Adapter\Adapter;
use Pars\Bean\Processor\AbstractBeanProcessor;
use Pars\Bean\Type\Base\BeanInterface;
use Pars\Core\Database\DatabaseBeanSaver;

class CmsBlockTypeBeanProcessor extends AbstractBeanProcessor
{

    /**
     * CmsBlockStateBeanProcessor constructor.
     */
    public function __construct(Adapter $adapter)
    {
        $saver = new DatabaseBeanSaver($adapter);
        $saver->addColumn('CmsBlockType_Code', 'CmsBlockType_Code', 'CmsBlockType', 'CmsBlockType_Code', true);
        $saver->addColumn('CmsBlockType_Active', 'CmsBlockType_Active', 'CmsBlockType', 'CmsBlockType_Code');
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
