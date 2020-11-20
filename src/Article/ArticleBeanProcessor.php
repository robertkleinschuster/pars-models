<?php

namespace Pars\Model\Article;

use Cocur\Slugify\Slugify;
use Laminas\Db\Adapter\Adapter;
use Laminas\I18n\Translator\TranslatorAwareInterface;
use Laminas\I18n\Translator\TranslatorAwareTrait;
use Niceshops\Bean\Processor\AbstractBeanProcessor;
use Niceshops\Bean\Type\Base\BeanInterface;
use Pars\Core\Database\DatabaseBeanSaver;
use Pars\Helper\Validation\ValidationHelperAwareInterface;
use Pars\Helper\Validation\ValidationHelperAwareTrait;


/**
 * Class ArticleBeanProcessor
 * @package Pars\Model\Article
 */
class ArticleBeanProcessor extends AbstractBeanProcessor implements
    ValidationHelperAwareInterface,
    TranslatorAwareInterface
{
    use ValidationHelperAwareTrait;
    use TranslatorAwareTrait;

    protected $adapter;

    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
        $saver = new DatabaseBeanSaver($adapter);
        $saver->addColumn('Article_ID', 'Article_ID', 'Article', 'Article_ID', true);
        $saver->addColumn('Article_Code', 'Article_Code', 'Article', 'Article_ID');
        parent::__construct($saver);
    }

    protected function translate(string $name): string
    {
        return $this->getTranslator()->translate($name, 'validation');
    }

    protected function beforeSave(BeanInterface $bean)
    {
        $slugify = new Slugify();
        if (!$bean->empty('Article_Code')) {
            $bean->set('Article_Code', $slugify->slugify($bean->get('Article_Code')));
        }
        parent::beforeSave($bean);
    }


    protected function validateForSave(BeanInterface $bean): bool
    {
        if ($bean->empty('Article_Code')) {
            $this->getValidationHelper()->addError('Article_Code', $this->translate('article.code.empty'));
        } else {
            $articleFinder = new ArticleBeanFinder($this->adapter);
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
