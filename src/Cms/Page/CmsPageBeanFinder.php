<?php

namespace Pars\Model\Cms\Page;

use Laminas\Db\Adapter\Adapter;
use Pars\Core\Database\DatabaseBeanLoader;
use Pars\Model\Article\Translation\ArticleTranslationBeanFinder;
use Pars\Model\Cms\PageBlock\CmsPageBlockBeanFinder;
use Pars\Model\Cms\Post\CmsPostBeanFinder;

/**
 * Class CmsPageBeanFinder
 * @package Pars\Model\Cms\Page
 * @method DatabaseBeanLoader getBeanLoader() : BeanLoaderInterface
 * @method CmsPageBean getBean(bool $fetchAllData = false)
 * @method CmsPageBeanList getBeanList(bool $fetchAllData = false)
 */
class CmsPageBeanFinder extends ArticleTranslationBeanFinder
{
    public function __construct($adapter, bool $initLinked = true)
    {
        parent::__construct($adapter, new CmsPageBeanFactory(), $initLinked);
        $loader = $this->getBeanLoader();
        if ($loader instanceof DatabaseBeanLoader) {
            $loader->addColumn('CmsPage_ID', 'CmsPage_ID', 'CmsPage', 'CmsPage_ID', true);
            $loader->addColumn('CmsPage_ID_Redirect', 'CmsPage_ID_Redirect', 'CmsPage', 'CmsPage_ID');
            $loader->addColumn('CmsPageType_Code', 'CmsPageType_Code', 'CmsPage', 'CmsPage_ID');
            $loader->addColumn('CmsPageType_Template', 'CmsPageType_Template', 'CmsPageType', 'CmsPageType_Code');
            $loader->addColumn('CmsPageLayout_Code', 'CmsPageLayout_Code', 'CmsPage', 'CmsPage_ID');
            $loader->addColumn('CmsPageLayout_Template', 'CmsPageLayout_Template', 'CmsPageLayout', 'CmsPageLayout_Code');
            $loader->addColumn('CmsPageState_Code', 'CmsPageState_Code', 'CmsPage', 'CmsPage_ID');
            $loader->addColumn('Article_ID', 'Article_ID', 'CmsPage', 'CmsPage_ID', false, null, ['Article', 'ArticleTranslation']);
        }
        if ($initLinked) {
            $pageBlockFinder = new CmsPageBlockBeanFinder($adapter);
            $pageBlockFinder->setArticleTranslation_Active(true);
            $pageBlockFinder->setCmsBlockState_Code('active');
            $this->addLinkedFinder($pageBlockFinder, 'CmsBlock_BeanList', 'CmsPage_ID', 'CmsPage_ID');
            $postFinder = new CmsPostBeanFinder($adapter);
            $postFinder->setArticleTranslation_Active(true);
            $postFinder->setCmsPostState_Code('active');
            $this->addLinkedFinder($postFinder, 'CmsPost_BeanList', 'CmsPage_ID', 'CmsPage_ID');
        }
    }

    public function initPublished(string $timezone = null)
    {
        foreach ($this->getLinkedFinderList() as $finderLink) {
            if (method_exists($finderLink->getBeanFinder(), 'initPublished')) {
                $finderLink->getBeanFinder()->initPublished($timezone);
            }
        }
    }

    public function setCmsPage_ID(int $id)
    {
        $this->getBeanLoader()->filterValue('CmsPage_ID', $id);
        return $this;
    }


    public function setCmsPageState_Code(string $state)
    {
        $this->getBeanLoader()->filterValue('CmsPageState_Code', $state);
        return $this;
    }


    /**
     * @param string $code
     * @return $this
     * @throws \Exception
     */
    public function setArticleTranslation_Code(string $code): self
    {
        $this->getBeanLoader()->filterValue('ArticleTranslation_Code', $code);
        return $this;
    }
}
