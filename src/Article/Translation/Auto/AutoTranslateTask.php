<?php


namespace Pars\Model\Article\Translation\Auto;


use Pars\Bean\Type\Base\BeanInterface;
use Pars\Core\Database\AbstractDatabaseBeanFinder;
use Pars\Core\Localization\LocaleInterface;
use Pars\Core\Task\Base\AbstractTask;
use Pars\Model\Article\Translation\ArticleTranslationBean;
use Pars\Model\Article\Translation\ArticleTranslationBeanProcessor;
use Pars\Model\Cms\Block\CmsBlockBeanFinder;
use Pars\Model\Cms\Page\CmsPageBeanFinder;
use Pars\Model\Cms\Post\CmsPostBeanFinder;
use Pars\Model\Localization\Locale\LocaleBeanFinder;

class AutoTranslateTask extends AbstractTask
{
    public function execute(): void
    {
        $this->translateByFinder(CmsPageBeanFinder::class);
        $this->translateByFinder(CmsBlockBeanFinder::class);
        $this->translateByFinder(CmsPostBeanFinder::class);
    }

    protected function translateByFinder(string $finderClass)
    {

        $localeFinder = new LocaleBeanFinder($this->getDatabaseAdapter());
        $defaultLocale = $localeFinder->findLocale($this->getConfig()->get('locale.default'), null, null);
        $localeList = $localeFinder->findActiveLocaleCodeList();
        foreach ($localeList as $locale_Code) {
            if ($locale_Code != $defaultLocale->getLocale_Code()) {
                try {
                    $locale = $localeFinder->findLocale($locale_Code, null, null);
                    $beanList = $this->getArticleList($finderClass, $locale_Code);
                    foreach ($beanList as $bean) {
                        try {
                            if ($this->hasEmptyField($bean)) {
                                $this->translateFields($bean, $defaultLocale, $locale, $finderClass);
                            }
                        } catch (\Throwable $exception) {
                            $this->logger->error($exception->getMessage(), ['exception' => $exception]);
                        }
                    }
                    $articleProcessor = new ArticleTranslationBeanProcessor($this->getDatabaseAdapter());
                    $articleProcessor->setTranslator($this->getTranslator());
                    $articleProcessor->setBeanList($beanList);
                    $this->logger->info('Translated ' . $finderClass . ': ' . $articleProcessor->save());
                } catch (\Throwable $exception) {
                    $this->logger->error($exception->getMessage(), ['exception' => $exception]);
                }
            }
        }
    }

