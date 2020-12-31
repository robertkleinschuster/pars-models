<?php

namespace Pars\Model\Cms\Post\Type;

use Laminas\Db\Adapter\Adapter;
use Niceshops\Bean\Processor\AbstractBeanProcessor;
use Niceshops\Bean\Type\Base\BeanInterface;
use Pars\Core\Database\DatabaseBeanSaver;

/**
 * Class CmsPostTypeBeanProcessor
 * @package Pars\Model\Cms\Post\Type
 */
class CmsPostTypeBeanProcessor extends AbstractBeanProcessor
{

    /**
     * CmsPostStateBeanProcessor constructor.
     */
    public function __construct(Adapter $adapter)
    {
        $saver = new DatabaseBeanSaver($adapter);
        $saver->addColumn('CmsPostType_Code', 'CmsPostType_Code', 'CmsPostType', 'CmsPostType_Code', true);
        $saver->addColumn('CmsPostType_Active', 'CmsPostType_Active', 'CmsPostType', 'CmsPostType_Code');
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
