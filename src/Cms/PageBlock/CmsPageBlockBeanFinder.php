<?php

namespace Pars\Model\Cms\PageBlock;

use Laminas\Db\Adapter\Adapter;
use Laminas\Db\Sql\Join;
use Laminas\Db\Sql\Predicate\Expression;
use Pars\Bean\Finder\AbstractBeanFinder;
use Pars\Core\Database\DatabaseBeanLoader;
use Pars\Core\Localization\LocaleAwareFinderInterface;
use Pars\Model\Cms\Block\CmsBlockBeanFinder;
use Pars\Model\File\FileBeanFinder;

/**
 * Class CmsPageBlockBeanFinder
 * @package Pars\Model\Cms\PageBlock
 * @method CmsPageBlockBean getBean(bool $fetchAllData = false)
 * @method CmsPageBlockBeanList getBeanList(bool $fetchAllData = false)
 */
class CmsPageBlockBeanFinder extends AbstractBeanFinder implements LocaleAwareFinderInterface
{
    public function __construct($adapter)
    {
        $loader = new DatabaseBeanLoader($adapter);
        $loader->addColumn('CmsPage_ID', 'CmsPage_ID', 'CmsPage_CmsBlock', 'CmsPage_ID', true);
        $loader->addColumn('CmsBlock_ID', 'CmsBlock_ID', 'CmsPage_CmsBlock', 'CmsBlock_ID', true);
        $loader->addColumn('CmsBlockState_Code', 'CmsBlockState_Code', 'CmsBlock', 'CmsBlock_ID');
        $loader->addColumn('CmsBlock_Order', 'CmsBlock_Order', 'CmsBlock', 'CmsBlock_ID');
        $loader->addColumn('CmsBlock_ID_Parent', 'CmsBlock_ID_Parent', 'CmsBlock', 'CmsBlock_ID');
        $loader->addColumn('CmsBlockType_Code', 'CmsBlockType_Code', 'CmsBlock', 'CmsBlock_ID');
        $loader->addColumn('CmsBlockType_Template')
            ->setTable('CmsBlockType')
            ->setJoinField('CmsBlockType_Code')
            ->setJoinTableSelf('CmsBlock');
        $loader->addColumn('Person_ID_Create')
            ->setTable('CmsPage_CmsBlock')
            ->setJoinField('CmsBlock_ID');
        $loader->addColumn('Person_ID_Edit')
            ->setTable('CmsPage_CmsBlock')
            ->setJoinField('CmsBlock_ID');
        $loader->addColumn('Timestamp_Create')
            ->setTable('CmsPage_CmsBlock')
            ->setJoinField('CmsBlock_ID');
        $loader->addColumn('Timestamp_Edit')
            ->setTable('CmsPage_CmsBlock')
            ->setJoinField('CmsBlock_ID');
        $loader->addColumn('CmsPage_CmsBlock_Order')
            ->setTable('CmsPage_CmsBlock')
            ->setJoinField('CmsBlock_ID');
        $loader->addColumn('Article_ID')
            ->setTable('CmsBlock')
            ->setJoinField('CmsBlock_ID')
            ->setAdditionalTableList(['Article']);
        $loader->addColumn('Article_Code')
            ->setTable('Article')
            ->setJoinField('Article_ID')
            ->setJoinTableSelf('CmsBlock');
        $loader->addColumn('Article_Data')
            ->setTable('Article')
            ->setJoinField('Article_ID')
            ->setJoinTableSelf('CmsBlock');
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
        $loader->addOrder('CmsPage_CmsBlock_Order');
        $this->addLinkedFinder(new FileBeanFinder($adapter), 'File_BeanList', 'File_ID', 'File_ID');
        $subBlockFinder = new CmsBlockBeanFinder($adapter);
        $subBlockFinder->order(['CmsBlock_Order']);
        $this->addLinkedFinder(
            $subBlockFinder,
            'CmsBlock_BeanList',
            'CmsBlock_ID',
            'CmsBlock_ID_Parent'
        );
        parent::__construct($loader, new CmsPageBlockBeanFactory());
    }

    /**
     * @param string $state
     */
    public function setCmsBlockState_Code(string $state)
    {
        $this->getBeanLoader()->filterValue('CmsBlockState_Code', $state);
        return $this;
    }

    /**
     * @param int $id
     * @return $this
     */
    public function setCmsBlock_ID_Parent(?int $id)
    {
        $this->filter(['CmsBlock_ID_Parent' => $id]);
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
    public function filterLocale_Code(string $locale, bool $leftJoin = true): self
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
    public function setCmsPage_CmsBlock_Order(int $order): self
    {
        $this->getBeanLoader()->filterValue('CmsPage_CmsBlock_Order', $order);
        return $this;
    }


    public function setCmsPage_ID(int $CmsPage_Id): self
    {
        $this->getBeanLoader()->filterValue('CmsPage_ID', $CmsPage_Id);
        return $this;
    }
}
