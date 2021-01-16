<?php

namespace Pars\Model\Cms\Post;

use Pars\Model\Article\Translation\ArticleTranslationBean;

class CmsPostBean extends ArticleTranslationBean
{
    public ?int $CmsPost_ID = null;
    public ?\DateTime $CmsPost_PublishTimestamp = null;
    public ?int $CmsPage_ID = null;
    public ?string $CmsPostType_Code = null;
    public ?string $CmsPostType_Template = null;
    public ?string $CmsPostState_Code = null;
    public ?string $User_Displayname = null;
}
