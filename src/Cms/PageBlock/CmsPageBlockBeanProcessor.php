<?php

namespace Pars\Model\Cms\PageBlock;

use Laminas\Db\Adapter\Adapter;
use Niceshops\Bean\Processor\AbstractBeanProcessor;
use Niceshops\Bean\Processor\OrderMetaFieldHandlerInterface;
use Niceshops\Bean\Type\Base\BeanInterface;
use Niceshops\Bean\Validator\FieldNotEmptyBeanValidator;
use Pars\Core\Database\DatabaseBeanSaver;

/**
 * Class CmsPageBlockBeanProcessor
 * @package Pars\Model\Cms\PageBlock
 */
class CmsPageBlockBeanProcessor extends AbstractBeanProcessor
{
    private $adapter;

    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
        $saver = new DatabaseBeanSaver($adapter);
        $saver->addColumn('CmsPage_ID', 'CmsPage_ID', 'CmsPage_CmsBlock', 'CmsPage_ID', true);
        $saver->addColumn('CmsBlock_ID', 'CmsBlock_ID', 'CmsPage_CmsBlock', 'CmsBlock_ID', true);
        $saver->addColumn('CmsPage_CmsBlock_Order', 'CmsPage_CmsBlock_Order', 'CmsPage_CmsBlock', 'CmsBlock_ID');
        $saver->addColumn('Person_ID_Create', 'Person_ID_Create', 'CmsPage_CmsBlock', 'CmsBlock_ID');
        $saver->addColumn('Person_ID_Edit', 'Person_ID_Edit', 'CmsPage_CmsBlock', 'CmsBlock_ID');
        $saver->addColumn('Timestamp_Create', 'Timestamp_Create', 'CmsPage_CmsBlock', 'CmsBlock_ID');
        $saver->addColumn('Timestamp_Edit', 'Timestamp_Edit', 'CmsPage_CmsBlock', 'CmsBlock_ID');

        parent::__construct($saver);
        $this->addMetaFieldHandler(new OrderMetaFieldHandlerInterface(new CmsPageBlockBeanFinder($adapter), 'CmsPage_CmsBlock_Order', 'CmsPage_ID'));
        $this->addDeleteValidator(new FieldNotEmptyBeanValidator('CmsPage_ID'));
        $this->addDeleteValidator(new FieldNotEmptyBeanValidator('CmsBlock_ID'));
    }
}
