<?php

namespace Pars\Model\Cms\Page;

use Pars\Model\Article\Translation\ArticleTranslationBean;

/**
 * Class CmsPageBean
 * @package Pars\Model\Cms\Page
 */
class CmsPageBean extends ArticleTranslationBean
{

    public ?int $CmsPage_ID = null;
    public ?int $CmsPage_ID_Redirect = null;
    public ?string $CmsPageType_Code = null;
    public ?string $CmsPageType_Template = null;
    public ?string $CmsPageState_Code = null;

}
