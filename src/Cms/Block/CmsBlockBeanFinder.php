<?php

namespace Pars\Model\Cms\Block;

use Pars\Bean\Factory\BeanFactoryInterface;
use Pars\Core\Database\DatabaseBeanLoader;
use Pars\Model\Article\Translation\ArticleTranslationBeanFinder;


/**
 * Class CmsPageBeanFinder
 * @package Pars\Model\Cms\Page
 * @method DatabaseBeanLoader getBeanLoader() : BeanLoaderInterface
 * @method CmsBlockBean getBean(bool $fetchAllData = false)
 * @method CmsBlockBeanList getBeanList(bool $fetchAllData = false)
 */
class CmsBlockBeanFinder extends ArticleTranslationBeanFinder
{


    protected function initLoader(DatabaseBeanLoader $loader)
    {
        parent::initLoader($loader);
        $loader->addColumn('CmsBlock_ID', 'CmsBlock_ID', 'CmsBlock', 'CmsBlock_ID', true);
        $loader->addField('CmsBlock_ID_Parent')->setTable('CmsBlock');
        $loader->addField('CmsBlock_Order')->setTable('CmsBlock');
        $loader->addColumn('CmsBlockType_Code', 'CmsBlockType_Code', 'CmsBlock', 'CmsBlock_ID');
        $loader->addColumn('CmsBlockType_Template', 'CmsBlockType_Template', 'CmsBlockType', 'CmsBlockType_Code', false, 'CmsBlockType_Code', [], 'CmsBlock');
        $loader->addColumn('CmsBlockState_Code', 'CmsBlockState_Code', 'CmsBlock', 'CmsBlock_ID');
        $loader->addColumn('Article_ID', 'Article_ID', 'CmsBlock', 'CmsBlock_ID', false, null, ['Article', 'ArticleTranslation']);
    }

    protected function createBeanFactory(): BeanFactoryInterface
    {
        return new CmsBlockBeanFactory();
    }


    /**
     * @param string $state
     * @return $this
     * @throws \Exception
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
    public function setCmsBlock_ID(int $id)
    {
        $this->filter(['CmsBlock_ID' => $id]);
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
