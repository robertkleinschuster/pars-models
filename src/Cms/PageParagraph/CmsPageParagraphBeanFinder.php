<?php

namespace Pars\Model\Cms\PageParagraph;

use Laminas\Db\Adapter\Adapter;
use Laminas\Db\Sql\Join;
use Laminas\Db\Sql\Predicate\Expression;
use Niceshops\Bean\Finder\AbstractBeanFinder;
use Pars\Core\Database\DatabaseBeanLoader;
use Pars\Model\File\FileBeanFinder;

/**
 * Class CmsPageParagraphBeanFinder
 * @package Pars\Model\Cms\PageParagraph
 * @method CmsPageParagraphBean getBean(bool $fetchAllData = false)
 * @method CmsPageParagraphBeanList getBeanList(bool $fetchAllData = false)
 */
class CmsPageParagraphBeanFinder extends AbstractBeanFinder
{
    public function __construct(Adapter $adapter)
    {
        $loader = new DatabaseBeanLoader($adapter);
        $loader->addColumn('CmsPage_ID', 'CmsPage_ID', 'CmsPage_CmsParagraph', 'CmsPage_ID', true);
        $loader->addColumn('CmsParagraph_ID', 'CmsParagraph_ID', 'CmsPage_CmsParagraph', 'CmsParagraph_ID', true);
        $loader->addColumn('CmsParagraphState_Code', 'CmsParagraphState_Code', 'CmsParagraph', 'CmsParagraph_ID');
        $loader->addColumn('CmsParagraphType_Code', 'CmsParagraphType_Code', 'CmsParagraph', 'CmsParagraph_ID');
        $loader->addColumn('CmsParagraphType_Template')
            ->setTable('CmsParagraphType')
            ->setJoinField('CmsParagraphType_Code')
            ->setJoinTableSelf('CmsParagraph');
        $loader->addColumn('Person_ID_Create')
            ->setTable('CmsPage_CmsParagraph')
            ->setJoinField('CmsParagraph_ID');
        $loader->addColumn('Person_ID_Edit')
            ->setTable('CmsPage_CmsParagraph')
            ->setJoinField('CmsParagraph_ID');
        $loader->addColumn('Timestamp_Create')
            ->setTable('CmsPage_CmsParagraph')
            ->setJoinField('CmsParagraph_ID');
        $loader->addColumn('Timestamp_Edit')
            ->setTable('CmsPage_CmsParagraph')
            ->setJoinField('CmsParagraph_ID');
        $loader->addColumn('CmsPage_CmsParagraph_Order')
            ->setTable('CmsPage_CmsParagraph')
            ->setJoinField('CmsParagraph_ID');
        $loader->addColumn('Article_ID')
            ->setTable('CmsParagraph')
            ->setJoinField('CmsParagraph_ID')
            ->setAdditionalTableList(['Article']);
        $loader->addColumn('Article_Code')
            ->setTable('Article')
            ->setJoinField('Article_ID')
            ->setJoinTableSelf('CmsParagraph');
        $loader->addColumn('Article_Data')
            ->setTable('Article')
            ->setJoinField('Article_ID')
            ->setJoinTableSelf('CmsParagraph');
        $loader->addColumn('ArticleTranslation_Name')
            ->setTable('ArticleTranslation')
            ->setJoinField('Article_ID')
            ->setJoinTableSelf('Article');
        $loader->addColumn('ArticleTranslation_Code')
            ->setTable('ArticleTranslation')
            ->setJoinField('Article_ID')
            ->setJoinTableSelf('Article');
        $loader->addColumn('ArticleTranslation_Host')
            ->setTable('ArticleTranslation')
            ->setJoinField('Article_ID')
            ->setJoinTableSelf('Article');
        $loader->addColumn('ArticleTranslation_Active')
            ->setTable('ArticleTranslation')
            ->setJoinField('Article_ID')
            ->setJoinTableSelf('Article');
        $loader->addColumn('ArticleTranslation_Title')
            ->setTable('ArticleTranslation')
            ->setJoinField('Article_ID')
            ->setJoinTableSelf('Article');
        $loader->addColumn('ArticleTranslation_Keywords')
            ->setTable('ArticleTranslation')
            ->setJoinField('Article_ID')
            ->setJoinTableSelf('Article');
        $loader->addColumn('ArticleTranslation_Heading')
            ->setTable('ArticleTranslation')
            ->setJoinField('Article_ID')
            ->setJoinTableSelf('Article');
        $loader->addColumn('ArticleTranslation_SubHeading')
            ->setTable('ArticleTranslation')
            ->setJoinField('Article_ID')
            ->setJoinTableSelf('Article');
        $loader->addColumn('ArticleTranslation_Path')
            ->setTable('ArticleTranslation')
            ->setJoinField('Article_ID')
            ->setJoinTableSelf('Article');
        $loader->addColumn('ArticleTranslation_Teaser')
            ->setTable('ArticleTranslation')
            ->setJoinField('Article_ID')
            ->setJoinTableSelf('Article');
        $loader->addColumn('ArticleTranslation_Text')
            ->setTable('ArticleTranslation')
            ->setJoinField('Article_ID')
            ->setJoinTableSelf('Article');
        $loader->addColumn('ArticleTranslation_Footer')
            ->setTable('ArticleTranslation')
            ->setJoinField('Article_ID')
            ->setJoinTableSelf('Article');
        $loader->addColumn('Locale_Code')
            ->setTable('ArticleTranslation')
            ->setJoinField('Article_ID')
            ->setJoinTableSelf('Article');
        $loader->addColumn('File_ID')
            ->setTable('ArticleTranslation')
            ->setJoinField('Article_ID')
            ->setJoinTableSelf('Article');
        $loader->addOrder('CmsPage_CmsParagraph_Order');
        $this->addLinkedFinder(new FileBeanFinder($adapter), 'File_BeanList', 'File_ID', 'File_ID');
        parent::__construct($loader, new CmsPageParagraphBeanFactory());
    }

    /**
     * @param string $state
     */
    public function setCmsParagraphState_Code(string $state)
    {
        $this->getBeanLoader()->filterValue('CmsParagraphState_Code', $state);
        return $this;
    }

    /**
     * @param string $state
     */
    public function setArticleTranslation_Active(bool $state)
    {
        $this->getBeanLoader()->filterValue('ArticleTranslation_Active', $state);
        return $this;
    }


    public function setArticleTranslation_Host(string $articleTranslation_Host)
    {
        $this->getBeanLoader()->filterValue('ArticleTranslation_Host', $articleTranslation_Host);
        return $this;
    }

    /**
     * @param string $locale
     * @param bool $leftJoin
     * @return $this
     */
    public function setLocale_Code(string $locale, bool $leftJoin = true): self
    {
        if ($leftJoin) {
            $expression = new Expression("Article.Article_ID = ArticleTranslation.Article_ID AND ArticleTranslation.Locale_Code = ?", $locale);
            $this->getBeanLoader()->addJoinInfo('ArticleTranslation', Join::JOIN_LEFT, $expression);
        } else {
            $this->getBeanLoader()->filterValue('Locale_Code', $locale);
        }
        return $this;
    }

    /**
     * @param int $order
     */
    public function setCmsPage_CmsParagraph_Order(int $order): self
    {
        $this->getBeanLoader()->filterValue('CmsPage_CmsParagraph_Order', $order);
        return $this;
    }


    public function setCmsPage_ID(int $CmsPage_Id): self
    {
        $this->getBeanLoader()->filterValue('CmsPage_ID', $CmsPage_Id);
        return $this;
    }
}
