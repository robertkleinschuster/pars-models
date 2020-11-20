<?php

namespace Pars\Model\Cms\Post;

use Pars\Model\Article\Translation\ArticleTranslationBean;

class CmsPostBean extends ArticleTranslationBean
{
    public ?int $CmsPost_ID = null;
    public ?string $CmsPostType_Code = null;
    public ?string $CmsPostState_Code = null;
}
