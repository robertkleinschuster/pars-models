<?php

namespace Pars\Model\Article\Translation;

use Cocur\Slugify\Slugify;
use Laminas\Db\Adapter\Adapter;
use Niceshops\Bean\Type\Base\BeanInterface;
use Pars\Core\Database\DatabaseBeanSaver;
use Pars\Model\Article\ArticleBeanProcessor;

class ArticleTranslationBeanProcessor extends ArticleBeanProcessor
{

    /**
     * ArticleTranslationBeanProcessor constructor.
     * @param Adapter $adapter
     */
    public function __construct(Adapter $adapter)
    {
        parent::__construct($adapter);
        $this->adapter = $adapter;
        $saver = $this->getBeanSaver();
        if ($saver instanceof DatabaseBeanSaver) {
            $saver->addColumn('Article_ID', 'Article_ID', 'Article', 'Article_ID', true, null, ['ArticleTranslation']);
            $saver->addColumn('Locale_Code', 'Locale_Code', 'ArticleTranslation', 'Article_ID', true);
            $saver->addColumn('ArticleTranslation_Code', 'ArticleTranslation_Code', 'ArticleTranslation', 'Article_ID');
            $saver->addColumn('ArticleTranslation_Name', 'ArticleTranslation_Name', 'ArticleTranslation', 'Article_ID');
            $saver->addColumn('ArticleTranslation_Title', 'ArticleTranslation_Title', 'ArticleTranslation', 'Article_ID');
            $saver->addColumn('ArticleTranslation_Keywords', 'ArticleTranslation_Keywords', 'ArticleTranslation', 'Article_ID');
            $saver->addColumn('ArticleTranslation_Heading', 'ArticleTranslation_Heading', 'ArticleTranslation', 'Article_ID');
            $saver->addColumn('ArticleTranslation_SubHeading', 'ArticleTranslation_SubHeading', 'ArticleTranslation', 'Article_ID');
            $saver->addColumn('ArticleTranslation_Path', 'ArticleTranslation_Path', 'ArticleTranslation', 'Article_ID');
            $saver->addColumn('ArticleTranslation_Teaser', 'ArticleTranslation_Teaser', 'ArticleTranslation', 'Article_ID');
            $saver->addColumn('ArticleTranslation_Text', 'ArticleTranslation_Text', 'ArticleTranslation', 'Article_ID');
            $saver->addColumn('ArticleTranslation_Footer', 'ArticleTranslation_Footer', 'ArticleTranslation', 'Article_ID');
            $saver->addColumn('File_ID', 'File_ID', 'ArticleTranslation', 'File_ID', false, null, ['File'], 'ArticleTranslation');
        }
    }

    protected function beforeSave(BeanInterface $bean)
    {
        $slugify = new Slugify();
        if (!$bean->empty('ArticleTranslation_Code') && $bean->get('ArticleTranslation_Code') !== '/') {
            if (!$bean->empty('ArticleTranslation_Code')) {
                $bean->set('ArticleTranslation_Code', $slugify->slugify($bean->get('ArticleTranslation_Code')));
            } elseif (!$bean->empty('ArticleTranslation_Name')) {
                $bean->set('ArticleTranslation_Code', $slugify->slugify($bean->get('ArticleTranslation_Name')));
            } elseif (!$bean->empty('ArticleTranslation_Title')) {
                $bean->set('ArticleTranslation_Code', $slugify->slugify($bean->get('ArticleTranslation_Title')));
            }
        }
        parent::beforeSave($bean);
    }


    /**
     * @param BeanInterface $bean
     * @return bool
     */
    protected function validateForSave(BeanInterface $bean): bool
    {
        $parentResult = parent::validateForSave($bean);
        if ($bean->empty('Locale_Code')) {
            $this->getValidationHelper()->addError('Locale_Code', $this->translate('locale.code.empty'));
        }
        if ($bean->empty('ArticleTranslation_Code')) {
            $this->getValidationHelper()->addError('ArticleTranslation_Code', $this->translate('articletranslation.code.empty'));
        }
        if (!$this->getValidationHelper()->hasError()) {
            $articleTranslationFinder = new ArticleTranslationBeanFinder($this->adapter);
            if (!$bean->empty('Article_ID')) {
                $articleTranslationFinder->setArticle_ID($bean->get('Article_ID'), true);
            }
            $articleTranslationFinder->setLocale_Code($bean->get('Locale_Code'));
            $articleTranslationFinder->setArticleTranslation_Code($bean->get('ArticleTranslation_Code'));
            if ($articleTranslationFinder->count() > 0) {
                $this->getValidationHelper()->addError('ArticleTranslation_Code', $this->translate('articletranslation.code.unique'));
            }
        }
        if ($bean->empty('ArticleTranslation_Name')) {
            $this->getValidationHelper()->addError('ArticleTranslation_Name', $this->translate('articletranslation.name.empty'));
        }
        return $parentResult && !$this->getValidationHelper()->hasError();
    }

    /**
     * @param BeanInterface $bean
     * @return bool
     */
    protected function validateForDelete(BeanInterface $bean): bool
    {
        return parent::validateForDelete($bean) && !$bean->empty('Article_ID');
    }
}
