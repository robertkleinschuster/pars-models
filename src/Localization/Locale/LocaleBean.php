<?php

namespace Pars\Model\Localization\Locale;

use Pars\Bean\Type\Base\AbstractBaseBean;
use Pars\Core\Localization\LocaleInterface;

/**
 * Class LocaleBean
 * @package Pars\Model\Localization\Locale
 */
class LocaleBean extends AbstractBaseBean implements LocaleInterface
{
    public ?string $Locale_Code = null;
    public ?bool $Locale_Code_New = false;
    public ?string $Locale_Name = null;
    public ?string $Locale_Region = null;
    public ?string $Locale_Language = null;
    public ?string $Locale_Domain = null;
    public ?string $Locale_UrlCode = null;
    public ?bool $Locale_Active = null;
    public ?int $Locale_Order = null;
    public ?\DateTime $Timestamp_Create = null;
    public ?\DateTime $Timestamp_Edit = null;
    public ?int $Person_ID_Create = null;
    public ?int $Person_ID_Edit = null;

    public function getUrl_Code(): string
    {
        return $this->Locale_UrlCode;

    }

    public function getLocale_Code(): string
    {
        return $this->Locale_Code;
    }

    public function __toString()
    {
        return $this->getLocale_Code();
    }

    public function getLocale_Language(): string
    {
        return $this->Locale_Language;
    }

    public function getLocale_Region(): string
    {
        return $this->Locale_Region;
    }


    public function language()
    {
        return $this->getLocale_Language();
    }


    public function code()
    {
        return $this->getLocale_Code();
    }

    public function url()
    {
        return $this->getUrl_Code();
    }

    public function name()
    {
        return $this->Locale_Name;
    }


    public function domain()
    {
        return $this->Locale_Domain;
    }

    public function region()
    {
        return $this->getLocale_Region();
    }
}
