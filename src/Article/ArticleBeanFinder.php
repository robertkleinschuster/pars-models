<?php

namespace Pars\Model\Article;

use Pars\Bean\Factory\BeanFactoryInterface;
use Pars\Core\Database\AbstractDatabaseBeanFinder;
use Pars\Core\Database\DatabaseBeanLoader;
use Pars\Model\Article\Data\ArticleDataBeanFinder;
use Pars\Model\Article\Picture\ArticlePictureBeanFinder;

/**
 * Class ArticleBeanFinder
 * @package Pars\Model\Article
 * @method ArticleBean getBean(bool $fetchAllData = false)
 * @method ArticleBeanList getBeanList(bool $fetchAllData = false)
 */
class ArticleBeanFinder extends AbstractDatabaseBeanFinder
{
    protected function initLinkedFinder()
    {
        $this->addLinkedFinder(new ArticleDataBeanFinder($this->getDatabaseAdapter()), 'ArticleData_BeanList', 'Article_ID', 'Article_ID');
        $this->addLinkedFinder(new ArticlePictureBeanFinder($this->getDatabaseAdapter()), 'ArticlePicture_BeanList', 'Article_ID', 'Article_ID');
    }


    protected function createBeanFactory(): BeanFactoryInterface
    {
        return new ArticleBeanFactory();
    }

    protected function initLoader(DatabaseBeanLoader $loader)
    {
        $loader->addColumn('Article_ID', 'Article_ID', 'Article', 'Article_ID', true);
        $loader->addColumn('Article_Code', 'Article_Code', 'Article', 'Article_ID');
        $loader->addColumn('Article_Data', 'Article_Data', 'Article', 'Article_ID');
        $loader->addColumn('Person_ID_Create', 'Person_ID_Create', 'Article', 'Article_ID');
        $loader->addColumn('Person_ID_Edit', 'Person_ID_Edit', 'Article', 'Article_ID');
        $loader->addColumn('Timestamp_Create', 'Timestamp_Create', 'Article', 'Article_ID');
        $loader->addColumn('Timestamp_Edit', 'Timestamp_Edit', 'Article', 'Article_ID');
    }


    public function loadStatistic(string $group, string $alias)
    {
        $loader = $this->getBeanLoader();
        if ($loader instanceof DatabaseBeanLoader) {
            $loader->addCustomColumn("
SELECT COUNT(*) AS FrontendStatistic_Count
FROM FrontendStatistic 
WHERE FrontendStatistic.FrontendStatistic_Reference = Article.Article_Code 
  AND  FrontendStatistic.FrontendStatistic_Group = '$group'
", $alias);
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
