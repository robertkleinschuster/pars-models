<?php

namespace Pars\Model\Translation\TranslationLoader;

use Niceshops\Bean\Type\Base\AbstractBaseBean;

/**
 * Class TranslationBean
 * @package Pars\Model\Translation\TranslationLoader
 */
class TranslationBean extends AbstractBaseBean
{
    public ?int $Translation_ID = null;
    public ?string $Translation_Code = null;
    public ?string $Translation_Namespace = 'default';
    public ?string $Translation_Text = null;
    public ?string $Locale_Code = null;
    public ?\DateTime $Timestamp_Create = null;
    public ?\DateTime $Timestamp_Edit = null;
    public ?int $Person_ID_Create = null;
    public ?int $Person_ID_Edit = null;
}
