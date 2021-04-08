<?php

namespace Pars\Model\Cms\Page\Type;

use Laminas\Db\Adapter\Adapter;
use Pars\Bean\Processor\AbstractBeanProcessor;
use Pars\Bean\Type\Base\BeanInterface;
use Pars\Core\Database\DatabaseBeanSaver;

/**
 * Class CmsPageTypeBeanProcessor
 * @package Pars\Model\Cms\Page\Type
 */
class CmsPageTypeBeanProcessor extends AbstractBeanProcessor
{

    /**
     * CmsPageStateBeanProcessor constructor.
     */
    public function __construct(Adapter $adapter)
    {
        $saver = new DatabaseBeanSaver($adapter);
        $saver->addColumn('CmsPageType_Code', 'CmsPageType_Code', 'CmsPageType', 'CmsPageType_Code', true);
        $saver->addColumn('CmsPageType_Active', 'CmsPageType_Active', 'CmsPageType', 'CmsPageType_Code');
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
