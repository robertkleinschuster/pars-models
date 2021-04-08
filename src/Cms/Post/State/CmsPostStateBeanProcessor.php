<?php

namespace Pars\Model\Cms\Post\State;

use Laminas\Db\Adapter\Adapter;
use Pars\Bean\Processor\AbstractBeanProcessor;
use Pars\Bean\Type\Base\BeanInterface;
use Pars\Core\Database\DatabaseBeanSaver;

/**
 * Class CmsPostStateBeanProcessor
 * @package Pars\Model\Cms\Post\State
 */
class CmsPostStateBeanProcessor extends AbstractBeanProcessor
{
    /**
     * CmsPostStateBeanProcessor constructor.
     */
    public function __construct(Adapter $adapter)
    {
        $saver = new DatabaseBeanSaver($adapter);
        $saver->addColumn('CmsPostState_Code', 'CmsPostState_Code', 'CmsPostState', 'CmsPostState_Code', true);
        $saver->addColumn('CmsPostState_Active', 'CmsPostState_Active', 'CmsPostState', 'CmsPostState_Code');
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
