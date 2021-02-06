<?php

namespace Pars\Model\Cms\Post;

use Laminas\Db\Adapter\Adapter;
use Laminas\Db\Sql\Predicate\Predicate;
use Pars\Core\Database\DatabaseBeanConverter;
use Pars\Core\Database\DatabaseBeanLoader;
use Pars\Model\Article\Translation\ArticleTranslationBeanFinder;


/**
 * Class CmsPageBeanFinder
 * @package Pars\Model\Cms\Page
 * @method DatabaseBeanLoader getBeanLoader() : BeanLoaderInterface
 */
class CmsPostBeanFinder extends ArticleTranslationBeanFinder
{
    public function __construct(Adapter $adapter)
    {
        parent::__construct($adapter, new CmsPostBeanFactory());
        $loader = $this->getBeanLoader();
        if ($loader instanceof DatabaseBeanLoader) {
            $loader->addColumn('CmsPost_ID', 'CmsPost_ID', 'CmsPost', 'CmsPost_ID', true);
            $loader->addColumn('CmsPage_ID', 'CmsPage_ID', 'CmsPost', 'CmsPost_ID');
            $loader->addColumn('CmsPost_PublishTimestamp', 'CmsPost_PublishTimestamp', 'CmsPost', 'CmsPost_ID');
            $loader->addColumn('CmsPostType_Code', 'CmsPostType_Code', 'CmsPost', 'CmsPost_ID');
            $loader->addColumn('CmsPostType_Template', 'CmsPostType_Template', 'CmsPostType', 'CmsPostType_Code');
            $loader->addColumn('CmsPostState_Code', 'CmsPostState_Code', 'CmsPost', 'CmsPost_ID');
            $loader->addColumn('Article_ID', 'Article_ID', 'CmsPost', 'CmsPost_ID', false, null, ['Article', 'ArticleTranslation']);
        }
        $this->order(['CmsPost_PublishTimestamp' => self::ORDER_MODE_DESC]);
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
     * @param string $code
     * @return $this
     * @throws \Exception
     */
    public function setCmsPost_ID(int $id): self
    {
        $this->getBeanLoader()->filterValue('CmsPost_ID', $id);
        return $this;
    }

    /**
     * @param string $code
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
        $this->getBeanLoader()->filterValue((new Predicate())->lessThanOrEqualTo('CmsPost_PublishTimestamp', (new \DateTime('now', $timezone))->format(DatabaseBeanConverter::DATE_FORMAT)));
    }


}
