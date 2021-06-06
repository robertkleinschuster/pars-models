<?php

namespace Pars\Model\Article\Data;


use Pars\Bean\Type\Base\BeanInterface;
use Pars\Core\Database\AbstractDatabaseBeanProcessor;
use Pars\Core\Database\DatabaseBeanSaver;


class ArticleDataBeanProcessor extends AbstractDatabaseBeanProcessor
{
    protected function initSaver(DatabaseBeanSaver $saver)
    {
        $saver->addColumn('ArticleData_ID', 'ArticleData_ID', 'ArticleData', 'ArticleData_ID', true);
        $saver->addColumn('Article_ID', 'Article_ID', 'ArticleData', 'ArticleData_ID');
        $saver->addColumn('ArticleData_Data', 'ArticleData_Data', 'ArticleData', 'ArticleData_ID');
        $saver->addColumn('ArticleData_Active', 'ArticleData_Active', 'ArticleData', 'ArticleData_ID');
        $saver->addColumn('ArticleData_Timestamp', 'ArticleData_Timestamp', 'ArticleData', 'ArticleData_ID');
        $saver->addColumn('Person_ID_Create', 'Person_ID_Create', 'ArticleData', 'Article_ID');
        $saver->addColumn('Person_ID_Edit', 'Person_ID_Edit', 'ArticleData', 'Article_ID');
        $saver->addColumn('Timestamp_Create', 'Timestamp_Create', 'ArticleData', 'Article_ID');
        $saver->addColumn('Timestamp_Edit',
            'Timestamp_Edit', 'ArticleData', 'Article_ID');
    }

    protected function initValidator()
    {
    }


    protected function beforeSave(BeanInterface $bean)
    {
        if ($bean->empty('ArticleData_Timestamp')) {
            $bean->set('ArticleData_Timestamp', new \DateTime());
        }
        if ($bean->empty('ArticleData_Active')) {
            $bean->set('ArticleData_Active', true);
        }
        parent::beforeSave($bean);
    }


    /**
     * @param BeanInterface $bean
     * @return bool
     */
    protected function validateForSave(BeanInterface $bean): bool
    {
        return !$this->getValidationHelper()->hasError();
    }

    /**
     * @param BeanInterface $bean
     * @return bool
     */
    protected function validateForDelete(BeanInterface $bean): bool
    {
        return parent::validateForDelete($bean) && !$bean->empty('ArticleData_ID');
    }
}
