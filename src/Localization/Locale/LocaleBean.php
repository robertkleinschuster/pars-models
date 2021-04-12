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


}
