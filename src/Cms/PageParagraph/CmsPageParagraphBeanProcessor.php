<?php

namespace Pars\Model\Cms\PageParagraph;

use Laminas\Db\Adapter\Adapter;
use Niceshops\Bean\Processor\AbstractBeanProcessor;
use Niceshops\Bean\Processor\OrderMetaFieldHandlerInterface;
use Pars\Core\Database\DatabaseBeanSaver;

/**
 * Class CmsPageParagraphBeanProcessor
 * @package Pars\Model\Cms\PageParagraph
 */
class CmsPageParagraphBeanProcessor extends AbstractBeanProcessor
{
    private $adapter;

    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
        $saver = new DatabaseBeanSaver($adapter);
        $saver->addColumn('CmsPage_ID', 'CmsPage_ID', 'CmsPage_CmsParagraph', 'CmsPage_ID', true);
        $saver->addColumn('CmsParagraph_ID', 'CmsParagraph_ID', 'CmsPage_CmsParagraph', 'CmsParagraph_ID', true);
        $saver->addColumn('CmsPage_CmsParagraph_Order', 'CmsPage_CmsParagraph_Order', 'CmsPage_CmsParagraph', 'CmsParagraph_ID');
        $saver->addColumn('Person_ID_Create', 'Person_ID_Create', 'CmsPage_CmsParagraph', 'CmsParagraph_ID');
        $saver->addColumn('Person_ID_Edit', 'Person_ID_Edit', 'CmsPage_CmsParagraph', 'CmsParagraph_ID');
        $saver->addColumn('Timestamp_Create', 'Timestamp_Create', 'CmsPage_CmsParagraph', 'CmsParagraph_ID');
        $saver->addColumn('Timestamp_Edit', 'Timestamp_Edit', 'CmsPage_CmsParagraph', 'CmsParagraph_ID');

        parent::__construct($saver);
        $this->addMetaFieldHandler(new OrderMetaFieldHandlerInterface(new CmsPageParagraphBeanFinder($adapter), 'CmsPage_CmsParagraph_Order', 'CmsPage_ID'));

    }
}
