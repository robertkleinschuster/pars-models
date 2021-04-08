<?php

namespace Pars\Model\Cms\Page\Layout;

use Laminas\Db\Adapter\Adapter;
use Pars\Bean\Processor\AbstractBeanProcessor;
use Pars\Bean\Type\Base\BeanInterface;
use Pars\Core\Database\DatabaseBeanSaver;

/**
 * Class CmsPageLayoutBeanProcessor
 * @package Pars\Model\Cms\Page\Layout
 */
class CmsPageLayoutBeanProcessor extends AbstractBeanProcessor
{

    /**
     * CmsPageStateBeanProcessor constructor.
     */
    public function __construct(Adapter $adapter)
    {
        $saver = new DatabaseBeanSaver($adapter);
        $saver->addColumn('CmsPageLayout_Code', 'CmsPageLayout_Code', 'CmsPageLayout', 'CmsPageLayout_Code', true);
        $saver->addColumn('CmsPageLayout_Active', 'CmsPageLayout_Active', 'CmsPageLayout', 'CmsPageLayout_Code');
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
