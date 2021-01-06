<?php

namespace Pars\Model\Cms\Paragraph;

use Pars\Model\Article\Translation\ArticleTranslationBean;

class CmsParagraphBean extends ArticleTranslationBean
{

    public ?int $CmsParagraph_ID = null;
    public ?string $CmsParagraphType_Code = null;
    public ?string $CmsParagraphType_Template = null;
    public ?string $CmsParagraphState_Code = null;
}
