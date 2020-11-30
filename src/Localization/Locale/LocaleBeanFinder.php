<?php

namespace Pars\Model\Localization\Locale;

use Laminas\Db\Adapter\Adapter;
use Laminas\Db\Adapter\Exception\InvalidQueryException;
use Niceshops\Bean\Finder\AbstractBeanFinder;
use Pars\Core\Database\DatabaseBeanLoader;
use Pars\Core\Localization\LocaleFinderInterface;
use Pars\Core\Localization\LocaleInterface;
use Pars\Model\Config\ConfigBeanFinder;

/**
 * Class LocaleBeanFinder
 * @package Pars\Model\Localization\Locale
 * @method LocaleBean getBean(bool $fetchAllData = false) : BeanInterface
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

    public function setLocale_Code(string $code): self
    {
        $this->getBeanLoader()->filterValue('Locale_Code', $code);
        return $this;
    }

    public function setLanguage(string $language): self
    {
        $this->getBeanLoader()->addLike("$language%", 'Locale_Code');
        return $this;
    }

    public function findLocale(?string $localeCode, ?string $language, $default): LocaleInterface
    {
        try {
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
                $finder->setLanguage($language);
                $finder->setLocale_Active(true);
                $finder->limit(1, 0);
                if ($finder->count() == 1) {
                    return $finder->getBean();
                }
            }

            $config = new ConfigBeanFinder($this->adapter);
            $config->setConfig_Code('locale.default');
            if ($config->count()) {
                $bean = $config->getBean();
                if (!$bean->empty('Config_Value')) {
                    $localeCode = $bean->get('Config_Value');
                    $finder = new static($this->adapter);
                    $finder->setLocale_Code($localeCode);
                    $finder->limit(1, 0);
                    if ($finder->count() == 1) {
                        return $finder->getBean();
                    }
                }
            }

            $finder = new static($this->adapter);
            $finder->setLocale_Active(true);
            $finder->limit(1, 0);
            if ($finder->count() == 1) {
                return $finder->getBean();
            }
        } catch (InvalidQueryException $exception) {
            $bean = $this->getBeanFactory()->getEmptyBean([]);
            $bean->set('Locale_Code', $default);
            return $bean;
        }
        $bean = $this->getBeanFactory()->getEmptyBean([]);
        $bean->set('Locale_Code', $default);
        return $bean;
    }


}
