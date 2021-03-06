<?php

namespace Pars\Model\Article;

use Pars\Bean\Type\Base\BeanInterface;
use Pars\Core\Database\AbstractDatabaseBeanProcessor;
use Pars\Core\Database\DatabaseBeanSaver;
use Pars\Helper\String\StringHelper;


/**
 * Class ArticleBeanProcessor
 * @package Pars\Model\Article
 */
class ArticleBeanProcessor extends AbstractDatabaseBeanProcessor {


    protected function initSaver(DatabaseBeanSaver $saver)
    {
        $saver->addColumn('Article_ID', 'Article_ID', 'Article', 'Article_ID', true);
        $saver->addColumn('Article_Code', 'Article_Code', 'Article', 'Article_ID');
        $saver->addColumn('Article_Data', 'Article_Data', 'Article', 'Article_ID');
        $saver->addColumn('Person_ID_Create', 'Person_ID_Create', 'Article', 'Article_ID');
        $saver->addColumn('Person_ID_Edit', 'Person_ID_Edit', 'Article', 'Article_ID');
        $saver->addColumn('Timestamp_Create', 'Timestamp_Create', 'Article', 'Article_ID');
        $saver->addColumn('Timestamp_Edit', 'Timestamp_Edit', 'Article', 'Article_ID');
    }

    protected function initValidator()
    {

    }


    public function translate(string $code, array $vars = [], ?string $namespace = null): string
    {
        if ($this->hasTranslator()) {
            return $this->translateValidation($code);
        }
        return $code;
    }

    protected function beforeSave(BeanInterface $bean)
    {
        if (!$bean->empty('Article_Code')) {
            $bean->set('Article_Code', StringHelper::slugify($bean->get('Article_Code')));
        }
        parent::beforeSave($bean);
    }


    protected function validateForSave(BeanInterface $bean): bool
    {
        if ($bean->empty('Article_Code')) {
            $this->getValidationHelper()->addError('Article_Code', $this->translate('article.code.empty'));
        } else {
            $articleFinder = new ArticleBeanFinder($this->getDatabaseAdapter());
            if (!$bean->empty('Article_ID')) {
                $articleFinder->setArticle_ID($bean->get('Article_ID'), true);
            }
            $articleFinder->setArticle_Code($bean->get('Article_Code'));
            if ($articleFinder->count() > 0) {
                $this->getValidationHelper()->addError('Article_Code', $this->translate('article.code.unique'));
            }
        }

        return !$this->getValidationHelper()->hasError();
    }

    /**
     * @param BeanInterface $bean
     * @return bool
     */
    protected function validateForDelete(BeanInterface $bean): bool
    {
        return !$bean->empty('Article_ID');
    }
}
