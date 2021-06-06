<?php

namespace Pars\Model\Cms\Post;

use Pars\Bean\Factory\BeanFactoryInterface;
use Pars\Bean\Finder\FilterExpression;
use Pars\Bean\Finder\FilterIdentifier;
use Pars\Core\Database\DatabaseBeanLoader;
use Pars\Model\Article\Translation\ArticleTranslationBeanFinder;


/**
 * Class CmsPageBeanFinder
 * @package Pars\Model\Cms\Page
 * @method DatabaseBeanLoader getBeanLoader() : BeanLoaderInterface
 * @method CmsPostBean getBean(bool $fetchAllData = false)
 * @method CmsPostBeanList getBeanList(bool $fetchAllData = false)
 */
class CmsPostBeanFinder extends ArticleTranslationBeanFinder
{
    protected function initLoader(DatabaseBeanLoader $loader)
    {
        parent::initLoader($loader);
        $loader->addColumn('CmsPost_ID', 'CmsPost_ID', 'CmsPost', 'CmsPost_ID', true);
        $loader->addColumn('CmsPage_ID', 'CmsPage_ID', 'CmsPost', 'CmsPost_ID');
        $loader->addColumn('CmsPost_PublishTimestamp', 'CmsPost_PublishTimestamp', 'CmsPost', 'CmsPost_ID');
        $loader->addColumn('CmsPostType_Code', 'CmsPostType_Code', 'CmsPost', 'CmsPost_ID');
        $loader->addColumn('CmsPostType_Template', 'CmsPostType_Template', 'CmsPostType', 'CmsPostType_Code');
        $loader->addColumn('CmsPostState_Code', 'CmsPostState_Code', 'CmsPost', 'CmsPost_ID');
        $loader->addColumn('Article_ID')
            ->setTable('CmsPost')
            ->setJoinField('CmsPost_ID')
            ->setAdditionalTableList(['Article', 'ArticleTranslation']);
        $loader->order(['CmsPost_PublishTimestamp' => self::ORDER_MODE_DESC]);
    }

    protected function createBeanFactory(): BeanFactoryInterface
    {
        return new CmsPostBeanFactory();
    }


    /**
     * @param string $code
     * @return $this
     * @throws \Exception
     */
    public function setCmsPostState_Code(string $code): self
    {
        $this->getBeanLoader()->filterValue('CmsPostState_Code', $code);
        return $this;
    }

    /**
     * @param int $id
     * @return $this
     * @throws \Exception
     */
    public function setCmsPost_ID(int $id): self
    {
        $this->getBeanLoader()->filterValue('CmsPost_ID', $id);
        return $this;
    }

    /**
     * @param int $id
     * @return $this
     * @throws \Exception
     */
    public function setCmsPage_ID(int $id): self
    {
        $this->getBeanLoader()->filterValue('CmsPage_ID', $id);
        return $this;
    }

    /**
     * @throws \Exception
     */
    public function initPublished(string $timezone = null)
    {
        if ($timezone) {
            $timezone = new \DateTimeZone($timezone);
        }
        $this->filterExpression(FilterExpression::lessThanOrEqual(
            FilterIdentifier::create('CmsPost_PublishTimestamp'),
            new \DateTime('now', $timezone)
        ));
    }
}