    protected function translateFields(BeanInterface $bean, LocaleInterface $defaultLocale, LocaleInterface $locale, string $finderClass)
    {
        if ($bean->empty('Locale_Code')) {
            $bean->set('Locale_Code', $locale->getLocale_Code());
        }
        $default = $this->getArticle($finderClass, $bean->get('Article_ID'), $defaultLocale->getLocale_Code());
        if ($bean->empty('ArticleTranslation_Code') && $default->isset('ArticleTranslation_Code')) {
            $text = $default->get('ArticleTranslation_Code');
            $text = $this->getTranslator()->autotranslate($text, $defaultLocale, $locale);
            $bean->set('ArticleTranslation_Code', $text);
        }
        if ($bean->empty('ArticleTranslation_Host') && $default->isset('ArticleTranslation_Host')) {
            $bean->set('ArticleTranslation_Host', $default->get('ArticleTranslation_Host'));
        }
        if ($bean->empty('ArticleTranslation_Active') && $default->isset('ArticleTranslation_Active')) {
            $bean->set('ArticleTranslation_Active', $default->get('ArticleTranslation_Active'));
        }
        if ($bean->empty('ArticleTranslation_Name') && $default->isset('ArticleTranslation_Name')) {
            $text = $default->get('ArticleTranslation_Name');
            $text = $this->getTranslator()->autotranslate($text, $defaultLocale, $locale);
            $bean->set('ArticleTranslation_Name', $text);
        }
        if ($bean->empty('ArticleTranslation_Title') && $default->isset('ArticleTranslation_Title')) {
            $text = $default->get('ArticleTranslation_Title');
            $text = $this->getTranslator()->autotranslate($text, $defaultLocale, $locale);
            $bean->set('ArticleTranslation_Title', $text);
        }
        if ($bean->empty('ArticleTranslation_Keywords') && $default->isset('ArticleTranslation_Keywords')) {
            $text = $default->get('ArticleTranslation_Keywords');
            $text = $this->getTranslator()->autotranslate($text, $defaultLocale, $locale);
            $bean->set('ArticleTranslation_Keywords', $text);
        }
        if ($bean->empty('ArticleTranslation_Heading') && $default->isset('ArticleTranslation_Heading')) {
            $text = $default->get('ArticleTranslation_Heading');
            $text = $this->getTranslator()->autotranslate($text, $defaultLocale, $locale);
            $bean->set('ArticleTranslation_Heading', $text);
        }
        if ($bean->empty('ArticleTranslation_SubHeading') && $default->isset('ArticleTranslation_SubHeading')) {
            $text = $default->get('ArticleTranslation_SubHeading');
            $text = $this->getTranslator()->autotranslate($text, $defaultLocale, $locale);
            $bean->set('ArticleTranslation_SubHeading', $text);
        }
        if ($bean->empty('ArticleTranslation_Path') && $default->isset('ArticleTranslation_Path')) {
            $bean->set('ArticleTranslation_Path', $default->get('ArticleTranslation_Path'));
        }
        if ($bean->empty('ArticleTranslation_Teaser') && $default->isset('ArticleTranslation_Teaser')) {
            $text = $default->get('ArticleTranslation_Teaser');
            $text = $this->getTranslator()->autotranslate($text, $defaultLocale, $locale);
            $bean->set('ArticleTranslation_Teaser', $text);
        }
        if ($bean->empty('ArticleTranslation_Text') && $default->isset('ArticleTranslation_Text')) {
            $text = $default->get('ArticleTranslation_Text');
            $text = $this->getTranslator()->autotranslate($text, $defaultLocale, $locale);
            $bean->set('ArticleTranslation_Text', $text);
        }
        if ($bean->empty('ArticleTranslation_Footer') && $default->isset('ArticleTranslation_Footer')) {
            $text = $default->get('ArticleTranslation_Footer');
            $text = $this->getTranslator()->autotranslate($text, $defaultLocale, $locale);
            $bean->set('ArticleTranslation_Footer', $text);
        }
        if ($bean->empty('File_ID') && $default->isset('File_ID')) {
            $bean->set('File_ID', $default->get('File_ID'));
        }

    }

    protected function hasEmptyField(ArticleTranslationBean $bean)
    {
        return $bean->empty('ArticleTranslation_Code')
            || $bean->empty('ArticleTranslation_Name')
            || $bean->empty('ArticleTranslation_Title')
            || $bean->empty('ArticleTranslation_Keywords')
            || $bean->empty('ArticleTranslation_Heading')
            || $bean->empty('ArticleTranslation_SubHeading')
            || $bean->empty('ArticleTranslation_Teaser')
            || $bean->empty('ArticleTranslation_Text')
            || $bean->empty('ArticleTranslation_Footer');
    }

    protected function getArticle(string $finderClass, int $article_Id, string $locale_Code)
    {
        $articleFinder = new $finderClass($this->getDatabaseAdapter(), false);
        $articleFinder->filterLocale_Code($locale_Code);
        $articleFinder->setArticle_ID($article_Id);
        return $articleFinder->getBean();
    }


    protected function getArticleList(string $finderClass, string $locale_Code)
    {
        $articleFinder = new $finderClass($this->getDatabaseAdapter(), false);
        $articleFinder->filterLocale_Code($locale_Code);
        return $articleFinder->getBeanList();
    }

}
