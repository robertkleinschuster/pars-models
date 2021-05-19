<?php

namespace Pars\Model\Localization\Locale;

use Laminas\Db\Adapter\Adapter;
use Laminas\Db\Sql\Predicate\Predicate;
use Pars\Bean\Factory\BeanFactoryInterface;
use Pars\Bean\Finder\AbstractBeanFinder;
use Pars\Bean\Type\Base\BeanInterface;
use Pars\Core\Cache\ParsCache;
use Pars\Core\Config\ParsConfig;
use Pars\Core\Database\AbstractDatabaseBeanFinder;
use Pars\Core\Database\DatabaseBeanLoader;
use Pars\Core\Database\ParsDatabaseAdapter;
use Pars\Core\Localization\LocaleAwareFinderInterface;
use Pars\Core\Localization\LocaleFinderInterface;
use Pars\Core\Localization\LocaleInterface;

/**
 * Class LocaleBeanFinder
 * @package Pars\Model\Localization\Locale
 * @method LocaleBean getBean(bool $fetchAllData = false)
 * @method LocaleBeanList getBeanList(bool $fetchAllData = false)
 *
 */
class LocaleBeanFinder extends AbstractDatabaseBeanFinder implements LocaleFinderInterface, LocaleAwareFinderInterface
{

    protected ParsCache $cache;

    protected function createBeanFactory(): BeanFactoryInterface
    {
        return new LocaleBeanFactory();
    }

    /**
     * @param DatabaseBeanLoader $loader
     * @return mixed|void
     */
    protected function initLoader(DatabaseBeanLoader $loader)
    {
        $loader->addField('Locale.Locale_Code')->setKey(true);
        $loader->addField('Locale.Locale_UrlCode');
        $loader->addField('Locale.Locale_Domain');
        $loader->addField('Locale.Locale_Name');
        $loader->addField('Locale.Locale_Active');
        $loader->addField('Locale.Locale_Order');
        $loader->addDefaultFields('Locale');
        $loader->addOrder('Locale_Order');
        $this->cache = new ParsCache('locale-finder');

    }

    public function initializeBeanWithAdditionlData(BeanInterface $bean): BeanInterface
    {
        $bean->set('Locale_Language', \Locale::getPrimaryLanguage($bean->Locale_Code));
        $bean->set('Locale_Region', \Locale::getRegion($bean->Locale_Code));
        return parent::initializeBeanWithAdditionlData($bean);
    }

    /**
     * @param int $order
     * @return $this
     */
    public function filterLocale_Order(int $order): self
    {
        $this->filterValue('Locale_Order', $order);
        return $this;
    }

    /**
     * @param bool $active
     * @return $this
     */
    public function filterLocale_Active(bool $active): self
    {
        $this->filterValue('Locale_Active', $active);
        return $this;
    }

    public function filterLocale_Code(string $code, bool $exclude = false): self
    {
        if ($exclude) {
            $this->excludeLocale_Code($code);
        } else {
            $this->filterValue('Locale_Code', $code);
        }
        return $this;
    }

    public function excludeLocale_Code(string $code): self
    {
        $this->excludeValue('Locale_Code', $code);
        return $this;
    }

    public function filterLocale_UrlCode(string $code): self
    {
        $this->filterValue('Locale_UrlCode', $code);
        return $this;
    }

    public function filterLocale_Language(string $language, bool $or = false): self
    {
        $this->getBeanLoader()->addLike("$language%", 'Locale_Code', $or ? Predicate::OP_OR : Predicate::OP_AND);
        return $this;
    }

    /**
     * @param string $region
     * @return $this
     */
    public function filterLocale_Region(string $region, bool $or = false): self
    {
        $this->getBeanLoader()->addLike("%$region", 'Locale_Code', $or ? Predicate::OP_OR : Predicate::OP_AND);
        return $this;
    }

    /**
     * @param string $domain
     * @return $this
     */
    public function filterLocale_Domain(string $domain): self
    {
        $this->filterValue('Locale_Domain', $domain);
        return $this;
    }

