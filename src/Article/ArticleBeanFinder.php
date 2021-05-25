<?php

namespace Pars\Model\Article;

use Laminas\Db\Adapter\Adapter;
use Pars\Bean\Factory\BeanFactoryInterface;
use Pars\Bean\Finder\AbstractBeanFinder;
use Pars\Bean\Loader\BeanLoaderInterface;
use Pars\Core\Database\DatabaseBeanLoader;
use Pars\Model\Article\Data\ArticleDataBeanFinder;
use Pars\Model\Article\Picture\ArticlePictureBeanFinder;

/**
 * Class ArticleBeanFinder
 * @package Pars\Model\Article
 * @method ArticleBean getBean(bool $fetchAllData = false)
 * @method ArticleBeanList getBeanList(bool $fetchAllData = false)
 */
class ArticleBeanFinder extends AbstractBeanFinder
{
    public function __construct($adapter, BeanFactoryInterface $beanFactory = null, bool $initLinked = true)
    {
        $loader = new DatabaseBeanLoader($adapter);
        $loader->addColumn('Article_ID', 'Article_ID', 'Article', 'Article_ID', true);
        $loader->addColumn('Article_Code', 'Article_Code', 'Article', 'Article_ID');
        $loader->addColumn('Article_Data', 'Article_Data', 'Article', 'Article_ID');
        $loader->addColumn('Person_ID_Create', 'Person_ID_Create', 'Article', 'Article_ID');
        $loader->addColumn('Person_ID_Edit', 'Person_ID_Edit', 'Article', 'Article_ID');
        $loader->addColumn('Timestamp_Create', 'Timestamp_Create', 'Article', 'Article_ID');
        $loader->addColumn('Timestamp_Edit', 'Timestamp_Edit', 'Article', 'Article_ID');
        parent::__construct($loader, $beanFactory ?? new ArticleBeanFactory());
        if ($initLinked) {
            $this->addLinkedFinder(new ArticleDataBeanFinder($adapter), 'ArticleData_BeanList', 'Article_ID', 'Article_ID');
            $this->addLinkedFinder(new ArticlePictureBeanFinder($adapter), 'ArticlePicture_BeanList', 'Article_ID', 'Article_ID');
        }
    }

    /**
     * @param string $articleCode
     * @return $this
     */
    public function setArticle_Code(string $articleCode): self
    {
        $this->getBeanLoader()->filterValue('Article_Code', $articleCode);
        return $this;
    }

    /**
     * @param array $articleCode_List
     * @return $this
     */
    public function setArticle_Code_List(array $articleCode_List): self
    {
        $this->getBeanLoader()->filter(['Article_Code' => $articleCode_List], self::FILTER_MODE_AND);
        return $this;
    }

    /**
     * @param int $article_id
     * @param bool $exclude
     * @return $this
     * @throws \Exception
     */
    public function setArticle_ID(int $article_id, bool $exclude = false): self
    {
        if ($exclude) {
            $this->getBeanLoader()->excludeValue('Article_ID', $article_id);
        } else {
            $this->getBeanLoader()->filterValue('Article_ID', $article_id);
        }
        return $this;
    }
}
