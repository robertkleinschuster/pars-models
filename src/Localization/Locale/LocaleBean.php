<?php

namespace Pars\Model\Localization\Locale;

use Niceshops\Bean\Type\Base\AbstractBaseBean;
use Pars\Core\Localization\LocaleInterface;

/**
 * Class LocaleBean
 * @package Pars\Model\Localization\Locale
 */
class LocaleBean extends AbstractBaseBean implements LocaleInterface
{
    public ?string $Locale_Code = null;
    public ?string $Locale_Name = null;
    public ?string $Locale_UrlCode = null;
    public ?bool $Locale_Active = null;
    public ?int $Locale_Order = null;

    public function getUrl_Code(): string
    {
        return $this->Locale_UrlCode;

    }

    public function getLocale_Code(): string
    {
        return $this->Locale_Code;
    }


}
