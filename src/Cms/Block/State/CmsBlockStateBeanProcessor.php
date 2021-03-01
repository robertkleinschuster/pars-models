<?php

namespace Pars\Model\Cms\Block\State;

use Laminas\Db\Adapter\Adapter;
use Niceshops\Bean\Processor\AbstractBeanProcessor;
use Niceshops\Bean\Type\Base\BeanInterface;
use Pars\Core\Database\DatabaseBeanSaver;

class CmsBlockStateBeanProcessor extends AbstractBeanProcessor
{


    /**
     * CmsBlockStateBeanProcessor constructor.
     */
    public function __construct(Adapter $adapter)
    {
        $saver = new DatabaseBeanSaver($adapter);
        $saver->addColumn('CmsBlockState_Code', 'CmsBlockState_Code', 'CmsBlockState', 'CmsBlockState_Code', true);
        $saver->addColumn('CmsBlockState_Active', 'CmsBlockState_Active', 'CmsBlockState', 'CmsBlockState_Code');
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
