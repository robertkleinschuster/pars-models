<?php

namespace Pars\Model\Cms\Post;

use Pars\Bean\Type\Base\BeanListInterface;
use Pars\Model\Article\Translation\ArticleTranslationBean;

class CmsPostBean extends ArticleTranslationBean
{
    public ?int $CmsPost_ID = null;
    public ?\DateTime $CmsPost_PublishTimestamp = null;
    public ?int $CmsPage_ID = null;
    public ?string $CmsPostType_Code = null;
    public ?string $CmsPostType_Template = null;
    public ?string $CmsPostState_Code = null;
    public ?BeanListInterface $CmsPage_BeanList = null;

    public function template()
    {
        return $this->CmsPostType_Template;
    }

    public function parent()
    {
        $result = null;
        if ($this->CmsPage_BeanList && $this->CmsPage_BeanList->count()) {
            $result = $this->CmsPage_BeanList->first();
        }
        return $result;
    }
}
