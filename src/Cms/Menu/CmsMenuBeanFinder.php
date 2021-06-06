<?php

namespace Pars\Model\Cms\Menu;

use Pars\Bean\Factory\BeanFactoryInterface;
use Pars\Core\Database\DatabaseBeanLoader;
use Pars\Model\Article\Translation\ArticleTranslationBeanFinder;

/**
 * Class CmsMenuBeanFinder
 * @package Pars\Model\Cms\Menu
 * @method CmsMenuBean getBean(bool $fetchAllData = false)
 * @method CmsMenuBeanList getBeanList(bool $fetchAllData = false)
 */
class CmsMenuBeanFinder extends ArticleTranslationBeanFinder
{
    protected function createBeanFactory(): BeanFactoryInterface
    {
        return new CmsMenuBeanFactory();
    }

    protected function initLoader(DatabaseBeanLoader $loader)
    {
        parent::initLoader($loader);
        $loader->resetDbInfo();
        $loader->addColumn('CmsMenu_ID', 'CmsMenu_ID', 'CmsMenu', 'CmsMenu_ID', true);
        $loader->addColumn('CmsMenu_ID_Parent', 'CmsMenu_ID_Parent', 'CmsMenu', 'CmsMenu_ID');
        $loader->addColumn('CmsMenu_Order', 'CmsMenu_Order', 'CmsMenu', 'CmsMenu_ID');
        $loader->addColumn('CmsMenu_Level', 'CmsMenu_Level', 'CmsMenu', 'CmsMenu_ID');
        $loader->addColumn('CmsMenu_Name', 'CmsMenu_Name', 'CmsMenu', 'CmsMenu_ID');
        $loader->addColumn('CmsMenuType_Code', 'CmsMenuType_Code', 'CmsMenu', 'CmsMenu_ID');
        $loader->addColumn('CmsMenuType_Template', 'CmsMenuType_Template', 'CmsMenuType', 'CmsMenuType_Code');
        $loader->addJoinInfo('CmsMenuType', 'left', 'CmsMenu.CmsMenuType_Code = CmsMenuType.CmsMenuType_Code');
        $loader->addJoinInfo('CmsPage', 'left', 'CmsMenu.CmsPage_ID = CmsPage.CmsPage_ID');
        $loader->addJoinInfo('Article', 'left', 'CmsPage.Article_ID = Article.Article_ID');
        $loader->addJoinInfo('ArticleTranslation', 'left', 'ArticleTranslation.Article_ID = Article.Article_ID');
        $loader->addColumn('CmsMenuState_Code', 'CmsMenuState_Code', 'CmsMenu', 'CmsMenu_ID');
        $loader->addColumn('Person_ID_Create', 'Person_ID_Create', 'CmsMenu', 'CmsMenu_ID');
        $loader->addColumn('Person_ID_Edit', 'Person_ID_Edit', 'CmsMenu', 'CmsMenu_ID');
        $loader->addColumn('Timestamp_Create', 'Timestamp_Create', 'CmsMenu', 'CmsMenu_ID');
        $loader->addColumn('Timestamp_Edit', 'Timestamp_Edit', 'CmsMenu', 'CmsMenu_ID');
        $loader->addColumn('CmsPage_ID', 'CmsPage_ID', 'CmsMenu', 'CmsMenu_ID', false, null, ['CmsPage']);
        $loader->addColumn('Article_ID', 'Article_ID', 'CmsPage', 'CmsPage_ID', false, null, ['Article']);
        $loader->addColumn('Article_Code', 'Article_Code', 'Article', 'Article_ID', false, null, [], 'CmsPage');
        $loader->addColumn('ArticleTranslation_Name', 'ArticleTranslation_Name', 'ArticleTranslation', 'Article_ID', false, null, [], 'Article');
        $loader->addColumn('ArticleTranslation_Code', 'ArticleTranslation_Code', 'ArticleTranslation', 'Article_ID', false, null, [], 'Article');
        $loader->addColumn('ArticleTranslation_Host', 'ArticleTranslation_Host', 'ArticleTranslation', 'Article_ID', false, null, [], 'Article');
        $loader->addColumn('ArticleTranslation_Active', 'ArticleTranslation_Active', 'ArticleTranslation', 'Article_ID', false, null, [], 'Article');
        $loader->addColumn('Timestamp_Edit_Article', 'Timestamp_Edit', 'Article', 'Article_ID', false, null, [], 'CmsPage');
        $loader->addColumn('Locale_Code', 'Locale_Code', 'ArticleTranslation', 'Article_ID', false, null, [], 'Article');
        $loader->addColumn('File_ID', 'File_ID', 'ArticleTranslation', 'Article_ID');
        $loader->addOrder('CmsMenu_Order');
    }


    public function setCmsMenu_Order(int $order): self
    {
        $this->getBeanLoader()->filterValue('CmsMenu_Order', $order);
        return $this;
    }

    public function setCmsMenu_ID_Parent(?int $parent): self
    {
        $this->getBeanLoader()->filterValue('CmsMenu_ID_Parent', $parent);
        return $this;
    }

    public function setCmsPage_ID_Parent(int $parent): self
    {
        $this->getBeanLoader()->filterValue('CmsPage_ID_Parent', $parent);
        return $this;
    }

    public function setCmsMenuType_Code(?string $type): self
    {
        $this->getBeanLoader()->filterValue('CmsMenuType_Code', $type);
        return $this;
    }

    public function setCmsMenuState_Code($type): self
    {
        $this->getBeanLoader()->filterValue('CmsMenuState_Code', $type);
        return $this;
    }

}
