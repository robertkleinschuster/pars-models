<?php

namespace Pars\Model\Article\Translation;

use Pars\Bean\Factory\BeanFactoryInterface;
use Pars\Core\Database\DatabaseBeanLoader;
use Pars\Core\Localization\LocaleAwareFinderInterface;
use Pars\Model\Article\ArticleBeanFinder;
use Pars\Model\Localization\Locale\LocaleBeanFinder;

/**
 * Class ArticleTranslationBeanFinder
 * @package Pars\Model\Article\Translation
 * @method DatabaseBeanLoader getBeanLoader() : BeanLoaderInterface
 * @method ArticleTranslationBean getBean(bool $fetchAllData = false)
 * @method ArticleTranslationBeanList getBeanList(bool $fetchAllData = false)
 */
class ArticleTranslationBeanFinder extends ArticleBeanFinder implements LocaleAwareFinderInterface
{
    protected function createBeanFactory(): BeanFactoryInterface
    {
        return new ArticleTranslationBeanFactory();
    }


    protected function initLoader(DatabaseBeanLoader $loader)
    {
        parent::initLoader($loader);
        $loader->addColumn('Article_ID', 'Article_ID', 'ArticleTranslation', 'Article_ID', true);
        $loader->addColumn('Locale_Code', 'Locale_Code', 'ArticleTranslation', 'Article_ID', true);
        $loader->addColumn('ArticleTranslation_Code', 'ArticleTranslation_Code', 'ArticleTranslation', 'Article_ID');
        $loader->addColumn('ArticleTranslation_Host', 'ArticleTranslation_Host', 'ArticleTranslation', 'Article_ID');
        $loader->addColumn('ArticleTranslation_Active', 'ArticleTranslation_Active', 'ArticleTranslation', 'Article_ID');
        $loader->addColumn('ArticleTranslation_Name', 'ArticleTranslation_Name', 'ArticleTranslation', 'Article_ID');
        $loader->addColumn('ArticleTranslation_Title', 'ArticleTranslation_Title', 'ArticleTranslation', 'Article_ID');
        $loader->addColumn('ArticleTranslation_Keywords', 'ArticleTranslation_Keywords', 'ArticleTranslation', 'Article_ID');
        $loader->addColumn('ArticleTranslation_Heading', 'ArticleTranslation_Heading', 'ArticleTranslation', 'Article_ID');
        $loader->addColumn('ArticleTranslation_SubHeading', 'ArticleTranslation_SubHeading', 'ArticleTranslation', 'Article_ID');
        $loader->addColumn('ArticleTranslation_Path', 'ArticleTranslation_Path', 'ArticleTranslation', 'Article_ID');
        $loader->addColumn('ArticleTranslation_Teaser', 'ArticleTranslation_Teaser', 'ArticleTranslation', 'Article_ID');
        $loader->addColumn('ArticleTranslation_Text', 'ArticleTranslation_Text', 'ArticleTranslation', 'Article_ID');
        $loader->addColumn('ArticleTranslation_Footer', 'ArticleTranslation_Footer', 'ArticleTranslation', 'Article_ID');
        $loader->addColumn('File_ID', 'File_ID', 'ArticleTranslation', 'Article_ID');

    }


    /**
     * @param string $code
     * @param bool $leftJoin
     * @return $this
     * @throws \Exception
     */
    public function filterLocale_Code(string $code, bool $leftJoin = true): self
    {
        if ($leftJoin) {
            $this->getBeanLoader()->addJoinInfo('ArticleTranslation', 'left', ['Locale_Code' => $code]);
        } else {
            $this->getBeanLoader()->filterValue('Locale_Code', $code);
        }
        foreach ($this->getLinkedFinderList() as $finderLink) {
            $linkedFinder = $finderLink->getBeanFinder();
            if ($linkedFinder instanceof LocaleAwareFinderInterface) {
                $linkedFinder->filterLocale_Code($code, $leftJoin);
            }
        }
        return $this;
    }

    /**
     * @param string $articleTranslation_Code
     * @return $this
     */
    public function setArticleTranslation_Code(string $articleTranslation_Code)
    {
        $this->getBeanLoader()->filterValue('ArticleTranslation_Code', $articleTranslation_Code);
        return $this;
    }

    /**
     * @param string $articleTranslation_Code
     * @return $this
     */
    public function setArticleTranslation_Host(string $articleTranslation_Host)
    {
        $this->getBeanLoader()->filterValue('ArticleTranslation_Host', $articleTranslation_Host);
        foreach ($this->getLinkedFinderList() as $finderLink) {
            if (method_exists($finderLink->getBeanFinder(), 'setArticleTranslation_Host')) {
                $finderLink->getBeanFinder()->setArticleTranslation_Host($articleTranslation_Host);
            }
        }
        return $this;
    }

    /**
     * @param string $articleTranslation_Code
     * @return $this
     */
    public function setArticleTranslation_Active($articleTranslation_Active)
    {
        $this->getBeanLoader()->filterValue('ArticleTranslation_Active', $articleTranslation_Active);
        foreach ($this->getLinkedFinderList() as $finderLink) {
            if (method_exists($finderLink->getBeanFinder(), 'setArticleTranslation_Active')) {
                $finderLink->getBeanFinder()->setArticleTranslation_Active($articleTranslation_Active);
            }
        }
        return $this;
    }

    /**
     * @param string $localeCode
     * @param string $fallback
     */
    public function filterLocale_Code_WithFallback(string $localeCode, string $fallback)
    {
        $this->filterLocale_Code($localeCode, false);
        $count = $this->count();
        if ($count == 0) {
            // Find similar locales
            $language = \Locale::getPrimaryLanguage($localeCode);
            $list = $this->findLocaleListByLanguage($language);
            foreach ($list as $localeBean) {
                $this->filterLocale_Code($localeBean->get('Locale_Code'), false);
                $count = $this->count();
                if ($count > 0) {
                    return $count;
                }
            }
            $this->filterLocale_Code($fallback, false);
            return $this->count();
        } else {
            return $count;
        }
    }

    /**
     * @param $language
     * @return mixed|\Pars\Bean\Type\Base\AbstractBaseBeanList
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function findLocaleListByLanguage($language)
    {
        $localeFinder = new LocaleBeanFinder($this->getDatabaseAdapter());
        return $localeFinder->findLocaleListByLanguage($language);
    }
}
