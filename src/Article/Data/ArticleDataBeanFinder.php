<?php

namespace Pars\Model\Article\Data;


use Pars\Core\Database\AbstractDatabaseBeanFinder;
use Pars\Core\Database\DatabaseBeanLoader;

/**
 * Class ArticleDataBeanFinder
 * @package Pars\Model\Article\Data
 * @method DatabaseBeanLoader getBeanLoader() : BeanLoaderInterface
 * @method ArticleDataBean getBean(bool $fetchAllData = false)
 * @method ArticleDataBeanList getBeanList(bool $fetchAllData = false)
 *
 */
class ArticleDataBeanFinder extends AbstractDatabaseBeanFinder
{
    protected function initLoader(DatabaseBeanLoader $loader)
    {
        $loader->addColumn('ArticleData_ID', 'ArticleData_ID', 'ArticleData', 'ArticleData_ID', true);
        $loader->addColumn('Article_ID', 'Article_ID', 'ArticleData', 'ArticleData_ID');
        $loader->addColumn('ArticleData_Data', 'ArticleData_Data', 'ArticleData', 'ArticleData_ID');
        $loader->addColumn('ArticleData_Active', 'ArticleData_Active', 'ArticleData', 'ArticleData_ID');
        $loader->addColumn('ArticleData_Timestamp', 'ArticleData_Timestamp', 'ArticleData', 'ArticleData_ID');
        $loader->addColumn('Person_ID_Create', 'Person_ID_Create', 'Article', 'Article_ID');
        $loader->addColumn('Person_ID_Edit', 'Person_ID_Edit', 'Article', 'Article_ID');
        $loader->addColumn('Timestamp_Create', 'Timestamp_Create', 'Article', 'Article_ID');
        $loader->addColumn('Timestamp_Edit', 'Timestamp_Edit', 'Article', 'Article_ID');
        $loader->order(['ArticleData_Timestamp' => self::ORDER_MODE_DESC]);
    }

    /**
     * @param int $id
     * @return $this
     */
    public function setArticleData_ID(int $id)
    {
        $this->filter(['ArticleData_ID' => $id]);
        return $this;
    }

    /**
     * @param int $id
     * @return $this
     */
    public function setArticle_ID(int $id)
    {
        $this->filter(['Article_ID' => $id]);
        return $this;
    }
}
