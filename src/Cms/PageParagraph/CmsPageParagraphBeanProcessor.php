<?php

namespace Pars\Model\Cms\PageParagraph;

use Laminas\Db\Adapter\Adapter;
use Niceshops\Bean\Type\Base\BeanInterface;
use Niceshops\Bean\Processor\AbstractBeanProcessor;
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
        parent::__construct($saver);
    }

    protected function beforeSave(BeanInterface $bean)
    {
        if ($bean->empty('CmsPage_CmsParagraph_Order') || $bean->get('CmsPage_CmsParagraph_Order') === 0) {
            $order = 1;
            $finder = new CmsPageParagraphBeanFinder($this->adapter);
            $finder->setCmsPage_ID($bean->get('CmsPage_ID'));
            $finder->getBeanLoader()->addOrder('CmsPage_CmsParagraph_Order', true);
            $finder->limit(1, 0);
            if ($finder->count()) {
                $lastBean = $finder->getBean();
                if (!$lastBean->empty('CmsPage_CmsParagraph_Order')) {
                    $order = $lastBean->get('CmsPage_CmsParagraph_Order') + 1;
                }
            }
            $bean->set('CmsPage_CmsParagraph_Order', $order);
        }
        parent::beforeSave($bean);
    }
}
