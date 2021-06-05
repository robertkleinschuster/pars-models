<?php

namespace Pars\Model\Translation\TranslationLoader;

use Laminas\Db\Adapter\Adapter;
use Laminas\I18n\Translator\Loader\RemoteLoaderInterface;
use Laminas\I18n\Translator\TextDomain;
use Pars\Bean\Factory\BeanFactoryInterface;
use Pars\Bean\Finder\AbstractBeanFinder;
use Pars\Bean\Type\Base\BeanInterface;
use Pars\Core\Cache\ParsCache;
use Pars\Core\Database\AbstractDatabaseBeanFinder;
use Pars\Core\Database\DatabaseBeanLoader;
use Pars\Core\Localization\LocaleAwareFinderInterface;

/**
 * Class TranslationBeanFinder
 * @package Pars\Model\Translation\TranslationLoader
 * @method TranslationBean getBean(bool $fetchAllData = false)
 * @method TranslationBeanList getBeanList(bool $fetchAllData = false)
 * @method TranslationBeanFactory getBeanFactory()
 */
class TranslationBeanFinder extends AbstractDatabaseBeanFinder implements LocaleAwareFinderInterface, RemoteLoaderInterface
{

    public bool $escapePlaceholder = false;


    protected function createBeanFactory(): BeanFactoryInterface
    {
        return new TranslationBeanFactory();
    }

    protected function initLoader(DatabaseBeanLoader $loader)
    {
        $loader->addColumn('Translation_ID', 'Translation_ID', 'Translation', 'Translation_ID', true);
        $loader->addColumn('Translation_Code', 'Translation_Code', 'Translation', 'Translation_ID');
        $loader->addColumn('Translation_Namespace', 'Translation_Namespace', 'Translation', 'Translation_ID');
        $loader->addColumn('Locale_Code', 'Locale_Code', 'Translation', 'Translation_ID');
        $loader->addColumn('Locale_Name', 'Locale_Name', 'Locale', 'Locale_Code');
        $loader->addColumn('Translation_Text', 'Translation_Text', 'Translation', 'Translation_ID');
        $loader->addColumn('Person_ID_Create', 'Person_ID_Create', 'Translation', 'Translation_ID');
        $loader->addColumn('Person_ID_Edit', 'Person_ID_Edit', 'Translation', 'Translation_ID');
        $loader->addColumn('Timestamp_Create', 'Timestamp_Create', 'Translation', 'Translation_ID');
        $loader->addColumn('Timestamp_Edit', 'Timestamp_Edit', 'Translation', 'Translation_ID');

    }


    /**
     * @return bool
     */
    public function isEscapePlaceholder(): bool
    {
        return $this->escapePlaceholder;
    }

    /**
     * @param bool $escapePlaceholder
     */
    public function setEscapePlaceholder(bool $escapePlaceholder): void
    {
        $this->escapePlaceholder = $escapePlaceholder;
    }

    public function initializeBeanWithAdditionlData(BeanInterface $bean): BeanInterface
    {
        if ($this->isEscapePlaceholder()) {
            if (!$bean->empty('Translation_Text')) {
                $text = $bean->get('Translation_Text');
                $text = str_replace('{', '[', $text);
                $text = str_replace('}', ']', $text);
                $bean->set('Translation_Text', $text);
            }
        }
        return parent::initializeBeanWithAdditionlData($bean);
    }


    /**
     * @param string $locale
     * @param string $textDomain
     * @return TextDomain|null
     */
    public function load($locale, $textDomain)
    {
        $data = [];
        try {
            $cacheId = $locale . $textDomain;
            static $cache = null;
            if (null == $cache) {
                $cache = new ParsCache('translation');
            }
            if ($cache->has($cacheId)) {
                $data = $cache->get($cacheId);
            } else {
                $this->filterLocale_Code($locale);
                $this->filterTranslation_Namespace($textDomain);
                foreach ($this->getBeanListDecorator() as $bean) {
                    $data[$bean->get('Translation_Code')] = $bean->get('Translation_Text');
                }
                $cache->set($cacheId, $data);
            }
        } catch (\Exception $ex) {
        }
        return new TextDomain($data);
    }

    /**
     * @param int $translation_Id
     * @param bool $exclude
     * @return $this
     */
    public function filterTranslation_ID(int $translation_Id, bool $exclude = false): self
    {
        if ($exclude) {
            $this->getBeanLoader()->excludeValue('Translation_ID', $translation_Id);
        } else {
            $this->getBeanLoader()->filterValue('Translation_ID', $translation_Id);
        }
        return $this;
    }


    /**
     * @param int $translation_Code
     * @param bool $exclude
     * @return $this
     */
    public function filterTranslation_Code(string $translation_Code, bool $exclude = false): self
    {
        if ($exclude) {
            $this->excludeTranslation_Code($translation_Code);
        } else {
            $this->filterValue('Translation_Code', $translation_Code);
        }
        return $this;
    }

    /**
     * @param string $translation_Code
     * @return $this
     */
    public function excludeTranslation_Code(string $translation_Code): self
    {
        $this->excludeValue('Translation_Code', $translation_Code);
        return $this;
    }

    /**
     * @param string $locale
     * @return $this
     */
    public function filterLocale_Code(string $locale): self
    {
        $this->getBeanLoader()->filterValue('Locale_Code', $locale);
        return $this;
    }

    /**
     * @param string $namespace
     * @return $this
     */
    public function filterTranslation_Namespace(string $namespace): self
    {
        $this->getBeanLoader()->filterValue('Translation_Namespace', $namespace);
        return $this;
    }
}
