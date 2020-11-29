<?php

namespace Pars\Model\Cms\PageParagraph;

use Niceshops\Bean\Finder\AbstractBeanFinder;
use Laminas\Db\Adapter\Adapter;
use Pars\Core\Database\DatabaseBeanLoader;
use Pars\Model\File\FileBeanFinder;

class CmsPageParagraphBeanFinder extends AbstractBeanFinder
{
    public function __construct(Adapter $adapter)
    {
        $loader = new DatabaseBeanLoader($adapter);
        $loader->addColumn('CmsPage_ID', 'CmsPage_ID', 'CmsPage_CmsParagraph', 'CmsPage_ID', true);
        $loader->addColumn('CmsParagraph_ID', 'CmsParagraph_ID', 'CmsPage_CmsParagraph', 'CmsParagraph_ID', true);
        $loader->addColumn('CmsParagraphState_Code', 'CmsParagraphState_Code', 'CmsParagraph', 'CmsParagraph_ID');
        $loader->addColumn('CmsParagraphType_Code', 'CmsParagraphType_Code', 'CmsParagraph', 'CmsParagraph_ID');
        $loader->addColumn('Person_ID_Create', 'Person_ID_Create', 'CmsPage_CmsParagraph', 'CmsParagraph_ID');
        $loader->addColumn('Person_ID_Edit', 'Person_ID_Edit', 'CmsPage_CmsParagraph', 'CmsParagraph_ID');
        $loader->addColumn('Timestamp_Create', 'Timestamp_Create', 'CmsPage_CmsParagraph', 'CmsParagraph_ID');
        $loader->addColumn('Timestamp_Edit', 'Timestamp_Edit', 'CmsPage_CmsParagraph', 'CmsParagraph_ID');
        $loader->addColumn('CmsPage_CmsParagraph_Order', 'CmsPage_CmsParagraph_Order', 'CmsPage_CmsParagraph', 'CmsParagraph_ID');
        $loader->addColumn('Article_ID', 'Article_ID', 'CmsParagraph', 'CmsParagraph_ID', false, null, ['Article']);
        $loader->addColumn('Article_Code', 'Article_Code', 'Article', 'Article_ID', false, null, [], 'CmsParagraph');
        $loader->addColumn('ArticleTranslation_Name', 'ArticleTranslation_Name', 'ArticleTranslation', 'Article_ID', false, null, [], 'Article');
        $loader->addColumn('ArticleTranslation_Code', 'ArticleTranslation_Code', 'ArticleTranslation', 'Article_ID', false, null, [], 'Article');
        $loader->addColumn('ArticleTranslation_Title', 'ArticleTranslation_Title', 'ArticleTranslation', 'Article_ID', false, null, [], 'Article');
        $loader->addColumn('ArticleTranslation_Heading', 'ArticleTranslation_Heading', 'ArticleTranslation', 'Article_ID', false, null, [], 'Article');
        $loader->addColumn('ArticleTranslation_SubHeading', 'ArticleTranslation_SubHeading', 'ArticleTranslation', 'Article_ID', false, null, [], 'Article');
        $loader->addColumn('ArticleTranslation_Path', 'ArticleTranslation_Path', 'ArticleTranslation', 'Article_ID', false, null, [], 'Article');
        $loader->addColumn('ArticleTranslation_Teaser', 'ArticleTranslation_Teaser', 'ArticleTranslation', 'Article_ID', false, null, [], 'Article');
        $loader->addColumn('ArticleTranslation_Text', 'ArticleTranslation_Text', 'ArticleTranslation', 'Article_ID', false, null, [], 'Article');
        $loader->addColumn('ArticleTranslation_Footer', 'ArticleTranslation_Footer', 'ArticleTranslation', 'Article_ID', false, null, [], 'Article');
        $loader->addColumn('Locale_Code', 'Locale_Code', 'ArticleTranslation', 'Article_ID', false, null, [], 'Article');
        $loader->addColumn('File_ID', 'File_ID', 'ArticleTranslation', 'Article_ID', false, null, [], 'Article');
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
     * @param string $locale_Code
     * @return $this
     */
    public function setLocale_Code(string $locale_Code): self
    {
        $this->getBeanLoader()->filterValue('Locale_Code', $locale_Code);
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
