<?php

namespace Pars\Model\Cms\Paragraph;

use Pars\Core\Database\DatabaseBeanLoader;
use Pars\Model\Article\Translation\ArticleTranslationBeanFinder;
use Laminas\Db\Adapter\Adapter;
use Pars\Model\File\FileBeanFinder;


/**
 * Class CmsPageBeanFinder
 * @package Pars\Model\Cms\Page
 * @method DatabaseBeanLoader getBeanLoader() : BeanLoaderInterface
 */
class CmsParagraphBeanFinder extends ArticleTranslationBeanFinder
{
    public function __construct(Adapter $adapter)
    {
        parent::__construct($adapter, new CmsParagraphBeanFactory());
        $loader = $this->getBeanLoader();
        if ($loader instanceof DatabaseBeanLoader) {
            $loader->addColumn('CmsParagraph_ID', 'CmsParagraph_ID', 'CmsParagraph', 'CmsParagraph_ID', true);
            $loader->addColumn('CmsParagraphType_Code', 'CmsParagraphType_Code', 'CmsParagraph', 'CmsParagraph_ID');
            $loader->addColumn('CmsParagraphState_Code', 'CmsParagraphState_Code', 'CmsParagraph', 'CmsParagraph_ID');
            $loader->addColumn('Article_ID', 'Article_ID', 'CmsParagraph', 'CmsParagraph_ID', false, null, ['Article', 'ArticleTranslation']);
        }
    }

    public function setCmsParagraphState_Code(string $state) {
        $this->getBeanLoader()->filterValue('CmsParagraphState_Code', $state);
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
