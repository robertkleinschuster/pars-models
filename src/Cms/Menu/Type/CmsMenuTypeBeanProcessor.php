<?php

namespace Pars\Model\Cms\Menu\Type;

use Laminas\Db\Adapter\Adapter;
use Pars\Bean\Processor\AbstractBeanProcessor;
use Pars\Bean\Type\Base\BeanInterface;
use Pars\Core\Database\DatabaseBeanSaver;

/**
 * Class CmsMenuTypeBeanProcessor
 * @package Pars\Model\Cms\Menu\Type
 */
class CmsMenuTypeBeanProcessor extends AbstractBeanProcessor
{

    /**
     * ArticleStateBeanProcessor constructor.
     */
    public function __construct(Adapter $adapter)
    {
        $saver = new DatabaseBeanSaver($adapter);
        $saver->addColumn('CmsMenuType_Code', 'CmsMenuType_Code', 'CmsMenuType', 'CmsMenuType_Code', true);
        $saver->addColumn('CmsMenuType_Active', 'CmsMenuType_Active', 'CmsMenuType', 'CmsMenuType_Code');
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