    /**
     * @param string|null $localeCode
     * @param string|null $language
     * @param $default
     * @param string|null $domain
     * @return LocaleInterface
     * @throws \Pars\Bean\Type\Base\BeanException
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function findLocaleFromDB(
        ?string $localeCode,
        ?string $language,
        $default,
        ?string $domain = null,
        ?string $configDefault = null
    ): LocaleInterface
    {
        try {
            if ($domain !== null) {
                $finder = new static($this->getDatabaseAdapter());
                $finder->filterLocale_Domain($domain);
                $finder->filterLocale_Active(true);
                if ($finder->count() > 1) {
                    $finder = new static($this->getDatabaseAdapter());
                    $finder->filterLocale_Domain($domain);
                    $finder->filterLocale_Region(\Locale::getRegion($localeCode));
                    $finder->filterLocale_Active(true);
                    if ($finder->count() == 1) {
                        return $finder->getBean();
                    } else {
                        $finder = new static($this->getDatabaseAdapter());
                        $finder->filterLocale_Domain($domain);
                        $finder->filterLocale_Language(\Locale::getPrimaryLanguage($localeCode));
                        $finder->filterLocale_Active(true);
                        if ($finder->count() == 1) {
                            return $finder->getBean();
                        } else {
                            $finder = new static($this->getDatabaseAdapter());
                            $finder->filterLocale_Domain($domain);
                            $finder->filterLocale_Active(true);
                            $finder->limit(1, 0);
                            $domain_Lang = $finder->getBean()->Locale_Language;
                            $domain_Region = $finder->getBean()->Locale_Region;
                            $finder = new static($this->getDatabaseAdapter());
                            $finder->filterLocale_Language($domain_Lang, true);
                            $finder->filterLocale_Region($domain_Region, true);
                            $finder->filterLocale_Active(true);
                            $finder->limit(1, 0);
                            return $finder->getBean();
                        }
                    }
                } else {
                    $finder->limit(1, 0);
                    if ($finder->count() == 1) {
                        return $finder->getBean();
                    }
                }
            }

            if ($localeCode !== null) {
                $finder = new static($this->getDatabaseAdapter());
                $finder->filterLocale_Code($localeCode);
                $finder->filterLocale_Active(true);
                if ($finder->count() == 1) {
                    return $finder->getBean();
                }
            }

            if ($language !== null) {
                $finder = new static($this->getDatabaseAdapter());
                $finder->filterLocale_Language($language);
                $finder->filterLocale_Active(true);
                $finder->limit(1, 0);
                return $finder->getBean();
            }

            if ($configDefault) {
                $finder = new static($this->getDatabaseAdapter());
                $finder->filterLocale_Code($configDefault);
                $finder->limit(1, 0);
                if ($finder->count() == 1) {
                    return $finder->getBean();
                }
            }

            $finder = new static($this->getDatabaseAdapter());
            $finder->filterLocale_Active(true);
            $finder->limit(1, 0);
            if ($finder->count() == 1) {
                return $finder->getBean();
            }
        } catch (\Throwable $exception) {
            $bean = $this->getBeanFactory()->getEmptyBean([]);
            $bean->set('Locale_Code', $default);
            return $bean;
        }
        $bean = $this->getBeanFactory()->getEmptyBean([]);
        $bean->set('Locale_Code', $default);
        return $bean;
    }

    public function findLocale(
        ?string $localeCode,
        ?string $language = null,
        ?string $default = null,
        ?string $domain = null,
        ?string $configDefault = null
    ): LocaleInterface {
        $cacheCode = $localeCode . $language . $default . $domain;
        if (!$this->cache->has($cacheCode)) {
            $this->cache->setBean($cacheCode, $this->findLocaleFromDB($localeCode, $language, $default, $domain));
        }
        $data = $this->cache->get($cacheCode);
        if ($data instanceof BeanInterface) {
            $data = $data->toArray(true);
        }
        return LocaleBean::createFromArray($data);
    }

    /**
     * @return LocaleBeanList
     */
    public function findActiveLocaleCodeList(): array
    {
        $finder = new static($this->getDatabaseAdapter());
        $finder->filterLocale_Active(true);
        return $finder->getBeanList()->column('Locale_Code');
    }


    /**
     * @param $language
     * @return mixed|\Pars\Bean\Type\Base\AbstractBaseBeanList
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function findLocaleListByLanguage($language)
    {
        if (!$this->cache->has($language)) {
            $localeFinder = new LocaleBeanFinder($this->getDatabaseAdapter());
            $localeFinder->filterLocale_Active(true);
            $localeFinder->filterLocale_Language($language);
            $this->cache->set($language, $localeFinder->getBeanList(true)->toArray(true));
        }
        return LocaleBeanList::createFromArray($this->cache->get($language));
    }

}
