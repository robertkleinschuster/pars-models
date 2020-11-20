<?php

namespace Pars\Model\Cms\Post;

use Pars\Core\Database\DatabaseBeanLoader;
use Pars\Model\Article\Translation\ArticleTranslationBeanFinder;
use Laminas\Db\Adapter\Adapter;


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
            $loader->addColumn('CmsPostType_Code', 'CmsPostType_Code', 'CmsPost', 'CmsPost_ID');
            $loader->addColumn('CmsPostState_Code', 'CmsPostState_Code', 'CmsPost', 'CmsPost_ID');
            $loader->addColumn('Article_ID', 'Article_ID', 'CmsPost', 'CmsPost_ID', false, null, ['Article', 'ArticleTranslation']);
        }
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
