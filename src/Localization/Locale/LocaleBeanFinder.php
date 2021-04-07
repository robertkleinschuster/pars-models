<?php

namespace Pars\Model\Localization\Locale;

use Laminas\Db\Adapter\Adapter;
use Laminas\Db\Adapter\Exception\InvalidQueryException;
use Laminas\Db\Sql\Predicate\Predicate;
use Niceshops\Bean\Finder\AbstractBeanFinder;
use Niceshops\Bean\Type\Base\BeanInterface;
use Pars\Core\Config\ParsConfig;
use Pars\Core\Database\DatabaseBeanLoader;
use Pars\Core\Localization\LocaleFinderInterface;
use Pars\Core\Localization\LocaleInterface;

/**
 * Class LocaleBeanFinder
 * @package Pars\Model\Localization\Locale
 * @method LocaleBean getBean(bool $fetchAllData = false)
 * @method LocaleBeanList getBeanList(bool $fetchAllData = false)
 *
 */
class LocaleBeanFinder extends AbstractBeanFinder implements LocaleFinderInterface
{

    protected $adapter;

    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
        $loader = new DatabaseBeanLoader($adapter);
        $loader->addColumn('Locale_Code', 'Locale_Code', 'Locale', 'Locale_Code', true);
        $loader->addColumn('Locale_UrlCode', 'Locale_UrlCode', 'Locale', 'Locale_Code');
        $loader->addColumn('Locale_Name', 'Locale_Name', 'Locale', 'Locale_Code');
        $loader->addColumn('Locale_Active', 'Locale_Active', 'Locale', 'Locale_Code');
        $loader->addColumn('Locale_Order', 'Locale_Order', 'Locale', 'Locale_Code');
        $loader->addColumn('Person_ID_Create', 'Person_ID_Create', 'Locale', 'Locale_Code');
        $loader->addColumn('Person_ID_Edit', 'Person_ID_Edit', 'Locale', 'Locale_Code');
        $loader->addColumn('Timestamp_Create', 'Timestamp_Create', 'Locale', 'Locale_Code');
        $loader->addColumn('Timestamp_Edit', 'Timestamp_Edit', 'Locale', 'Locale_Code');
        $loader->addField('Locale_Domain')->setTable('Locale');
        $loader->addOrder('Locale_Order');
        parent::__construct($loader, new LocaleBeanFactory());
    }

    public function setLocale_Order(int $order)
    {
        $this->getBeanLoader()->filterValue('Locale_Order', $order);
        return $this;
    }

    public function setLocale_Active(bool $active): self
    {
        $this->getBeanLoader()->filterValue('Locale_Active', $active);
        return $this;
    }

    public function setLocale_Code(string $code, bool $exclude = false): self
    {
        if ($exclude) {
            $this->getBeanLoader()->excludeValue('Locale_Code', $code);
        } else {
            $this->getBeanLoader()->filterValue('Locale_Code', $code);
        }
        return $this;
    }

    public function setLocale_UrlCode(string $code): self
    {
        $this->getBeanLoader()->filterValue('Locale_UrlCode', $code);
        return $this;
    }

    public function setLocale_Language(string $language, bool $or = false): self
    {
        $this->getBeanLoader()->addLike("$language%", 'Locale_Code', $or ? Predicate::OP_OR : Predicate::OP_AND);
        return $this;
    }

    /**
     * @param string $region
     * @return $this
     */
    public function setLocale_Region(string $region, bool $or = false): self
    {
        $this->getBeanLoader()->addLike("%$region", 'Locale_Code', $or ? Predicate::OP_OR : Predicate::OP_AND);
        return $this;
    }

    public function initializeBeanWithAdditionlData(BeanInterface $bean): BeanInterface
    {
        $bean->set('Locale_Language', \Locale::getPrimaryLanguage($bean->Locale_Code));
        $bean->set('Locale_Region', \Locale::getRegion($bean->Locale_Code));
        return parent::initializeBeanWithAdditionlData($bean);
    }


    /**
     * @param string $domain
     * @return $this
     */
    public function setLocale_Domain(string $domain): self
    {
        $this->filter(['Locale_Domain' => $domain]);
        return $this;
    }

    /**
     * @param string|null $localeCode
     * @param string|null $language
     * @param $default
     * @param string|null $domain
     * @return LocaleInterface
     * @throws \Niceshops\Bean\Type\Base\BeanException
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function findLocale(
        ?string $localeCode,
        ?string $language,
        $default,
        ?string $domain = null
    ): LocaleInterface
    {
        try {
            if ($domain !== null) {
                $finder = new static($this->adapter);
                $finder->setLocale_Domain($domain);
                $finder->setLocale_Active(true);
                if ($finder->count() > 1) {
                    $finder = new static($this->adapter);
                    $finder->setLocale_Domain($domain);
                    $finder->setLocale_Region(\Locale::getRegion($localeCode));
                    $finder->setLocale_Active(true);
                    if ($finder->count() == 1) {
                        return $finder->getBean();
                    } else {
                        $finder = new static($this->adapter);
                        $finder->setLocale_Domain($domain);
                        $finder->setLocale_Language(\Locale::getPrimaryLanguage($localeCode));
                        $finder->setLocale_Active(true);
                        if ($finder->count() == 1) {
                            return $finder->getBean();
                        } else {
                            $finder = new static($this->adapter);
                            $finder->setLocale_Domain($domain);
                            $finder->setLocale_Active(true);
                            $finder->limit(1, 0);
                            $domain_Lang = $finder->getBean()->Locale_Language;
                            $domain_Region = $finder->getBean()->Locale_Region;
                            $finder = new static($this->adapter);
                            $finder->setLocale_Language($domain_Lang, true);
                            $finder->setLocale_Region($domain_Region, true);
                            $finder->setLocale_Active(true);
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
                $finder = new static($this->adapter);
                $finder->setLocale_Code($localeCode);
                $finder->setLocale_Active(true);
                if ($finder->count() == 1) {
                    return $finder->getBean();
                }
            }

            if ($language !== null) {
                $finder = new static($this->adapter);
                $finder->setLocale_Language($language);
                $finder->setLocale_Active(true);
                $finder->limit(1, 0);
                return $finder->getBean();
            }

            $config = new ParsConfig($this->adapter);
            $configDefault = $config->get('locale.default');
            if ($configDefault) {
                $finder = new static($this->adapter);
                $finder->setLocale_Code($configDefault);
                $finder->limit(1, 0);
                if ($finder->count() == 1) {
                    return $finder->getBean();
                }
            }

            $finder = new static($this->adapter);
            $finder->setLocale_Active(true);
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


}
