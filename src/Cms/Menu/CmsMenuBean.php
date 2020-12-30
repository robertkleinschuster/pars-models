<?php

namespace Pars\Model\Cms\Menu;

use Pars\Model\Article\Translation\ArticleTranslationBean;

/**
 * Class CmsMenuBean
 * @package Pars\Model\Cms\Menu
 */
class CmsMenuBean extends ArticleTranslationBean
{
    public ?int $CmsMenu_ID = null;
    public ?int $CmsMenu_ID_Parent = null;
    public ?int $CmsPage_ID = null;
    public ?int $CmsPage_ID_Parent = null;
    public ?int $CmsMenu_Order = null;
    public ?string $CmsMenuType_Code = null;
    public ?string $CmsMenuType_Template = null;
    public ?string $CmsMenuState_Code = null;
}
