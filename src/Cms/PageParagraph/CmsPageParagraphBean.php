<?php

namespace Pars\Model\Cms\PageParagraph;

use Pars\Model\Article\Translation\ArticleTranslationBean;

/**
 * Class CmsPageParagraphBean
 * @package Pars\Model\Cms\PageParagraph
 */
class CmsPageParagraphBean extends ArticleTranslationBean
{
    public ?int $CmsParagraph_ID = null;
    public ?string $CmsParagraphType_Code = null;
    public ?string $CmsParagraphState_Code = null;
    public ?int $CmsPage_ID = null;
    public ?int $CmsPage_CmsParagraph_Order = null;
}
