<?php

namespace Pars\Model\Cms\Block;

use Pars\Model\Article\Translation\ArticleTranslationBean;

class CmsBlockBean extends ArticleTranslationBean
{

    public ?int $CmsBlock_ID = null;
    public ?string $CmsBlockType_Code = null;
    public ?string $CmsBlockType_Template = null;
    public ?string $CmsBlockState_Code = null;
}
